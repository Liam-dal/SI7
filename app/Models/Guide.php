<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasBlocks;
use A17\Twill\Models\Behaviors\HasFiles;
use A17\Twill\Models\Behaviors\HasSlug;
use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\HasPosition;
use A17\Twill\Models\Behaviors\HasTranslation;
use A17\Twill\Models\Behaviors\Sortable;
use A17\Twill\Models\Model;
use A17\Twill\Services\FileLibrary\FileService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Guide extends Model implements Sortable
{
    use HasBlocks, HasSlug, HasMedias, HasFiles, HasRevisions, HasPosition, HasTranslation;

    protected $fillable = [
        'published',
        'title',
        'headline',
        'guide_category_id',
        'description',
        'publication_date',
        'position',
    ];

    // title 은 permalink(URL) 전용 — 번역하지 않고 하나만 사용한다.
    // headline 이 실제로 사이트에 표시되는 제목(한/영 번역).
    public $translatedAttributes = [
        'headline',
        'description',
    ];

    protected $casts = [
        'publication_date' => 'datetime',
    ];

    // 슬러그는 번역되지 않는 title 컬럼에서만 생성 → permalink 하나로 통일.
    public $slugAttributes = [
        'title',
    ];

    // 카테고리는 하나만 붙는다 — 제목 위 eyebrow 한 줄로만 쓰이기 때문(Sector 는 다대다).
    public function guideCategory(): BelongsTo
    {
        return $this->belongsTo(GuideCategory::class);
    }

    // 상세 페이지 커버 자리에 재생할 짧은 영상(선택). 목록에는 쓰지 않는다.
    public array $filesParams = ['cover_video'];

    public array $mediasParams = [
        'cover' => [
            'default' => [[
                'name' => 'default',
                'ratio' => 1.65,
            ]],
        ],
    ];

    // 커버 영상 URL. 파일은 Twill 이 로케일별 행으로 저장하지만 영상은 언어와 무관하므로
    // 현재 로케일 → 아무 로케일 순으로 찾는다(Download 라우트와 같은 규칙).
    public function getCoverVideoUrlAttribute(): ?string
    {
        $file = $this->fileObject('cover_video') ?: $this->files->firstWhere('pivot.role', 'cover_video');

        return $file ? FileService::getUrl($file->uuid) : null;
    }

    // 사이트 URL 에는 로케일 접두어가 없다(세션 기반 ko/en 전환). permalink 도 번역하지
    // 않는다(slugAttributes = ['title']). 그런데 Twill 은 translatable 모델의 슬러그를
    // 로케일별 행으로 저장하고, 각 행의 active 를 그 로케일 "번역"의 active 로 채운다
    // (HasSlug::getSlugParams). 그래서 한쪽 언어 번역을 비워두면 그 로케일의 슬러그 행이
    // active=0 이 되고, 기본 scopeForSlug 는 현재 로케일만 보므로 404 가 난다.
    // 링크 생성(getSlug)은 translatable.fallback_locale 로 폴백하는데 조회에는 폴백이
    // 없어서 "목록에는 뜨는데 누르면 404" 가 됐다. 조회도 로케일 무관으로 맞춘다.
    // (title 이 번역되지 않으므로 두 로케일 행의 슬러그 문자열은 항상 동일하다.)
    public function scopeForSlug(Builder $query, string $slug): Builder
    {
        return $query->whereHas('slugs', function ($query) use ($slug): void {
            $query->where('slug', $slug)->where('active', true);
        })->with(['slugs'])->orderBy('id');
    }

    // 목록·관련글 링크가 쓰는 슬러그. 위 scopeForSlug 와 같은 규칙(로케일 무관, 활성 슬러그)
    // 으로 골라야 링크와 조회가 어긋나지 않는다. 슬러그가 아예 없으면 숫자 ID 로 떨어진다
    // (한글 제목은 Str::slug 가 전부 버려서 슬러그가 비는 경우가 있다).
    public function getPublicSlugAttribute(): string
    {
        $slug = $this->getActiveSlug()
            ?? $this->getFallbackActiveSlug()
            ?? $this->slugs->firstWhere('active', true);

        return $slug->slug ?? (string) $this->getKey();
    }
}
