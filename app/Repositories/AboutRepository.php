<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use A17\Twill\Repositories\ModuleRepository;
use App\Models\About;

class AboutRepository extends ModuleRepository
{
    use HandleBlocks, HandleMedias, HandleRevisions;

    public function __construct(About $model)
    {
        $this->model = $model;
    }
}
