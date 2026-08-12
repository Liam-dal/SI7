<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasFiles;
use A17\Twill\Models\Behaviors\HasPosition;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\Sortable;
use A17\Twill\Models\Model;

class Download extends Model implements Sortable
{
    use HasFiles, HasPosition, HasRevisions;

    public array $filesParams = ['document'];

    protected $fillable = [
        'published',
        'title',
        'tag',
        'description',
        'position',
    ];
    
}
