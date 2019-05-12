<?php

namespace DavideCasiraghi\LaravelSmartBlog\Models;

use Illuminate\Database\Eloquent\Model;

class BlogTranslation extends Model
{
    /***************************************************************************/
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'blog_translations';

    /***************************************************************************/

    public $timestamps = false;
    protected $fillable = ['name', 'slug'];
}
