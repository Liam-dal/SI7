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
                Fieldset::make()->title('인터랙티브 히어로')->fields([
                    Checkbox::make()->name('hero_builder')->label('인터랙티브 히어로 사용 (We design [Discipline] for [Sector])')
                        ->note('켜면 홈 최상단이 "We design ___ for ___" 문장 빌더 + 배경 슬라이드쇼로 바뀝니다. 끄면 기본 히어로가 표시됩니다.'),
                    Select::make()->name('hero_default_category_id')->label('기본 Discipline (We design ___ )')->placeholder('미선택 — 전체(everything)')->clearable()->options(
                        fn () => Options::fromArray(\App\Models\Category::query()->where('published', true)->orderBy('position')->pluck('title', 'id')->all())
                    ),
                    Select::make()->name('hero_default_sector_id')->label('기본 Sector ( for ___ )')->placeholder('미선택 — 전체(everyone)')->clearable()->options(
                        fn () => Options::fromArray(\App\Models\Sector::query()->where('published', true)->orderBy('position')->pluck('title', 'id')->all())
                    ),
                ])
            )
            ->add(
                BlockEditor::make()
                    ->name('default')
                    ->label('홈 Featured 섹션')
                    ->blocks(['featured_section'])
            );
    }
}
