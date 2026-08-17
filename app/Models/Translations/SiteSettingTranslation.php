<?php

namespace App\Models\Translations;

use A17\Twill\Models\Model;
use App\Models\SiteSetting;

class SiteSettingTranslation extends Model
{
    protected $baseModuleModel = SiteSetting::class;
}
