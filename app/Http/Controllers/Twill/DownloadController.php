<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\TableColumns;
use A17\Twill\Services\Forms\Fields\Input;
use A17\Twill\Services\Forms\Fields\Files;
use A17\Twill\Services\Forms\Form;
use A17\Twill\Http\Controllers\Admin\ModuleController as BaseModuleController;

class DownloadController extends BaseModuleController
{
    protected $moduleName = 'downloads';
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
            ->add(Input::make()->name('tag')->label('태그 (선택)')->maxlength(80)->note('예: Company, Certificate, Press kit'))
            ->add(Input::make()->name('description')->label('파일 설명 (선택)')->maxlength(500))
            ->add(Files::make()->name('document')->label('다운로드 파일')->filesizeMax(250)->note('사업자등록증, 회사 소개서, PDF 등 한 파일을 올리세요.'));
    }

    /**
     * This is an example and can be removed if no modifications are needed to the table.
     */
    protected function additionalIndexTableColumns(): TableColumns
    {
        $table = parent::additionalIndexTableColumns();

        $table->add(
            Text::make()->field('tag')->title('태그')
        );

        $table->add(
            Text::make()->field('description')->title('설명')
        );

        return $table;
    }
}
