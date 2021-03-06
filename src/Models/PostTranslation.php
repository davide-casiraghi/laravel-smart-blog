<?php

namespace DavideCasiraghi\LaravelSmartBlog\Models;

use Illuminate\Database\Eloquent\Model;

class PostTranslation extends Model
{
    /***************************************************************************/
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'post_translations';

    /***************************************************************************/

    public $timestamps = false;
    protected $fillable = ['title', 'intro_text', 'body', 'slug', 'before_content', 'after_content', 'extra_field_trans_1', 'extra_field_trans_2'];
}
