<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\TableColumns;
use A17\Twill\Services\Forms\Fields\Checkbox;
use A17\Twill\Services\Forms\Fields\Input;
use A17\Twill\Services\Forms\Fields\Medias;
use A17\Twill\Services\Forms\Fields\Select;
use A17\Twill\Services\Forms\Fields\Wysiwyg;
use A17\Twill\Services\Forms\Fieldset;
use A17\Twill\Services\Forms\Form;
use A17\Twill\Services\Forms\Options;
use A17\Twill\Http\Controllers\Admin\SingletonModuleController as BaseModuleController;

class SiteSettingController extends BaseModuleController
{
    protected $moduleName = 'siteSettings';
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
                Fieldset::make()->title('사이트 · 브라우저 · 소셜')->fields([
                    Input::make()->name('site_name')->label('사이트명 (브라우저 탭)')->note('브라우저 탭 제목에 표시됩니다. 하위 페이지는 "페이지명 — 사이트명"으로 표시됩니다.'),
                    Medias::make()->name('favicon')->label('파비콘')->max(1)->note('브라우저 탭 아이콘. 정사각형 PNG 권장 (예: 512×512).'),
                    Medias::make()->name('og_image')->label('OG 이미지 (소셜 공유)')->max(1)->note('링크 공유 시 표시되는 대표 이미지. 1200×630 권장.'),
                ])
            )
            ->addFieldset(
                Fieldset::make()->title('Global SEO')->fields([
                    Input::make()->name('seo_title_prefix')->label('Global title prefix')->translatable(),
                    Input::make()->name('seo_title_suffix')->label('Global title suffix')->translatable(),
                    Input::make()->name('seo_description_prefix')->label('Global description prefix')->maxlength(500)->translatable(),
                    Input::make()->name('seo_description_suffix')->label('Global description suffix')->maxlength(500)->translatable(),
                ])
            )
            ->addFieldset(
                Fieldset::make()->title('Homepage')->fields([
                    Input::make()->name('homepage_eyebrow')->label('Main hero eyebrow')->translatable(),
                    Input::make()->name('homepage_title')->label('Main hero title')->translatable(),
                    Wysiwyg::make()->name('homepage_description')->label('Main hero description')->limitHeight()->translatable(),
                    Select::make()->name('homepage_regular_grid')->label('일반 프로젝트 목록 레이아웃')->options(
                        Options::fromArray([
                            'editorial' => '에디토리얼 — 첫 카드 크게, 나머지 2단',
                            'grid_3' => '스탠다드 — 균일한 3단 그리드',
                        ])
                    )->default('editorial'),
                ])
            )
            ->addFieldset(
                Fieldset::make()->title('Projects')->fields([
                    Input::make()->name('projects_page_title')->label('Work page title')->translatable(),
                    Wysiwyg::make()->name('projects_page_description')->label('Work page description')->limitHeight()->translatable(),
                    Input::make()->name('projects_sectors_title')->label('Projects by sectors title')->translatable(),
                    Wysiwyg::make()->name('projects_sectors_description')->label('Projects by sectors description')->limitHeight()->translatable(),
                    Input::make()->name('projects_disciplines_title')->label('Projects by disciplines title')->translatable(),
                    Wysiwyg::make()->name('projects_disciplines_description')->label('Projects by disciplines description')->limitHeight()->translatable(),
                    Input::make()->name('projects_all_title')->label('All projects title')->translatable(),
                    Wysiwyg::make()->name('projects_all_description')->label('All projects description')->limitHeight()->translatable(),
                    Input::make()->name('projects_alphabetical_title')->label('All projects alphabetical title')->translatable(),
                    Wysiwyg::make()->name('projects_alphabetical_description')->label('All projects alphabetical description')->limitHeight()->translatable(),
                ])
            )
            ->addFieldset(
                Fieldset::make()->title('About')->fields([
                    Input::make()->name('about_page_title')->label('About title')->translatable(),
                    Wysiwyg::make()->name('about_page_description')->label('About description')->limitHeight()->translatable(),
                ])
            )
            ->addFieldset(
                Fieldset::make()->title('Guide')->fields([
                    Input::make()->name('guide_page_title')->label('Guide title')->translatable(),
                    Wysiwyg::make()->name('guide_page_description')->label('Guide description')->limitHeight()->translatable(),
                ])
            )
            ->addFieldset(
                Fieldset::make()->title('Contact & Downloads')->fields([
                    Input::make()->name('contact_page_title')->label('Contact title')->translatable(),
                    Wysiwyg::make()->name('contact_page_description')->label('Contact description')->limitHeight()->translatable(),
                    Input::make()->name('downloads_page_title')->label('Downloads title')->translatable(),
                    Wysiwyg::make()->name('downloads_page_description')->label('Downloads description')->limitHeight()->translatable(),
                ])
            )
            ->addFieldset(
                Fieldset::make()->title('Identity & Social')->fields([
                    Input::make()->name('logo_text')->label('헤더 로고 텍스트'),
                    Medias::make()->name('logo')->label('헤더 로고 이미지 (SVG 또는 PNG)')->max(1),
                    Input::make()->name('footer_text')->label('푸터 소개 문구')->maxlength(500)->translatable(),
                    Input::make()->name('copyright_text')->label('저작권 문구')->translatable(),
                    Input::make()->name('instagram_url')->label('Instagram 링크')->type('url'),
                    Input::make()->name('linkedin_url')->label('LinkedIn 링크')->type('url'),
                    Input::make()->name('behance_url')->label('Behance 링크')->type('url'),
                ])
            );
    }

    /**
     * This is an example and can be removed if no modifications are needed to the table.
     */
    protected function additionalIndexTableColumns(): TableColumns
    {
        $table = parent::additionalIndexTableColumns();

        $table->add(
            Text::make()->field('logo_text')->title('로고')
        );

        return $table;
    }
}
