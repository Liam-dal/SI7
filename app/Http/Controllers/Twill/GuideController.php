<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Services\Listings\Columns\Image;
use A17\Twill\Services\Listings\Columns\PublishStatus;
use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\TableColumns;
use A17\Twill\Services\Forms\Fields\BlockEditor;
use A17\Twill\Services\Forms\Fields\DatePicker;
use A17\Twill\Services\Forms\Fields\Input;
use A17\Twill\Services\Forms\Fields\Medias;
use A17\Twill\Services\Forms\Fieldset;
use A17\Twill\Services\Forms\Form;
use A17\Twill\Http\Controllers\Admin\ModuleController as BaseModuleController;

class GuideController extends BaseModuleController
{
    protected $moduleName = 'guides';

    protected function setUpController(): void
    {
        $this->setPermalinkBase('guides');
        $this->enableSkipCreateModal();
    }

    public function getForm(TwillModelContract $model): Form
    {
        return parent::getForm($model)
            ->addFieldset(
                Fieldset::make()->title('Content')->fields([
                    Input::make()->name('category')->label('Category')->maxlength(60)
                        ->note('예: Ideas, News, Report, Clients — 목록에서 타이틀 위에 표시됩니다.'),
                    Input::make()->name('description')->label('Short description')->type(Input::TYPE_TEXTAREA)->rows(3)->maxlength(500)
                        ->translatable()
                        ->note('목록과 상세 상단에 표시되는 요약입니다.'),
                    Medias::make()->name('cover')->label('Cover')->max(1),
                    DatePicker::make()->name('publication_date')->label('Publication date')->withoutTime(),
                    BlockEditor::make()
                        ->label('본문')
                        ->blocks(['heading_description', 'quote', 'full_width_image', 'fixed_image_grid', 'flexible_image_grid', 'neat_gradient']),
                ])
            );
    }

    protected function additionalIndexTableColumns(): TableColumns
    {
        $table = TableColumns::make();

        $table->add(PublishStatus::make()->title('공개')->optional());

        $table->add(
            Image::make()->field('cover')->title('커버')->role('cover')->crop('default')
                ->mediaParams(['w' => 80, 'h' => 80, 'fit' => 'crop'])
        );

        $table->add(Text::make()->field('title')->title('제목')->linkToEdit()->sortable());

        $table->add(
            Text::make()->field('publication_date')->title('발행일')->sortable()
                ->customRender(fn (TwillModelContract $guide): string => $guide->publication_date
                    ? $guide->publication_date->format('Y-m-d')
                    : '—')
        );

        return $table;
    }
}
