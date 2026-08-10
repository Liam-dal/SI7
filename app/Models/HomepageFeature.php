<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasPosition;
use A17\Twill\Models\Behaviors\Sortable;
use A17\Twill\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HomepageFeature extends Model implements Sortable
{
use HasPosition;

    protected $fillable = ['published', 'project_id', 'section', 'title', 'description', 'position'];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
