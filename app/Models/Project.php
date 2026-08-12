<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasBlocks;
use A17\Twill\Models\Behaviors\HasSlug;
use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\HasPosition;
use A17\Twill\Models\Behaviors\Sortable;
use A17\Twill\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Project extends Model implements Sortable
{
    use HasBlocks, HasSlug, HasMedias, HasRevisions, HasPosition;

    protected $fillable = [
        'published',
        'title',
        'subtitle',
        'description',
        'case_study_text',
        'role',
        'client',
        'technologies',
        'tags',
        'publication_date',
        'external_url',
        'external_link_label',
        'video_url',
        'video_autoplay',
        'video_autoloop',
        'project_started_at',
        'project_completed_at',
        'featured',
        'position',
    ];

    protected $appends = ['sector_ids', 'category_ids'];
    
    public $slugAttributes = [
        'title',
    ];

    /**
     * Keep existing block and media associations on the concrete project
     * model class. Homepage features use the separate morph-map alias.
     */
    public function getMorphClass(): string
    {
        return self::class;
    }

    // 대표 이미지는 관리자 목록과 홈페이지에서 일관된 정사각형 썸네일로 사용합니다.
    public array $mediasParams = [
        'cover' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 1,
                ],
            ],
            'square' => [
                [
                    'name' => 'square',
                    'ratio' => 1,
                ],
            ],
            'wide' => [
                [
                    'name' => 'wide',
                    'ratio' => 1.72,
                ],
            ],
            'hero' => [
                [
                    'name' => 'hero',
                    'ratio' => 1.85,
                ],
            ],
        ],
        'gallery' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 0,
                ],
            ],
        ],
    ];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class)->withPivot('position')->orderByPivot('position');
    }

    public function getSectorIdsAttribute(): array
    {
        return $this->sectors()->pluck('id')->map(fn ($id) => (string) $id)->all();
    }

    public function getCategoryIdsAttribute(): array
    {
        return $this->categories()->pluck('id')->map(fn ($id) => (string) $id)->all();
    }

    public function sectors(): BelongsToMany
    {
        return $this->belongsToMany(Sector::class)->withPivot('position')->orderByPivot('position');
    }

    public function people(): BelongsToMany
    {
        return $this->belongsToMany(Person::class)->withPivot('position')->orderByPivot('position');
    }

    public function offices(): BelongsToMany
    {
        return $this->belongsToMany(Office::class)->withPivot('position')->orderByPivot('position');
    }
}
