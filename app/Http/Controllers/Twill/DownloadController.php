<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\TableColumns;
use A17\Twill\Services\Forms\Fields\Checkbox;
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
            ->add(Input::make()->name('tag')->label('Tag (optional)')->maxlength(80)->note('e.g. Company, Certificate, Press kit'))
            ->add(Input::make()->name('description')->label('File description (optional)')->maxlength(500))
            ->add(Files::make()->name('document')->label('Download file')->filesizeMax(512)->note('Upload a single file — business registration, company profile, PDF, video (mp4), etc. Max 512MB.'))
            ->add(Checkbox::make()->name('require_password')->label('Require password')->note('When on, visitors must enter a password to download this file.'))
            ->add(Input::make()->name('download_password')->label('Download password')->note('Used only when "Require password" above is on. Enter the password you will share with visitors.'));
    }

    /**
     * This is an example and can be removed if no modifications are needed to the table.
     */
    protected function additionalIndexTableColumns(): TableColumns
    {
        $table = parent::additionalIndexTableColumns();

        $table->add(
            Text::make()->field('tag')->title('Tag')
        );

        $table->add(
            Text::make()->field('description')->title('Description')
        );

        return $table;
    }
}
