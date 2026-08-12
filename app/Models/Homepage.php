<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasBlocks;
use A17\Twill\Models\Behaviors\HasRelated;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Model;

class Homepage extends Model
{
    use HasBlocks, HasRelated, HasRevisions;

    protected $fillable = ['published', 'title', 'hero_builder', 'hero_default_category_id', 'hero_default_sector_id'];
}
