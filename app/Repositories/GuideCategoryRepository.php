<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleRevisions;
use A17\Twill\Repositories\Behaviors\HandleSlugs;
use A17\Twill\Repositories\ModuleRepository;
use App\Models\GuideCategory;

class GuideCategoryRepository extends ModuleRepository
{
    use HandleRevisions, HandleSlugs;

    public function __construct(GuideCategory $model)
    {
        $this->model = $model;
    }
}
