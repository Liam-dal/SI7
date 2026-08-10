<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Http\Controllers\Admin\ModuleController as BaseModuleController;

class TeamRoleController extends BaseModuleController
{
    protected $moduleName = 'teamRoles';

    protected function setUpController(): void
    {
        $this->enableEditInModal();
    }
}
