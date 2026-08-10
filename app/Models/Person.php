<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Behaviors\HasPosition;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\HasSlug;
use A17\Twill\Models\Behaviors\Sortable;
use A17\Twill\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Person extends Model implements Sortable
{
    use HasMedias, HasPosition, HasRevisions, HasSlug;

    protected $fillable = [
        'published', 'title', 'first_name', 'last_name', 'team_role_id', 'office_id', 'biography', 'start_year', 'office', 'position',
    ];

    public $slugAttributes = ['title'];

    public array $mediasParams = [
        'main' => [
            'default' => [[
                'name' => 'default',
                'ratio' => 1,
            ]],
        ],
    ];

    public function teamRole(): BelongsTo
    {
        return $this->belongsTo(TeamRole::class);
    }

    public function officeLocation(): BelongsTo
    {
        return $this->belongsTo(Office::class, 'office_id');
    }

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class)->withPivot('position')->orderByPivot('position');
    }

    protected static function booted(): void
    {
        static::saving(function (self $person): void {
            $fullName = trim(implode(' ', array_filter([$person->first_name, $person->last_name])));

            if ($fullName !== '') {
                $person->title = $fullName;
            }
        });
    }
}
