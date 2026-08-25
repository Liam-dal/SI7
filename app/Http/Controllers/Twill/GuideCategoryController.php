<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Http\Controllers\Admin\ModuleController as BaseModuleController;

class GuideCategoryController extends BaseModuleController
{
    protected $moduleName = 'guideCategories';

    protected function setUpController(): void
    {
        // Sector 와 동일하게 목록에서 모달로 간단히 수정한다.
        $this->enableEditInModal();
    }
}
