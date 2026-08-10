<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Http\Controllers\Admin\ModuleController as BaseModuleController;

class SectorController extends BaseModuleController
{
    protected $moduleName = 'sectors';

    protected function setUpController(): void
    {
        // 레퍼런스와 동일하게 목록에서 모달로 간단히 수정합니다.
        $this->enableEditInModal();
    }
}
