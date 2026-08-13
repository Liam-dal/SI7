<?php

namespace App\Models\Translations;

use A17\Twill\Models\Model;
use App\Models\Guide;

class GuideTranslation extends Model
{
    protected $baseModuleModel = Guide::class;
}
