<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Services\Forms\Fieldset;
use A17\Twill\Services\Forms\Fields\BlockEditor;
use A17\Twill\Services\Forms\Form;
use A17\Twill\Http\Controllers\Admin\SingletonModuleController as BaseModuleController;

class AboutController extends BaseModuleController
{
    protected $moduleName = 'abouts';
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
            ->addFieldset(
                Fieldset::make()->title('Content')->fields([
                    BlockEditor::make()
                        ->label('Add block')
                        ->blocks(['heading_description', 'quote', 'full_width_image', 'fixed_image_grid', 'flexible_image_grid', 'neat_gradient']),
                ])
            );
    }
}
