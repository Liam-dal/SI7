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
        'category',
        'description',
        'publication_date',
        'position',
    ];

    public $translatedAttributes = [
        'title',
        'description',
    ];

    protected $casts = [
        'publication_date' => 'datetime',
    ];

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
