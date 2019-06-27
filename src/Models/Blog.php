<?php

namespace DavideCasiraghi\LaravelSmartBlog\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Blog extends Model
{
    /***************************************************************************/
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'blogs';

    /***************************************************************************/

    use Translatable;

    public $translatedAttributes = ['name', 'description', 'slug'];
    protected $fillable = [
        'category_id',
        'layout',
        'columns_number',
        'columns_width',
        'article_order',
        'items_per_page',
        'featured_articles',
        'show_category_title',
        'show_category_subtitle',
        'show_category_description',
        'show_category_image',
        'show_post_title',
        'post_linked_titles',
        'show_post_intro_text',
        'show_post_author',
        'link_post_author',
        'show_create_date',
        'show_modify_date',
        'show_publish_date',
        'show_read_more',
        'created_by',
    ];

    /***************************************************************************/
}
