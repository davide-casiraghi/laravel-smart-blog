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

    /**
     * Return the post categories array
     * the collection is transferred to an array to symulate the pluck behaviour,
     * and get the category name translated or the relative fallbacks.
     * (otherwise the pluck has empty names because doesn't fallback).
     *
     * @return array
     */
    /*public static function getCategoriesArray()
    {
        $ret = [];
        $categories = self::get();

        foreach ($categories as $key => $category) {
            $ret[$category->id] = $category->name;
        }

        return $ret;
    }*/

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
