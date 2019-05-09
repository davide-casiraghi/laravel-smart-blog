<?php

namespace DavideCasiraghi\LaravelSmartBlog\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /***************************************************************************/
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'categories';

    /***************************************************************************/

    use \Dimsav\Translatable\Translatable;

    public $translatedAttributes = ['name', 'description', 'slug'];
    protected $fillable = [];
    public $useTranslationFallback = true;

    /***************************************************************************/

    /*
     * Return the category name.
     *
     * @param  int  $categoryId
     * @return string
     */
    /*public static function getCategoryName($categoryId)
    {
        $ret = self::find($categoryId)->name;

        return $ret;
    }*/
}
