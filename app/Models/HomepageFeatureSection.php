<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasPosition;
use A17\Twill\Models\Behaviors\Sortable;
use A17\Twill\Models\Model;

class HomepageFeatureSection extends Model implements Sortable
{
use HasPosition;

    protected $fillable = ['published', 'section_key', 'title', 'description', 'layout_style', 'position'];
}
