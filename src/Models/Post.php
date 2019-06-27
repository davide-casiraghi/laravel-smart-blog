<?php

namespace DavideCasiraghi\LaravelSmartBlog\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;

class Post extends Model
{
    /***************************************************************************/
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'posts';

    /***************************************************************************/

    use Translatable;

    public $translatedAttributes = ['title', 'intro_text', 'body', 'slug', 'before_content', 'after_content', 'extra_field_trans_1', 'extra_field_trans_2'];
    protected $fillable = ['author_id', 'category_id', 'meta_description', 'meta_keywords', 'seo_title', 'image', 'status', 'featured', 'introimage_src', 'introimage_alt', 'extra_field_1', 'extra_field_2', 'extra_field_3'];

    /***************************************************************************/

    /*
     * Return all the posts by category id in the language specified.
     *
     * @param  int $cat_id
     * @return \DavideCasiraghi\LaravelSmartBlog\Models\Post
     */
    /*public static function postsByCategory($cat_id)
    {
        $ret = self::
               where('category_id', $cat_id)
               ->get();

        return $ret;
    }*/
}
