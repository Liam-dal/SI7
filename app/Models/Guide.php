<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasBlocks;
use A17\Twill\Models\Behaviors\HasSlug;
use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\HasPosition;
use A17\Twill\Models\Behaviors\HasTranslation;
use A17\Twill\Models\Behaviors\Sortable;
use A17\Twill\Models\Model;

class Guide extends Model implements Sortable
{
    use HasBlocks, HasSlug, HasMedias, HasRevisions, HasPosition, HasTranslation;

    protected $fillable = [
        'published',
        'title',
        'headline',
        'category',
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

    public array $mediasParams = [
        'cover' => [
            'default' => [[
                'name' => 'default',
                'ratio' => 1.65,
            ]],
        ],
    ];
}
