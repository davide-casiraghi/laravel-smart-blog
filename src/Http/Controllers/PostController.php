<?php

namespace DavideCasiraghi\LaravelSmartBlog\Http\Controllers;

use Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
// use App\Classes\CardClass;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
// use App\Classes\ColumnsClass;
// use App\Classes\GalleryClass;
// use App\Classes\AccordionClass;
// use App\Classes\StatsDonateClass;
// use App\Classes\PaypalButtonClass;
use DavideCasiraghi\LaravelSmartBlog\Models\Post;
// use App\Classes\CardsCarouselClass;
use DavideCasiraghi\LaravelSmartBlog\Models\Category;
// use App\Classes\CommunityGoalsClass;
use DavideCasiraghi\LaravelCards\Facades\LaravelCards;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use DavideCasiraghi\ResponsiveGallery\Facades\ResponsiveGallery;
use DavideCasiraghi\BootstrapAccordion\Facades\BootstrapAccordion;
use DavideCasiraghi\LaravelJumbotronImages\Facades\LaravelJumbotronImages;

class PostController extends Controller
{
    public function __construct()
    {

        //Restrict the access to this resource just to logged in users except show view
        $this->middleware('admin', ['except' => ['show', 'postBySlug']]);
    }

    /***************************************************************************/

    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //$categories = Category::getCategoriesArray();
        $categories = Category::listsTranslations('name')->pluck('name', 'id');

        $searchKeywords = $request->input('keywords');
        $searchCategory = $request->input('category_id');

        // Returns all countries having translations
        //dd(Post::translated()->get());

        // Countries available for translations
        $countriesAvailableForTranslations = LaravelLocalization::getSupportedLocales();
        //DB::enableQueryLog();

        if ($searchKeywords || $searchCategory) {
            $posts = Post::
                select('post_translations.post_id AS id', 'post_translations.title AS title', 'status', 'featured', 'introimage', 'introimage_alt', 'category_id', 'locale')
                ->join('post_translations', 'posts.id', '=', 'post_translations.post_id')

                ->when($searchKeywords, function ($query, $searchKeywords) {
                    return $query->where('post_translations.locale', '=', 'en')
                                 ->where(function ($query) use ($searchKeywords) {
                                     $query->where('post_translations.title', $searchKeywords)
                                                  ->orWhere('post_translations.title', 'like', '%'.$searchKeywords.'%');
                                 });
                })
                ->when($searchCategory, function ($query, $searchCategory) {
                    return $query->where('post_translations.locale', '=', 'en')
                                 ->where(function ($query) use ($searchCategory) {
                                     $query->where('category_id', '=', $searchCategory);
                                 });
                })
                ->paginate(20);
        } else {
            $posts = Post::listsTranslations('title')->select('posts.id', 'title', 'category_id', 'status', 'featured', 'introimage', 'introimage_alt')->orderBy('title')->paginate(20);
        }

        //dd(DB::getQueryLog());

