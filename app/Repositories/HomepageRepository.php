<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleRevisions;
use A17\Twill\Repositories\ModuleRepository;
use App\Models\Homepage;

class HomepageRepository extends ModuleRepository
{
    use HandleRevisions;

    protected $relatedBrowsers = [
        'main_features' => ['relation' => 'main_features', 'moduleName' => 'projects'],
        'secondary_features' => ['relation' => 'secondary_features', 'moduleName' => 'projects'],
        'additional_features' => ['relation' => 'additional_features', 'moduleName' => 'projects'],
    ];

    public function __construct(Homepage $model)
    {
        $this->model = $model;
    }
}
