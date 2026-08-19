<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Http\Controllers\Admin\SingletonModuleController as BaseModuleController;
use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Services\Forms\Fields\BlockEditor;
use A17\Twill\Services\Forms\Fields\Checkbox;
use A17\Twill\Services\Forms\Fields\Select;
use A17\Twill\Services\Forms\Fieldset;
use A17\Twill\Services\Forms\Form;
use A17\Twill\Services\Forms\Options;

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
            ->addFieldset(
                Fieldset::make()->title('Interactive hero')->fields([
                    Checkbox::make()->name('hero_builder')->label('Use interactive hero (We design [Discipline] for [Sector])')
                        ->note('When on, the top of the homepage becomes a "We design ___ for ___" sentence builder with a background slideshow. When off, the default hero is shown.'),
                    Select::make()->name('hero_default_category_id')->label('Default discipline (We design ___ )')->placeholder('None — everything')->clearable()->options(
                        fn () => Options::fromArray(\App\Models\Category::query()->where('published', true)->orderBy('position')->pluck('title', 'id')->all())
                    ),
                    Select::make()->name('hero_default_sector_id')->label('Default sector ( for ___ )')->placeholder('None — everyone')->clearable()->options(
                        fn () => Options::fromArray(\App\Models\Sector::query()->where('published', true)->orderBy('position')->pluck('title', 'id')->all())
                    ),
                ])
            )
            ->add(
                BlockEditor::make()
                    ->name('default')
                    ->label('Add section')
                    ->withoutSeparator()
                    ->blocks(['featured_section'])
            );
    }
}
