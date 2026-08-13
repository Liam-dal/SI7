<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Services\Forms\Fieldset;
use A17\Twill\Services\Forms\Fields\BlockEditor;
use A17\Twill\Services\Forms\Fields\Checkbox;
use A17\Twill\Services\Forms\Fields\Input;
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
                Fieldset::make()->title('상단 그라디언트 (Neat)')->fields([
                    Checkbox::make()->name('use_neat')->label('애니메이션 그라디언트 사용')->note('켜면 About 상단에 커버 대신 Neat 애니메이션 그라디언트가 표시됩니다.'),
                    Input::make()->name('neat_config')->label('Neat 설정 (JSON)')->type('textarea')->rows(12)
                        ->note('neat.firecms.co에서 그라디언트 디자인 → Export → config(JSON)만 붙여넣으세요. 예: {"colors":[{"color":"#FF5373","enabled":true}, ...], "speed":4, ...}'),
                ])
            )
            ->addFieldset(
                Fieldset::make()->title('Content')->fields([
                    BlockEditor::make()
                        ->label('추가 콘텐츠')
                        ->blocks(['heading_description', 'quote', 'full_width_image', 'fixed_image_grid', 'flexible_image_grid']),
                ])
            );
    }
}
