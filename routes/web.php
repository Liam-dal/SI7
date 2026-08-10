<?php

use App\Models\Contact;
use App\Models\Category;
use App\Models\Download;
use App\Models\HomepageFeatureSection;
use App\Models\Homepage;
use App\Models\Project;
use App\Models\HomepageFeature;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $homepage = Homepage::query()->first();
    $asFeature = fn ($project) => (object) ['project' => $project, 'title' => null, 'description' => null];
    $selectedFeatures = fn (string $browserName) => ($homepage?->getRelated($browserName) ?? collect())
        ->filter(fn (Project $project) => $project->published)
        ->map($asFeature)
        ->values();

    $mainFeatures = $selectedFeatures('main_features');
    $secondaryFeatures = $selectedFeatures('secondary_features');
    $additionalFeatures = $selectedFeatures('additional_features');

    // 이전 Homepage 피처 데이터가 남아 있는 경우, 한 번만 보여주는 안전한 호환 처리입니다.
    if ($mainFeatures->isEmpty() && $secondaryFeatures->isEmpty() && $additionalFeatures->isEmpty()) {
        $features = HomepageFeature::query()->with('project')->where('published', true)->orderBy('position')->get()
            ->filter(fn (HomepageFeature $feature) => $feature->project?->published);
        $mainFeatures = $features->where('section', 'main')->values();
        $secondaryFeatures = $features->where('section', 'secondary')->values();
        $additionalFeatures = $features->where('section', 'additional')->values();
    }

    $featuredIds = $mainFeatures->merge($secondaryFeatures)->merge($additionalFeatures)->pluck('project.id')->unique();
    $regularProjects = Project::query()
        ->where('published', true)
        ->whereNotIn('id', $featuredIds)
        ->orderBy('position')
        ->get();
    $featureSections = HomepageFeatureSection::query()
        ->where('published', true)
        ->get()
        ->keyBy('section_key');

    return view('site.home', [
        'mainFeatures' => $mainFeatures,
        'secondaryFeatures' => $secondaryFeatures,
        'additionalFeatures' => $additionalFeatures,
        'regularProjects' => $regularProjects,
        'featureSections' => $featureSections,
    ]);
})->name('home');

Route::get('/contact', function () {
    return view('site.contact', [
        'contact' => Contact::query()->first(),
    ]);
})->name('contact');

Route::get('/download', function () {
    return view('site.downloads', [
        'downloads' => Download::query()->with('files')->where('published', true)->orderBy('position')->get(),
    ]);
})->name('downloads');

Route::get('/projects', function (\Illuminate\Http\Request $request) {
    $selectedCategoryId = $request->integer('category') ?: null;

    return view('site.projects', [
        'projects' => Project::query()
            ->where('published', true)
            ->when($selectedCategoryId, fn ($query) => $query->whereHas('categories', fn ($categoryQuery) => $categoryQuery->whereKey($selectedCategoryId)))
            ->orderBy('position')
            ->get(),
        'categories' => Category::query()->where('published', true)->orderBy('position')->get(),
        'selectedCategoryId' => $selectedCategoryId,
    ]);
})->name('projects');

Route::get('/projects/{identifier}', function (string $identifier) {
    $item = ctype_digit($identifier)
        ? Project::query()->whereKey($identifier)->where('published', true)->firstOrFail()
        : Project::query()->forSlug($identifier)->where('published', true)->firstOrFail();
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
