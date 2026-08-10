<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Http\Controllers\Admin\SingletonModuleController as BaseModuleController;
use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Services\Forms\Fields\Browser;
use A17\Twill\Services\Forms\Form;
use App\Models\Project;

class HomepageController extends BaseModuleController
{
    protected $moduleName = 'homepages';

    protected function setUpController(): void
    {
        $this->disablePermalink();
    }

    public function getForm(TwillModelContract $model): Form
    {
        return parent::getForm($model)
            ->add(
                Browser::make()
                    ->name('main_features')
                    ->label('메인 피처 프로젝트')
                    ->modules([Project::class])
                    ->max(5)
                    ->wide()
                    ->browserNote('홈 상단에 크게 보여줄 프로젝트입니다. 드래그하여 순서를 바꿀 수 있습니다.')
            )
            ->add(
                Browser::make()
                    ->name('secondary_features')
                    ->label('보조 피처 프로젝트')
                    ->modules([Project::class])
                    ->max(12)
                    ->wide()
                    ->browserNote('메인 피처 다음에 그리드로 보여줄 프로젝트입니다. 드래그하여 순서를 바꿀 수 있습니다.')
            )
            ->add(
                Browser::make()
                    ->name('additional_features')
                    ->label('추가 피처 프로젝트')
                    ->modules([Project::class])
                    ->max(24)
                    ->wide()
                    ->browserNote('추가로 보여줄 피처 프로젝트입니다. 프로젝트를 선택하고 드래그하여 순서를 바꿀 수 있습니다.')
            );
    }
}
