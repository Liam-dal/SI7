<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Model;

class Contact extends Model 
{
    use HasMedias, HasRevisions;

    protected $fillable = [
        'published',
        'title',
        'description',
        'email',
        'phone',
        'location',
        'availability',
        'meeting_url',
        'instagram_url',
        'linkedin_url',
        'behance_url',
    ];
    
}
