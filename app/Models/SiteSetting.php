<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Model;

class SiteSetting extends Model 
{
    use HasMedias, HasRevisions;

    public array $mediasParams = ['logo'];

    protected $fillable = [
        'published',
        'title',
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
        'homepage_title',
        'homepage_description',
        'homepage_regular_grid',
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
    
}
