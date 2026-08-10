<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasPosition;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\HasSlug;
use A17\Twill\Models\Behaviors\Sortable;
use A17\Twill\Models\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TeamRole extends Model implements Sortable
{
    use HasPosition, HasRevisions, HasSlug;

    protected $fillable = ['published', 'title', 'position'];

    public $slugAttributes = ['title'];

    public function people(): HasMany
    {
        return $this->hasMany(Person::class);
    }
}
