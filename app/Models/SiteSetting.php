<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Behaviors\HasTranslation;
use A17\Twill\Models\Model;

class SiteSetting extends Model
{
    use HasMedias, HasRevisions, HasTranslation;

    // 사용자에게 보이는 텍스트(페이지 제목·설명·히어로·SEO 문구·푸터)는 한/영 번역.
    // URL·색상·크기 토큰·site_name·logo_text 등은 번역하지 않음.
    public $translatedAttributes = [
        'seo_title_prefix', 'seo_title_suffix', 'seo_description_prefix', 'seo_description_suffix',
        'homepage_eyebrow', 'homepage_title', 'homepage_headline_words', 'homepage_description',
        'projects_page_title', 'projects_page_description',
        'projects_sectors_title', 'projects_sectors_description',
        'projects_disciplines_title', 'projects_disciplines_description',
        'projects_all_title', 'projects_all_description',
        'projects_alphabetical_title', 'projects_alphabetical_description',
        'about_page_title', 'about_page_description',
        'guide_page_title', 'guide_page_description',
        'contact_page_title', 'contact_page_description',
        'downloads_page_title', 'downloads_page_description',
        'footer_text', 'copyright_text',
    ];

    public array $mediasParams = [
        'logo' => [
            'default' => [[
                'name' => 'default',
                'ratio' => 0,
            ]],
        ],
        'favicon' => [
            'default' => [[
                'name' => 'default',
                'ratio' => 1,
            ]],
        ],
        'og_image' => [
            'default' => [[
                'name' => 'default',
                'ratio' => 0,
            ]],
        ],
    ];

    protected $fillable = [
        'published',
        'title',
        'site_name',
        'logo_text',
        'footer_text',
        'copyright_text',
        'instagram_url',
        'linkedin_url',
        'behance_url',
        'seo_title_prefix',
        'seo_title_suffix',
        'seo_description_prefix',
        'seo_description_suffix',
        'homepage_eyebrow',
        'homepage_title',
        'homepage_headline_words',
        'homepage_description',
        'home_hero_builder',
        'home_hero_default_category_id',
        'home_hero_default_sector_id',
        'menu_projects_enabled',
        'menu_about_enabled',
        'menu_guides_enabled',
        'menu_downloads_enabled',
        'menu_contact_enabled',
        'projects_page_title',
        'projects_page_description',
        'projects_sectors_title',
        'projects_sectors_description',
        'projects_disciplines_title',
        'projects_disciplines_description',
        'projects_all_title',
        'projects_all_description',
        'projects_alphabetical_title',
        'projects_alphabetical_description',
        'about_page_title',
        'about_page_description',
        'contact_page_title',
        'contact_page_description',
        'downloads_page_title',
        'downloads_page_description',
        'guide_page_title',
        'guide_page_description',
        'background_color',
        'text_color',
        'muted_text_color',
        'page_gutter',
        'section_spacing',
        'card_radius',
        'link_hover_style',
        'page_title_size', 'page_title_line_height', 'page_title_tracking',
        'menu_size', 'menu_line_height', 'menu_tracking',
        'hero_title_size', 'hero_title_line_height', 'hero_title_tracking',
        'body_size', 'body_line_height', 'body_tracking',
        'body_small_size', 'body_small_line_height', 'body_small_tracking',
        'paragraph_size', 'paragraph_line_height', 'paragraph_tracking',
        'caption_size', 'caption_line_height', 'caption_tracking',
    ];

    protected $casts = [
        'menu_projects_enabled' => 'boolean',
        'menu_about_enabled' => 'boolean',
        'menu_guides_enabled' => 'boolean',
        'menu_downloads_enabled' => 'boolean',
        'menu_contact_enabled' => 'boolean',
    ];
    
}
