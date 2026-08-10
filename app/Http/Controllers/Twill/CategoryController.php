<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Http\Controllers\Admin\ModuleController as BaseModuleController;

class CategoryController extends BaseModuleController
{
    protected $moduleName = 'categories';
    /**
     * This method can be used to enable/disable defaults. See setUpController in the docs for available options.
     */
    protected function setUpController(): void
    {
        // 카테고리 목록에서 바로 제목·주소·공개 상태만 빠르게 수정합니다.
        $this->enableEditInModal();
    }
}
