<?php

namespace App\Repositories;

use A17\Twill\Repositories\ModuleRepository;
use App\Models\HomepageFeature;

class HomepageFeatureRepository extends ModuleRepository
{

    public function __construct(HomepageFeature $model)
    {
        $this->model = $model;
    }
}
