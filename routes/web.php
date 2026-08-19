<?php

use App\Models\About;
use App\Models\Contact;
use App\Models\Category;
use App\Models\Download;
use App\Models\Guide;
use App\Models\HomepageFeatureSection;
use App\Models\Homepage;
use App\Models\Person;
use App\Models\Project;
use App\Models\Sector;
use App\Models\SiteSetting;
use App\Models\HomepageFeature;
use App\Models\Office;
use Illuminate\Support\Facades\Route;

Route::get('/site.css', function () {
    return response()->file(resource_path('css/site.css'), ['Content-Type' => 'text/css; charset=UTF-8']);
})->name('site.css');

// 언어 전환 (세션에 저장 → SetLocale 미들웨어가 적용)
Route::get('/lang/{locale}', function (string $locale) {
    if (in_array($locale, ['ko', 'en'], true)) {
        session(['locale' => $locale]);
    }

    return redirect()->back();
})->name('locale.switch');

Route::get('/', function () {
    $homepage = Homepage::query()->first();
    $asFeature = fn ($project) => (object) ['project' => $project, 'title' => null, 'description' => null];

    // 홈 Featured 섹션은 Homepage 블록 에디터로 관리됩니다.
    // 각 'featured_section' 블록이 제목·설명·표시 스타일과 연결된 프로젝트를 가집니다.
    $featureBands = ($homepage
            ? $homepage->blocks()->where('type', 'featured_section')->orderBy('position')->get()
            : collect())
        ->map(function ($block) use ($asFeature) {
            $features = $block->getRelated('projects')
                ->filter(fn (Project $project) => $project->published)
                ->map($asFeature)
                ->values();

            return [
                'features' => $features,
                'section' => (object) [
                    'title' => $block->input('title'),
                    'description' => $block->input('description'),
                    'layout_style' => $block->input('layout_style') ?: 'carousel',
                    'card_ratio' => $block->input('card_ratio') ?: 'wide',
                    'cards_per_view' => $block->input('cards_per_view') ?: '4',
                    'bg_color' => $block->input('bg_color'),
                    'neat_config' => trim((string) $block->input('neat_config')),
                ],
                'key' => 'sec-'.$block->id,
            ];
        })
        ->filter(fn ($band) => $band['features']->isNotEmpty())
        ->values();

    // 인터랙티브 히어로("We design [Discipline] for [Sector]") — 관리자 > Homepage에서 켜면
    // 태그 기반으로 선택 조합에 맞는 공개 프로젝트를 배경 슬라이드쇼로 노출합니다.
    $heroBuilder = null;
    if ($homepage?->hero_builder) {
        $heroBuilder = [
            'categories' => Category::query()->where('published', true)->orderBy('position')->get(),
            'sectors' => Sector::query()->where('published', true)->orderBy('position')->get(),
            'projects' => Project::query()->where('published', true)
                ->with(['categories:id', 'sectors:id'])
                ->orderBy('position')->get(),
            'defaultCategoryId' => $homepage->hero_default_category_id,
            'defaultSectorId' => $homepage->hero_default_sector_id,
        ];
    }

    return view('site.home', [
        'featureBands' => $featureBands,
        'heroBuilder' => $heroBuilder,
    ]);
})->name('home');

Route::get('/about', function () {
    return view('site.about', [
        'about' => About::query()->first(),
        'people' => Person::query()->where('published', true)->orderBy('position')->orderBy('title')->get(),
    ]);
})->name('about');

Route::get('/people/{identifier}', function (string $identifier) {
    // 슬러그 우선 조회 후 숫자 ID로 폴백 — 숫자형 슬러그도 안전하게 처리.
    $item = Person::query()->forSlug($identifier)->where('published', true)->first();

    if (! $item && ctype_digit($identifier)) {
        $item = Person::query()->whereKey($identifier)->where('published', true)->first();
    }

    abort_if(! $item, 404);

    $relatedProjects = $item->projects()->where('published', true)->get();

    return view('site.person', compact('item', 'relatedProjects'));
})->name('people.show');

Route::get('/guides', function () {
    return view('site.guides', [
        'guides' => Guide::query()->where('published', true)
            ->orderByDesc('publication_date')->orderBy('position')->get(),
    ]);
})->name('guides');

