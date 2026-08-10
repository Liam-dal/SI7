<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleBrowsers;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use A17\Twill\Repositories\Behaviors\HandleSlugs;
use A17\Twill\Repositories\ModuleRepository;
use App\Models\Person;

class PersonRepository extends ModuleRepository
{
    use HandleBrowsers, HandleMedias, HandleRevisions, HandleSlugs;

    public function __construct(Person $model)
    {
        $this->model = $model;
        $this->browsers = ['projects'];
    }
}
