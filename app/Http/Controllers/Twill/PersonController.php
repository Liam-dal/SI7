<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Http\Controllers\Admin\ModuleController as BaseModuleController;
use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Services\Listings\Columns\Image;
use A17\Twill\Services\Listings\Columns\PublishStatus;
use A17\Twill\Services\Listings\Columns\Relation;
use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\TableColumns;
use A17\Twill\Services\Forms\Fields\Input;
use A17\Twill\Services\Forms\Fields\Medias;
use A17\Twill\Services\Forms\Fields\Browser;
use A17\Twill\Services\Forms\Fields\Select;
use A17\Twill\Services\Forms\Fields\Wysiwyg;
use A17\Twill\Services\Forms\Fieldset;
use A17\Twill\Services\Forms\Form;
use A17\Twill\Services\Forms\Options;
use App\Models\TeamRole;

class PersonController extends BaseModuleController
{
    protected $moduleName = 'people';

    protected function setUpController(): void
    {
        $this->eagerLoadListingRelations(['teamRole', 'officeLocation']);
        // People은 입력 항목이 많으므로 Add new에서 바로 전체 편집 화면을 엽니다.
        $this->enableSkipCreateModal();
    }

    public function getForm(TwillModelContract $model): Form
    {
        return parent::getForm($model)
            ->addFieldset(
                Fieldset::make()->title('Content')->fields([
                    Input::make()->name('first_name')->label('First name'),
                    Input::make()->name('last_name')->label('Last name'),
                    Select::make()->name('team_role_id')->label('Role')->placeholder('Select a role')->clearable()->options(
                        fn () => Options::fromArray(TeamRole::query()->where('published', true)->orderBy('position')->pluck('title', 'id')->all())
                    ),
                    Wysiwyg::make()->name('biography')->label('Biography')->limitHeight(),
                    Select::make()->name('start_year')->label('Start year')->placeholder('Select a year')->clearable()->options(
                        fn () => Options::fromArray(collect(range((int) now()->format('Y'), 1950))->mapWithKeys(fn (int $year) => [$year => (string) $year])->all())
                    ),
                    Select::make()->name('office_id')->label('Office')->placeholder('Select an office')->clearable()->options(
                        fn () => Options::fromArray(\App\Models\Office::query()->where('published', true)->orderBy('title')->pluck('title', 'id')->all())
                    ),
                    Medias::make()->name('main')->label('Main (Profile image)')->max(1),
                ])
            )
            ->addFieldset(
                Fieldset::make()->title('Related content')->fields([
                    Browser::make()->name('projects')->label('Projects')->modules([\App\Models\Project::class])->max(100),
                ])
            );
    }

    public function getIndexTableColumns(): TableColumns
    {
        return TableColumns::make()
            ->add(PublishStatus::make()->title('Published')->optional())
            ->add(
                Image::make()
                    ->field('main')
                    ->title('Photo')
                    ->role('main')
                    ->crop('default')
                    ->mediaParams(['w' => 80, 'h' => 80, 'fit' => 'crop'])
            )
            ->add(Text::make()->field('title')->title('Name')->linkToEdit()->sortable())
            ->add(Relation::make()->field('title')->title('Role')->relation('teamRole')->optional());
    }
}
