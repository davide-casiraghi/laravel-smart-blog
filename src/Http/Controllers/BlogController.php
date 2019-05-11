<?php

namespace DavideCasiraghi\LaravelSmartBlog\Http\Controllers;

use Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use DavideCasiraghi\LaravelSmartBlog\Models\Category;
use DavideCasiraghi\LaravelSmartBlog\Models\Post;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($blogKind, $categoryId)
    {
        $posts = Post::where('category_id', $categoryId)
                        ->orderBy('created_at')
                        ->paginate(20);



        // Countries available for translations
        $countriesAvailableForTranslations = LaravelLocalization::getSupportedLocales();

        return view('laravel-smart-blog::blogs.index', compact('categories'))
            ->with('i', (request()->input('page', 1) - 1) * 5)
            ->with('countriesAvailableForTranslations', $countriesAvailableForTranslations);
    }
}
