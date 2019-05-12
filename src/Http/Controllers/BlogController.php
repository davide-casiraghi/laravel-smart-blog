<?php

namespace DavideCasiraghi\LaravelSmartBlog\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use DavideCasiraghi\LaravelSmartBlog\Models\Blog;
use DavideCasiraghi\LaravelSmartBlog\Models\Post;
use DavideCasiraghi\LaravelSmartBlog\Models\Category;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class BlogController extends Controller
{
    /* Restrict the access to this resource just to logged in users */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::get();
        $blogs = Blog::latest()->paginate(10);

        // Countries available for translations
        $countriesAvailableForTranslations = LaravelLocalization::getSupportedLocales();

        return view('laravel-smart-blog::blogs.index', compact('blogs'))
            ->with('i', (request()->input('page', 1) - 1) * 10)
            ->with('categories', $categories)
            ->with('countriesAvailableForTranslations', $countriesAvailableForTranslations);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$categories = Category::get();
        $categories = Category::listsTranslations('name')->pluck('name', 'id');

        return view('laravel-smart-blog::blogs.create')
            ->with('categories', $categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate form datas
        $validator = Validator::make($request->all(), [
                'category_id' => 'required',
                'layout' => 'required',
            ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $blog = new Blog();

        $this->saveOnDb($request, $blog);

        return redirect()->route('blogs.index')
                        ->with('success', __('messages.blog_added_successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \DavideCasiraghi\LaravelSmartBlog\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blog)
    {
        //$category = Category::where('id', $blog->category_id)->get();

        $category = Category::select('categories.id AS id', 'category_translations.name AS name', 'category_translations.description AS description', 'category_translations.slug AS slug', 'locale')
                ->join('category_translations', 'categories.id', '=', 'category_translations.category_id')->first();

        $posts = Post::where('category_id', $blog->category_id)->get();

        /*$posts = Post::select('post.id AS id', 'post_translations.title AS title', 'post_translations.body AS body', 'post_translations.slug AS slug', 'category_id', 'locale')
                ->join('post_translations', 'posts.id', '=', 'post_translations.post_id');
        */

        //$columnsBootstrapClass = "col-sm-".strval((12/intval($blog->columns)));

        $columnsBootstrapClass = (! empty($blog->columns)) ? 'col-sm-'.strval((12 / intval($blog->columns))) : '';

        //::where('code', 'gr')

        return view('laravel-smart-blog::blogs.show', compact('blog'))
                    ->with('category', $category)
                    ->with('posts', $posts)
                    ->with('columnsBootstrapClass', $columnsBootstrapClass);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \DavideCasiraghi\LaravelSmartBlog\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit(Blog $blog)
    {
        $categories = Category::listsTranslations('name')->pluck('name', 'id');

        return view('laravel-smart-blog::blogs.edit', compact('blog'))
                    ->with('categories', $categories);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \DavideCasiraghi\LaravelSmartBlog\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Blog $blog)
    {
        request()->validate([
            'category_id' => 'required',
            'layout' => 'required',
        ]);

        $this->saveOnDb($request, $blog);

        return redirect()->route('blogs.index')
                        ->with('success', __('messages.blog_updated_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DavideCasiraghi\LaravelSmartBlog\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog)
    {
        $blog->delete();

        return redirect()->route('blogs.index')
                        ->with('success', __('messages.blog_deleted_successfully'));
    }

    /***************************************************************************/

    /**
     * Save/Update the record on DB.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function saveOnDb($request, $blog)
    {
        /* Blog layout */
        $blog->category_id = $request->get('category_id');
        $blog->layout = $request->get('layout');
        $blog->columns_number = $request->get('columns_number');
        $blog->columns_width = $request->get('columns_width');
        $blog->article_order = $request->get('article_order');

        $blog->items_per_page = $request->get('items_per_page');
        $blog->featured_articles = $request->get('featured_articles');
        $blog->show_category_title = $request->get('show_category_title');
        $blog->show_category_subtitle = $request->get('show_category_subtitle');
        $blog->show_category_description = $request->get('show_category_description');
        $blog->show_category_image = $request->get('show_category_image');

        $blog->show_post_title = $request->get('show_post_title');
        $blog->post_linked_titles = $request->get('post_linked_titles');
        $blog->show_post_intro_text = $request->get('show_post_intro_text');
        $blog->show_post_author = $request->get('show_post_author');
        $blog->link_post_author = $request->get('link_post_author');

        $blog->show_create_date = $request->get('show_create_date');
        $blog->show_modify_date = $request->get('show_modify_date');
        $blog->show_publish_date = $request->get('show_publish_date');
        $blog->show_read_more = $request->get('show_read_more');

        /* Post layout */

        $blog->created_by = \Auth::user()->id;

        $blog->save();
    }
}
