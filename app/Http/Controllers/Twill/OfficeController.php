<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Http\Controllers\Admin\ModuleController as BaseModuleController;
use A17\Twill\Services\Forms\Fieldset;
use A17\Twill\Services\Forms\Fields\Input;
use A17\Twill\Services\Forms\Fields\Medias;
use A17\Twill\Services\Forms\Fields\Select;
use A17\Twill\Services\Forms\Form;
use A17\Twill\Services\Forms\Options;

class OfficeController extends BaseModuleController
{
    protected $moduleName = 'offices';

    protected function setUpController(): void
    {
        $this->enableSkipCreateModal();
    }

    public function getForm(TwillModelContract $model): Form
    {
        return parent::getForm($model)
            ->addFieldset(
                Fieldset::make()->title('Content')->fields([
                    Input::make()->name('short_description')->label('Short description')->type(Input::TYPE_TEXTAREA)->rows(4)->maxlength(500),
                    Medias::make()->name('office')->label('Office images')->max(12)->minWidth(1500)->note('You can add multiple images.'),
                    Input::make()->name('email')->label('Email')->type(Input::TYPE_EMAIL),
                    Input::make()->name('phone')->label('Phone number')->note('Free-form — country code, spaces and hyphens are all fine.'),
                    Input::make()->name('street')->label('Street'),
                    Input::make()->name('city')->label('City'),
                    Input::make()->name('zipcode')->label('Zipcode'),
                    Input::make()->name('country')->label('Country'),
                    Input::make()->name('directions_url')->label('Directions URL')->type(Input::TYPE_URL),
                    Select::make()->name('timezone')->label('Timezone')->placeholder('Select a timezone')->searchable()->clearable()->options(
                        fn () => Options::fromArray(
                            collect(timezone_identifiers_list())->mapWithKeys(
                                fn (string $timezone) => [$timezone => $timezone]
                            )->all()
                        )
                    ),
                ])
            );
    }
}
