<?php

namespace App\Repositories;

use A17\Twill\Repositories\ModuleRepository;
use App\Models\HomepageFeatureSection;

class HomepageFeatureSectionRepository extends ModuleRepository
{

    public function __construct(HomepageFeatureSection $model)
    {
        $this->model = $model;
    }
}
