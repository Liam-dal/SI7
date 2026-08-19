<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Services\Listings\Columns\Image;
use A17\Twill\Services\Listings\Columns\PublishStatus;
use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\Columns\Relation;
use A17\Twill\Services\Listings\TableColumns;
use A17\Twill\Services\Forms\Fields\Input;
use A17\Twill\Services\Forms\Fields\BlockEditor;
use A17\Twill\Services\Forms\Fields\Browser;
use A17\Twill\Services\Forms\Fields\Checkbox;
use A17\Twill\Services\Forms\Fields\DatePicker;
use A17\Twill\Services\Forms\Fields\Medias;
use A17\Twill\Services\Forms\Fields\MultiSelect;
use A17\Twill\Services\Forms\Fields\Select;
use A17\Twill\Services\Forms\Fields\Wysiwyg;
use A17\Twill\Services\Forms\Fieldset;
use A17\Twill\Services\Forms\Form;
use A17\Twill\Services\Forms\Options;
use A17\Twill\Http\Controllers\Admin\ModuleController as BaseModuleController;

class ProjectController extends BaseModuleController
{
    protected $moduleName = 'projects';
    /**
     * This method can be used to enable/disable defaults. See setUpController in the docs for available options.
     */
    protected function setUpController(): void
    {
        $this->eagerLoadListingRelations(['categories']);
        // 편집 화면 제목 아래에 실제 공개 프로젝트 주소를 표시합니다.
        $this->setPermalinkBase('projects');
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
                    Input::make()->name('subtitle')->label('Subtitle')->note('Short line shown on homepage features and project cards.'),
                    Input::make()->name('description')->label('Short description')->type(Input::TYPE_TEXTAREA)->rows(4)->maxlength(500)->note('Summary shown at the top of the project detail page and on cards.'),
                    Wysiwyg::make()->name('case_study_text')->label('Case study text')->limitHeight(),
                    Medias::make()->name('cover')->label('Cover')->max(1),
                    Input::make()->name('video_url')->label('Youtube or Vimeo video URL')->type('url'),
                    Checkbox::make()->name('video_autoplay')->label('Autoplay'),
                    Checkbox::make()->name('video_autoloop')->label('Autoloop'),
                    BlockEditor::make()
                        ->label('Add block')
                        ->blocks(['quote', 'video', 'full_width_image', 'fixed_image_grid', 'flexible_image_grid']),
                ])
            )
            ->addFieldset(
                Fieldset::make()->title('Project info')->fields([
                    DatePicker::make()->name('publication_date')->label('Publication date')->withoutTime(),
                    MultiSelect::make()->name('sector_ids')->label('Sectors')->searchable()->options(
                        fn () => Options::fromArray(\App\Models\Sector::query()->where('published', true)->orderBy('title')->pluck('title', 'id')->all())
                    ),
                    MultiSelect::make()->name('category_ids')->label('Disciplines')->searchable()->options(
                        fn () => Options::fromArray(\App\Models\Category::query()->where('published', true)->orderBy('title')->pluck('title', 'id')->all())
                    ),
                    Input::make()->name('client')->label('Client name'),
                    Select::make()->name('project_completed_at')->label('Year')->placeholder('Select a year')->clearable()->options(
                        fn () => Options::fromArray(
                            collect(range((int) now()->format('Y'), 1950))
                                ->mapWithKeys(fn (int $year) => ["{$year}-01-01" => (string) $year])
                                ->all()
                        )
                    ),
                    Input::make()->name('tags')->label('Tags')->note('Separate with commas.'),
                    Checkbox::make()->name('featured')->label('Prioritise in "Up next"')
                        ->note('Pushes this project to the front of the "Up next" list shown at the bottom of other project pages. Homepage features are chosen in the Homepage editor.'),
                ])
            )
            ->addFieldset(
                Fieldset::make()->title('External links')->fields([
                    Input::make()->name('external_link_label')->label('Link label'),
                    Input::make()->name('external_url')->label('External URL')->type('url'),
                ])
            )
            ->addFieldset(
                Fieldset::make()->title('Related content')->fields([
                    Browser::make()->name('people')->label('People')->modules([\App\Models\Person::class])->max(100),
                    Browser::make()->name('offices')->label('Offices')->modules([\App\Models\Office::class])->max(10),
                ])
            );
    }

    /**
     * 프로젝트를 제목만 나열하지 않고, 대표 이미지와 주요 메타데이터를 함께 보여줍니다.
     */
    public function getIndexTableColumns(): TableColumns
    {
        $table = TableColumns::make();

        $table->add(
            PublishStatus::make()->title('Published')->optional()
        );

        $table->add(
            Image::make()
                ->field('cover')
                ->title('Image')
                ->role('cover')
                ->crop('default')
                ->mediaParams(['w' => 80, 'h' => 80, 'fit' => 'crop'])
        );

        $table->add(
            Text::make()->field('title')->title('Title')->linkToEdit()->sortable()
        );

        $table->add(
            Text::make()->field('client')->title('Client')->optional()
        );

        $table->add(
            Text::make()
                ->field('project_completed_at')
                ->title('Year')
                ->customRender(function (TwillModelContract $project): string {
                    return $project->project_completed_at
                        ? \Illuminate\Support\Carbon::parse($project->project_completed_at)->format('Y')
                        : '—';
                })
                ->optional()
        );

        $table->add(
            Relation::make()->field('title')->title('Categories')->relation('categories')
        );

        return $table;
    }
}