Route::get('/guides/{identifier}', function (string $identifier) {
    // 슬러그 우선 조회 후 숫자 ID로 폴백 — 한글 제목이 "7" 같은 숫자형 슬러그가 되는 경우도 안전하게 처리.
    $item = Guide::query()->forSlug($identifier)->where('published', true)->first();

    if (! $item && ctype_digit($identifier)) {
        $item = Guide::query()->whereKey($identifier)->where('published', true)->first();
    }

    abort_if(! $item, 404);

    $relatedGuides = Guide::query()->where('published', true)->whereKeyNot($item->id)
        ->orderByDesc('publication_date')->orderBy('position')->take(3)->get();

    return view('site.guide', compact('item', 'relatedGuides'));
})->name('guides.show');

Route::get('/contact', function () {
    return view('site.contact', [
        'contact' => Contact::query()->first(),
        'offices' => Office::query()->where('published', true)->orderBy('position')->orderBy('title')->get(),
    ]);
})->name('contact');

// Safari 등 일부 브라우저는 <link rel="icon"> 과 별개로 루트의 /favicon.ico 를 직접 요청한다.
// 빈 favicon.ico 를 두지 않는 대신, 업로드된 파비콘(PNG 변환)으로 넘겨 404 로 끝나지 않게 한다.
Route::get('/favicon.ico', function () {
    $settings = SiteSetting::query()->first();

    abort_unless($settings?->hasImage('favicon'), 404);

    return redirect()->away(
        $settings->image('favicon', 'default', ['fm' => 'png', 'w' => 64, 'h' => 64])
    );
})->name('favicon');

Route::get('/download', function () {
    return view('site.downloads', [
        'downloads' => Download::query()->with('files')->where('published', true)->orderBy('position')->get(),
    ]);
})->name('downloads');

// 파일은 항상 컨트롤러를 거쳐 스트리밍 → 직접 /storage URL이 노출되지 않음.
// 비밀번호가 설정된 항목은 올바른 비번(POST)일 때만 내려줌.
Route::match(['get', 'post'], '/download/{download}/file', function (Download $download, \Illuminate\Http\Request $request) {
    abort_unless($download->published, 404);

    // 파일은 로케일별로 저장되나 다운로드는 언어 무관이어야 하므로 로케일 무관하게 조회.
    $file = $download->fileObject('document') ?: $download->files->firstWhere('pivot.role', 'document');
    abort_unless($file, 404);

    if ($download->require_password && filled($download->download_password)) {
        $given = (string) $request->input('password', '');
        if (! $request->isMethod('post') || ! hash_equals((string) $download->download_password, $given)) {
            return back()->with('download_error', '비밀번호가 올바르지 않습니다. 다시 시도해 주세요.');
        }
    }

    $disk = config('twill.file_library.disk', 'twill_file_library');
    abort_unless(\Illuminate\Support\Facades\Storage::disk($disk)->exists($file->uuid), 404);

    return \Illuminate\Support\Facades\Storage::disk($disk)->download($file->uuid, $file->filename);
})->name('download.file');

Route::get('/projects', function (\Illuminate\Http\Request $request) {
    $selectedCategoryId = $request->integer('category') ?: null;

    return view('site.projects', [
        'projects' => Project::query()
            ->where('published', true)
            ->orderByDesc('project_completed_at')
            ->orderBy('position')
            ->get(),
        'categories' => Category::query()->where('published', true)->orderBy('position')->get(),
        'selectedCategoryId' => $selectedCategoryId,
    ]);
})->name('projects');

Route::get('/projects/{identifier}', function (string $identifier) {
    // 슬러그 우선 조회 후 숫자 ID로 폴백 — 숫자형 슬러그도 안전하게 처리.
    $item = Project::query()->forSlug($identifier)->where('published', true)->first();

    if (! $item && ctype_digit($identifier)) {
        $item = Project::query()->whereKey($identifier)->where('published', true)->first();
    }

    abort_if(! $item, 404);

    $categoryIds = $item->categories()->pluck('categories.id');

    $relatedProjects = Project::query()
        ->where('published', true)
        ->whereKeyNot($item->id)
        ->when($categoryIds->isNotEmpty(), fn ($query) => $query->whereHas('categories', fn ($categoryQuery) => $categoryQuery->whereIn('categories.id', $categoryIds)))
        ->orderByDesc('featured')
        ->orderBy('position')
        ->take(3)
        ->get();

    if ($relatedProjects->count() < 3) {
        $fallbackProjects = Project::query()
            ->where('published', true)
            ->whereKeyNot($item->id)
            ->whereNotIn('id', $relatedProjects->pluck('id'))
            ->orderByDesc('featured')
            ->orderBy('position')
            ->take(3 - $relatedProjects->count())
            ->get();

        $relatedProjects = $relatedProjects->concat($fallbackProjects);
    }

    return view('site.project', compact('item', 'relatedProjects'));
})->name('projects.show');
