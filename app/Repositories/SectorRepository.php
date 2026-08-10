<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleRevisions;
use A17\Twill\Repositories\Behaviors\HandleSlugs;
use A17\Twill\Repositories\ModuleRepository;
use App\Models\Sector;

class SectorRepository extends ModuleRepository
{
    use HandleRevisions, HandleSlugs;

    public function __construct(Sector $model)
    {
        $this->model = $model;
    }
}
