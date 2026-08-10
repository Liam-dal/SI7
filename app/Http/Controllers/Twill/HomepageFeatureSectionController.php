<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Http\Controllers\Admin\ModuleController as BaseModuleController;
use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Services\Forms\Fields\Input;
use A17\Twill\Services\Forms\Form;
use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\TableColumns;
use App\Models\HomepageFeatureSection;

class HomepageFeatureSectionController extends BaseModuleController
{
    protected $moduleName = 'homepageFeatureSections';

    protected function setUpController(): void
    {
        $this->enableEditInModal();
        $this->disableCreate();
    }

    /**
     * 목록에서 사용하는 모달은 별도 폼을 렌더링하므로,
     * 상세 폼과 동일하게 제목과 설명을 명시적으로 제공합니다.
     */
    public function getCreateForm(): Form
    {
        return $this->getForm(new HomepageFeatureSection());
    }

    public function getForm(TwillModelContract $model): Form
    {
        return parent::getForm($model)
            ->add(Input::make()->name('title')->label('Feature title')->maxlength(120))
            ->add(Input::make()->name('description')->label('Feature description')->type(Input::TYPE_TEXTAREA)->rows(4)->maxlength(500));
    }

    /**
     * 기본 제목 빠른 수정 창 대신 전체 설정 모달을 엽니다.
     */
    public function getIndexTableColumns(): TableColumns
    {
        return TableColumns::make()
            ->add(Text::make()->field('title')->title('Feature title')->linkToEdit());
    }
}
