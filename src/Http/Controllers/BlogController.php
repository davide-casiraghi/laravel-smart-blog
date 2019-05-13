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

        $columnsBootstrapClass = (! empty($blog->columns_number)) ? 'col-md-'.strval((12 / intval($blog->columns_number))) : '';

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
        $blog->show_category_title = filter_var($request->show_category_title, FILTER_VALIDATE_BOOLEAN);
        $blog->show_category_subtitle = filter_var($request->show_category_subtitle, FILTER_VALIDATE_BOOLEAN);
        $blog->show_category_description = filter_var($request->show_category_description, FILTER_VALIDATE_BOOLEAN);
        $blog->show_category_image = filter_var($request->show_category_image, FILTER_VALIDATE_BOOLEAN);

        $blog->show_post_title = filter_var($request->show_post_title, FILTER_VALIDATE_BOOLEAN);
        $blog->post_linked_titles = filter_var($request->post_linked_titles, FILTER_VALIDATE_BOOLEAN);
        $blog->show_post_intro_text = filter_var($request->show_post_intro_text, FILTER_VALIDATE_BOOLEAN);
        $blog->show_post_author = filter_var($request->show_post_author, FILTER_VALIDATE_BOOLEAN);
        $blog->link_post_author = filter_var($request->link_post_author, FILTER_VALIDATE_BOOLEAN);

        $blog->show_create_date = filter_var($request->show_create_date, FILTER_VALIDATE_BOOLEAN);
        $blog->show_modify_date = filter_var($request->show_modify_date, FILTER_VALIDATE_BOOLEAN);
        $blog->show_publish_date = filter_var($request->show_publish_date, FILTER_VALIDATE_BOOLEAN); 
        $blog->show_read_more = filter_var($request->show_read_more, FILTER_VALIDATE_BOOLEAN); 

        $blog->created_by = \Auth::user()->id;

        $blog->save();
    }
}
