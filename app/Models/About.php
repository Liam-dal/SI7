<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasBlocks;
use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Model;

class About extends Model 
{
    use HasBlocks, HasMedias, HasRevisions;

    protected $fillable = [
        'published',
        'title',
        'page_tagline',
        'page_text',
        'description',
        'profession',
        'resume_url',
    ];
    
}
