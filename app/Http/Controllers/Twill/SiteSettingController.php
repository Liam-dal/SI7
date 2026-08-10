<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\TableColumns;
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
                Fieldset::make()->title('Global SEO')->fields([
                    Input::make()->name('seo_title_prefix')->label('Global title prefix'),
                    Input::make()->name('seo_title_suffix')->label('Global title suffix'),
                    Input::make()->name('seo_description_prefix')->label('Global description prefix')->maxlength(500),
                    Input::make()->name('seo_description_suffix')->label('Global description suffix')->maxlength(500),
                ])
            )
            ->addFieldset(
                Fieldset::make()->title('Homepage')->fields([
                    Input::make()->name('homepage_title')->label('Homepage title'),
                    Wysiwyg::make()->name('homepage_description')->label('Homepage description')->limitHeight(),
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
                    Input::make()->name('projects_sectors_title')->label('Projects by sectors title'),
                    Wysiwyg::make()->name('projects_sectors_description')->label('Projects by sectors description')->limitHeight(),
                    Input::make()->name('projects_disciplines_title')->label('Projects by disciplines title'),
                    Wysiwyg::make()->name('projects_disciplines_description')->label('Projects by disciplines description')->limitHeight(),
                    Input::make()->name('projects_all_title')->label('All projects title'),
                    Wysiwyg::make()->name('projects_all_description')->label('All projects description')->limitHeight(),
                    Input::make()->name('projects_alphabetical_title')->label('All projects alphabetical title'),
                    Wysiwyg::make()->name('projects_alphabetical_description')->label('All projects alphabetical description')->limitHeight(),
                ])
            )
            ->addFieldset(
                Fieldset::make()->title('About')->fields([
                    Input::make()->name('about_page_title')->label('About title'),
                    Wysiwyg::make()->name('about_page_description')->label('About description')->limitHeight(),
                ])
            )
            ->addFieldset(
                Fieldset::make()->title('Contact & Downloads')->fields([
                    Input::make()->name('contact_page_title')->label('Contact title'),
                    Wysiwyg::make()->name('contact_page_description')->label('Contact description')->limitHeight(),
                    Input::make()->name('downloads_page_title')->label('Downloads title'),
                    Wysiwyg::make()->name('downloads_page_description')->label('Downloads description')->limitHeight(),
                ])
            )
            ->addFieldset(
                Fieldset::make()->title('Identity & Social')->fields([
                    Input::make()->name('logo_text')->label('헤더 로고 텍스트'),
                    Medias::make()->name('logo')->label('헤더 로고 이미지 (SVG 또는 PNG)')->max(1),
                    Input::make()->name('footer_text')->label('푸터 소개 문구')->maxlength(500),
                    Input::make()->name('copyright_text')->label('저작권 문구'),
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
