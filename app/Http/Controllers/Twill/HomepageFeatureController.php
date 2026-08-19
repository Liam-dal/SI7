<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Http\Controllers\Admin\ModuleController as BaseModuleController;
use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Services\Forms\Fields\Input;
use A17\Twill\Services\Forms\Fields\Select;
use A17\Twill\Services\Forms\Form;
use A17\Twill\Services\Forms\Options;
use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\TableColumns;
use App\Models\HomepageFeature;
use App\Models\Project;

class HomepageFeatureController extends BaseModuleController
{
    protected $moduleName = 'homepageFeatures';

    protected function setUpController(): void
    {
        $this->enableEditInModal();
        $this->eagerLoadListingRelations(['project']);
    }

    public function getForm(TwillModelContract $model): Form
    {
        return parent::getForm($model)
            ->add(Select::make()->name('project_id')->label('Project')->searchable()->options(
                fn () => Options::fromArray(Project::query()->where('published', true)->orderBy('title')->pluck('title', 'id')->all())
            ))
            ->add(Select::make()->name('section')->label('Feature section')->options(
                Options::fromArray([
                    'main' => 'Main feature projects (carousel)',
                    'secondary' => 'Secondary feature projects',
                    'additional' => 'Additional feature projects',
                ])
            ))
            ->add(Input::make()->name('title')->label('Feature title')->maxlength(180))
            ->add(Input::make()->name('description')->label('Feature description')->type(Input::TYPE_TEXTAREA)->rows(4)->maxlength(500));
    }

    public function getIndexTableColumns(): TableColumns
    {
        return TableColumns::make()
            ->add(Text::make()->field('title')->title('Feature title')->linkToEdit()->sortable())
            ->add(Text::make()->field('section')->title('Section')->customRender(
                fn (HomepageFeature $feature) => match ($feature->section) {
                    'main' => 'Main carousel',
                    'secondary' => 'Secondary features',
                    'additional' => 'Additional features',
                    default => $feature->section,
                }
            ))
            ->add(Text::make()->field('project_id')->title('Project')->customRender(
                fn (HomepageFeature $feature) => $feature->project?->title ?: '—'
            ));
    }
}