        return view('laravel-smart-blog::posts.index', compact('posts'))
            ->with('i', (request()->input('page', 1) - 1) * 20)
            ->with('categories', $categories)
            ->with('searchKeywords', $searchKeywords)
            ->with('searchCategory', $searchCategory)
            ->with('countriesAvailableForTranslations', $countriesAvailableForTranslations);
    }

    /***************************************************************************/

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$categories = Category::getCategoriesArray();
        $categories = Category::listsTranslations('name')->pluck('name', 'id');

        return view('laravel-smart-blog::posts.create')->with('categories', $categories);
    }

    /***************************************************************************/

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
                'title' => 'required',
                'body' => 'required',
                'category_id' => 'required',
            ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $post = new Post();

        // Set the default language to edit the post for the admin to English (to avoid bug with null titles)
        //App::setLocale('en'); //removed for the package!!! maybe we still need it!!!

        $this->saveOnDb($request, $post);

        return redirect()->route('posts.index')
                        ->with('success', __('laravel-smart-blog::messages.article_added_successfully'));
    }

    /***************************************************************************/

    /**
     * Display the specified resource.
     *
     * @param  \DavideCasiraghi\LaravelSmartBlog\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {

        // Accordion
        $post->body = BootstrapAccordion::getAccordions($post->body, 'plus-minus-circle');

        // Gallery
        $publicPath = public_path('storage');
        $post->body = ResponsiveGallery::getGallery($post->body, $publicPath);
        $post->before_content = ResponsiveGallery::getGallery($post->before_content, $publicPath);
        $post->after_content = ResponsiveGallery::getGallery($post->after_content, $publicPath);

        // Cards
        $post->body = LaravelCards::replace_card_snippets_with_template($post->body);
        $post->before_content = LaravelCards::replace_card_snippets_with_template($post->before_content);
        $post->after_content = LaravelCards::replace_card_snippets_with_template($post->after_content);

        // JumbotronImages
        $post->body = LaravelJumbotronImages::replaceJumbotronSnippetsWithTemplate($post->body);
        $post->before_content = LaravelJumbotronImages::replaceJumbotronSnippetsWithTemplate($post->before_content);
        $post->after_content = LaravelJumbotronImages::replaceJumbotronSnippetsWithTemplate($post->after_content);

        /*
                // Card
                $cardClass = new CardClass();
                $post->body = $cardClass->getCard($post->body);
                $post->before_content = $cardClass->getCard($post->before_content);
                $post->after_content = $cardClass->getCard($post->after_content);

                // Category Columns
                $cardsCarouselClass = new CardsCarouselClass();
                $post->body = $cardsCarouselClass->getColumns($post->body);
                $post->before_content = $cardsCarouselClass->getColumns($post->before_content);
                $post->after_content = $cardsCarouselClass->getColumns($post->after_content);

                // Category Columns
                $columnClass = new ColumnsClass();
                $post->body = $columnClass->getColumns($post->body);
                $post->before_content = $columnClass->getColumns($post->before_content);
                $post->after_content = $columnClass->getColumns($post->after_content);

                // Stats Donate
                $statsDonateClass = new StatsDonateClass();
                $post->body = $statsDonateClass->getStatsDonate($post->body);
                $post->before_content = $statsDonateClass->getStatsDonate($post->before_content);
                $post->after_content = $statsDonateClass->getStatsDonate($post->after_content);

                // Stats Donate
                $communityGoalsClass = new CommunityGoalsClass();
                $post->body = $communityGoalsClass->getCommunityGoals($post->body);

                // Paypal Button
                $paypalButton = new PaypalButtonClass();
                $post->body = $paypalButton->getPaypalButton($post->body);

                // Gallery
                $storagePath = storage_path('app/public');
                $publicPath = public_path();
                //dump($storagePath,$publicPath);
                $galleryClass = new GalleryClass();
                //dump($post->body);
                $post->body = $galleryClass->getGallery($post->body, $storagePath, $publicPath);
                $post->before_content = $galleryClass->getGallery($post->before_content, $storagePath, $publicPath);
                $post->after_content = $galleryClass->getGallery($post->after_content, $storagePath, $publicPath);
        */

        return view('laravel-smart-blog::posts.show', compact('post'));
    }

    /***************************************************************************/

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \DavideCasiraghi\LaravelSmartBlog\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //$categories = Category::getCategoriesArray();
        $categories = Category::listsTranslations('name')->pluck('name', 'id');
        //$categories = Category::getCategoriesArray();

        return view('laravel-smart-blog::posts.edit', compact('post'))->with('categories', $categories);
    }

    /***************************************************************************/

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \DavideCasiraghi\LaravelSmartBlog\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        request()->validate([
            'title' => 'required',
            'body' => 'required',
            'category_id' => 'required',
        ]);

        // Set the default language to edit the post for the admin to English (to avoid bug with null titles)
        //App::setLocale('en');

        $this->saveOnDb($request, $post);

        return redirect()->route('posts.index')
                        ->with('success', __('laravel-smart-blog::messages.article_updated_successfully'));
    }

    /***************************************************************************/

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DavideCasiraghi\LaravelSmartBlog\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('posts.index')
                        ->with('success', __('laravel-smart-blog::messages.article_deleted_successfully'));
    }

    /***************************************************************************/

    /**
     * Return the single post datas by post id [title, body, image].
     *
     * @param  int $post_id
     * @return \DavideCasiraghi\LaravelSmartBlog\Models\Post
     */
    public function postdata($post_id)
    {
        $ret = Post::where('id', $post_id)->first();

        return $ret;
    }

    /***************************************************************************/

    /**
     * Return the post by SLUG. (eg. http://websitename.com/post/xxxxx).
     *
     * @param  string $slug
     * @return \Illuminate\Http\Response
     */
    public function postBySlug($slug)
    {
        $post = Post::
                where('post_translations.slug', $slug)
                ->join('post_translations', 'posts.id', '=', 'post_translations.post_id')
                ->select('posts.*', 'post_translations.title', 'post_translations.intro_text', 'post_translations.body', 'post_translations.before_content', 'post_translations.after_content')
                ->first();

        return $this->show($post);
    }

    /***************************************************************************/

    /**
     * Save the record on DB.
     * @param  \Illuminate\Http\Request  $request
     * @param  \DavideCasiraghi\LaravelSmartBlog\Models\Post  $post
     * @return void
     */
    public function saveOnDb($request, $post)
    {
        $post->translateOrNew('en')->title = $request->get('title');
        $post->translateOrNew('en')->body = clean($request->get('body'));
        $post->translateOrNew('en')->intro_text = $request->get('intro_text');
        $post->created_by = \Auth::user()->id;
        $post->translateOrNew('en')->slug = Str::slug($post->title, '-');
        $post->category_id = $request->get('category_id');

        $post->status = $request->get('status');
        $post->featured = $request->get('featured');

        // Intro image  picture upload
        if ($request->file('introimage')) {
            $imageFile = $request->file('introimage');
            $imageName = $imageFile->hashName();
            $imageSubdir = 'posts_intro_images';
            $imageWidth = '968';
            $thumbWidth = '300';

            $this->uploadImageOnServer($imageFile, $imageName, $imageSubdir, $imageWidth, $thumbWidth);
            $post->introimage = $imageName;
        } else {
            $post->introimage = $request->introimage;
        }

        $post->translateOrNew('en')->before_content = $request->get('before_content');
        $post->translateOrNew('en')->after_content = $request->get('after_content');

        $post->save();
    }
}
