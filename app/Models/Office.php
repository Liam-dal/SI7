<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Behaviors\HasPosition;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\Sortable;
use A17\Twill\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Office extends Model implements Sortable
{
    use HasMedias, HasPosition, HasRevisions;

    protected $fillable = [
        'published',
        'title',
        'short_description',
        'email',
        'phone',
        'street',
        'city',
        'zipcode',
        'country',
        'directions_url',
        'timezone',
        'position',
    ];

    public array $mediasParams = [
        'office' => [
            'default' => [[
                'name' => 'default',
                'ratio' => 0,
            ]],
        ],
    ];

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class)->withPivot('position')->orderByPivot('position');
    }
}
