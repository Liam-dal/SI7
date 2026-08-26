<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\TableColumns;
use A17\Twill\Services\Forms\Fields\Checkbox;
use A17\Twill\Services\Forms\Fields\Input;
use A17\Twill\Services\Forms\Fields\Medias;
use A17\Twill\Services\Forms\Fields\Wysiwyg;
use A17\Twill\Services\Forms\Fieldset;
use A17\Twill\Services\Forms\Form;
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
                Fieldset::make()->title('Site & browser')->fields([
                    Input::make()->name('site_name')->label('Site name (browser tab)')->note('Shown in the browser tab. Sub pages appear as "Page name — Site name".'),
                    Medias::make()->name('favicon')->label('Favicon')->max(1)->note('Browser tab icon. Square PNG recommended (e.g. 512×512).'),
                    Medias::make()->name('og_image')->label('OG image (social sharing)')->max(1)->note('Preview image shown when the link is shared. 1200×630 recommended.'),
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
                    Input::make()->name('homepage_eyebrow')->label('Main page head kicker')->note('Small line above the title. Optional.')->translatable(),
                    Input::make()->name('homepage_title')->label('Main page head title')->note('First line, in full contrast.')->translatable(),
                    Wysiwyg::make()->name('homepage_description')->label('Main page head subhead')->note('Second line, shown muted at the same size as the title.')->limitHeight()->translatable(),
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
                Fieldset::make()->title('Contact')->fields([
                    Input::make()->name('contact_page_title')->label('Contact title')->translatable(),
                    Wysiwyg::make()->name('contact_page_description')->label('Contact description')->limitHeight()->translatable(),
                ])
            )
            ->addFieldset(
                Fieldset::make()->title('Downloads')->fields([
                    Input::make()->name('downloads_page_title')->label('Downloads title')->translatable(),
                    Wysiwyg::make()->name('downloads_page_description')->label('Downloads description')->limitHeight()->translatable(),
                ])
            )
            ->addFieldset(
                Fieldset::make()->title('Header menu')->fields([
                    Checkbox::make()->name('menu_projects_enabled')->label('Projects')->note('Off 로 두면 헤더(데스크톱·모바일) 메뉴에서 숨겨집니다. 페이지 자체는 URL 로 계속 접근할 수 있습니다.'),
                    Checkbox::make()->name('menu_about_enabled')->label('About'),
                    Checkbox::make()->name('menu_guides_enabled')->label('Guides'),
                    Checkbox::make()->name('menu_downloads_enabled')->label('Downloads'),
                    Checkbox::make()->name('menu_contact_enabled')->label('Contact'),
                ])
            )
            ->addFieldset(
                Fieldset::make()->title('Identity & Social')->fields([
                    Input::make()->name('logo_text')->label('Header logo text'),
                    Medias::make()->name('logo')->label('Header logo image (SVG or PNG)')->max(1),
                    Input::make()->name('footer_text')->label('Footer intro text')->maxlength(500)->translatable(),
                    Input::make()->name('copyright_text')->label('Copyright text')->translatable(),
                    Input::make()->name('instagram_url')->label('Instagram URL')->type('url'),
                    Input::make()->name('linkedin_url')->label('LinkedIn URL')->type('url'),
                    Input::make()->name('behance_url')->label('Behance URL')->type('url'),
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
            Text::make()->field('logo_text')->title('Logo')
        );

        return $table;
    }
}
