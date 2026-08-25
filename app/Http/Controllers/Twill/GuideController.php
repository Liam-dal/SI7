<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Services\Listings\Columns\Image;
use A17\Twill\Services\Listings\Columns\PublishStatus;
use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\TableColumns;
use A17\Twill\Services\Forms\Fields\BlockEditor;
use A17\Twill\Services\Forms\Fields\DatePicker;
use A17\Twill\Services\Forms\Fields\Files;
use A17\Twill\Services\Forms\Fields\Input;
use A17\Twill\Services\Forms\Fields\Medias;
use A17\Twill\Services\Forms\Fields\Select;
use A17\Twill\Services\Forms\Options;
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
        // 사이트 라우트(/guides/{slug})에 로케일 접두어가 없으므로,
        // 관리자 permalink에서도 {ko}/{en} 언어 분기를 제거해 단일 주소로 표시한다.
        $this->withoutLanguageInPermalink();
    }

    public function getForm(TwillModelContract $model): Form
    {
        return parent::getForm($model)
            ->addFieldset(
                Fieldset::make()->title('Content')->fields([
                    Input::make()->name('headline')->label('Headline (displayed)')->maxlength(200)
                        ->translatable()
                        ->note('The title actually shown in listings and on the detail page (switchable KO/EN). The Title field above is used only for the URL (permalink), so enter it in English.'),
                    Select::make()->name('guide_category_id')->label('Category')->searchable()->clearable()
                        ->options(
                            fn () => Options::fromArray(\App\Models\GuideCategory::query()->where('published', true)->orderBy('position')->orderBy('title')->pluck('title', 'id')->all())
                        )
                        ->note('Shown above the title in listings and on the detail page. Manage the list under Guide > Categories.'),
                    Input::make()->name('description')->label('Short description')->type(Input::TYPE_TEXTAREA)->rows(3)->maxlength(500)
                        ->translatable()
                        ->note('Summary shown in listings and at the top of the detail page.'),
                    Medias::make()->name('cover')->label('Cover')->max(1),
                    Files::make()->name('cover_video')->label('Cover video (optional)')->max(1)->filesizeMax(10)
                        ->note('Plays in place of the cover image on the detail page only — listings keep using the image. Muted, looping, no controls, and it pauses when scrolled out of view. mp4 (H.264) or webm, max 10MB, roughly 1.65:1 (close to 16:9) — other ratios are centre-cropped. The cover image above is still used as the poster frame and as the fallback, so keep it filled in.'),
                    DatePicker::make()->name('publication_date')->label('Publication date')->withoutTime(),
                    BlockEditor::make()
                        ->label('Add block')
                        ->blocks(['heading_description', 'quote', 'full_width_image', 'fixed_image_grid', 'flexible_image_grid', 'neat_gradient']),
                ])
            );
    }

    // 컬럼 전체를 직접 정의(중복 방지). 기본 title/publish 컬럼을 안 쓰고,
    // 커버를 맨 앞으로, 제목은 headline 하나만 둔다.
    protected function getIndexTableColumns(): TableColumns
    {
        $table = TableColumns::make();

        $table->add(
            Image::make()->field('cover')->title('Cover')->role('cover')->crop('default')
                ->mediaParams(['w' => 80, 'h' => 80, 'fit' => 'crop'])
        );

        $table->add(Text::make()->field('headline')->title('Title')->linkToEdit()->sortable());

        // 관계 컬럼이라 field 로는 못 읽는다 — customRender 로 제목을 꺼낸다.
        $table->add(
            Text::make()->field('guide_category_id')->title('Category')
                ->customRender(fn (TwillModelContract $guide): string => $guide->guideCategory?->title ?: '—')
        );

        $table->add(
            Text::make()->field('publication_date')->title('Publication date')->sortable()
                ->customRender(fn (TwillModelContract $guide): string => $guide->publication_date
                    ? $guide->publication_date->format('Y-m-d')
                    : '—')
        );

        $table->add(PublishStatus::make()->title('Published')->optional());

        return $table;
    }
}
