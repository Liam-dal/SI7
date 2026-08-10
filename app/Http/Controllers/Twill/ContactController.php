<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\TableColumns;
use A17\Twill\Services\Forms\Fields\Input;
use A17\Twill\Services\Forms\Fields\Medias;
use A17\Twill\Services\Forms\Form;
use A17\Twill\Http\Controllers\Admin\SingletonModuleController as BaseModuleController;

class ContactController extends BaseModuleController
{
    protected $moduleName = 'contacts';
    /**
     * This method can be used to enable/disable defaults. See setUpController in the docs for available options.
     */
    protected function setUpController(): void
    {
        $this->disablePermalink();
    }

    /**
     * See the table builder docs for more information. If you remove this method you can use the blade files.
     * When using twill:module:make you can specify --bladeForm to use a blade form instead.
     */
    public function getForm(TwillModelContract $model): Form
    {
        return parent::getForm($model)
            ->add(Input::make()->name('description')->label('연락 안내')->maxlength(500))
            ->add(Input::make()->name('email')->label('이메일')->type('email'))
            ->add(Input::make()->name('phone')->label('전화번호 (선택)'))
            ->add(Input::make()->name('location')->label('활동 지역 (선택)'))
            ->add(Input::make()->name('availability')->label('협업 가능 상태'))
            ->add(Medias::make()->name('contact_primary')->label('첫 번째 이미지 묶음')->max(6))
            ->add(Medias::make()->name('contact_secondary')->label('두 번째 이미지 묶음')->max(6))
            ->add(Input::make()->name('meeting_url')->label('미팅 예약 링크')->type('url'))
            ->add(Input::make()->name('instagram_url')->label('Instagram 링크')->type('url'))
            ->add(Input::make()->name('linkedin_url')->label('LinkedIn 링크')->type('url'))
            ->add(Input::make()->name('behance_url')->label('Behance 링크')->type('url'));
    }

    /**
     * This is an example and can be removed if no modifications are needed to the table.
     */
    protected function additionalIndexTableColumns(): TableColumns
    {
        $table = parent::additionalIndexTableColumns();

        $table->add(
            Text::make()->field('description')->title('Description')
        );

        return $table;
    }
}
