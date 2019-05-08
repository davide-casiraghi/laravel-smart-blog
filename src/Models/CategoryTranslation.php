<?php

namespace DavideCasiraghi\LaravelSmartBlog\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryTranslation extends Model
{
    /***************************************************************************/
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'category_translations';

    /***************************************************************************/

    public $timestamps = false;
    protected $fillable = ['name', 'description', 'slug'];
}
