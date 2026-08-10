<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleFiles;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use A17\Twill\Repositories\ModuleRepository;
use App\Models\Download;

class DownloadRepository extends ModuleRepository
{
    use HandleFiles, HandleRevisions;

    public function __construct(Download $model)
    {
        $this->model = $model;
    }
}
