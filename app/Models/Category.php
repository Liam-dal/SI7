<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasSlug;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\HasPosition;
use A17\Twill\Models\Behaviors\Sortable;
use A17\Twill\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model implements Sortable
{
    use HasSlug, HasRevisions, HasPosition;

    protected $fillable = [
        'published',
        'title',
        'description',
        'position',
    ];
    
    public $slugAttributes = [
        'title',
    ];

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class)->withPivot('position')->orderByPivot('position');
    }
}
