<?php

namespace DavideCasiraghi\LaravelSmartBlog\Http\Controllers;

use Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use DavideCasiraghi\LaravelSmartBlog\Models\BlogTranslation;

class BlogTranslationController extends Controller
{
    /***************************************************************************/
    /* Restrict the access to this resource just to logged in users */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /***************************************************************************/

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /*public function index()
    {
        //
    }*/

    /***************************************************************************/

    /**
     * Show the form for creating a new resource.
     * @param int $blogId
     * @param string $languageCode
     * @return \Illuminate\Http\Response
     */
    public function create($blogId, $languageCode)
    {
        $selectedLocaleName = $this->getSelectedLocaleName($languageCode);

        return view('laravel-smart-blog::blogTranslations.create')
                ->with('blogId', $blogId)
                ->with('languageCode', $languageCode)
                ->with('selectedLocaleName', $selectedLocaleName);
    }

    // **********************************************************************

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $blogId
     * @param string $languageCode
     * @return \Illuminate\Http\Response
     */
    public function edit($blogId, $languageCode)
    {
        $blogTranslation = BlogTranslation::where('blog_id', $blogId)
                        ->where('locale', $languageCode)
                        ->first();

        $selectedLocaleName = $this->getSelectedLocaleName($languageCode);

        return view('laravel-smart-blog::blogTranslations.edit', compact('blogTranslation'))
                    ->with('blogId', $blogId)
                    ->with('languageCode', $languageCode)
                    ->with('selectedLocaleName', $selectedLocaleName);
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
                'name' => 'required',
            ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $blogTranslation = new BlogTranslation();
        $blogTranslation->blog_id = $request->get('blog_id');
        $blogTranslation->locale = $request->get('language_code');

        $blogTranslation->name = $request->get('name');
        $blogTranslation->description = $request->get('description');
        $blogTranslation->slug = Str::slug($blogTranslation->name, '-');

        $blogTranslation->save();

        return redirect()->route('blogs.index')
                        ->with('success', 'Translation created successfully.');
    }

    /***************************************************************************/

    /**
     * Display the specified resource.
     *
     * @param  \DavideCasiraghi\LaravelSmartBlog\Models\BlogTranslation  $blogTranslation
     * @return \Illuminate\Http\Response
     */
    /*public function show(BlogTranslation $blogTranslation)
    {
        //
    }*/

    /***************************************************************************/

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        request()->validate([
            'name' => 'required',
        ]);

        $blogTranslation = BlogTranslation::where('id', $request->get('blog_translation_id'));

        $blog_t = [];
        $blog_t['name'] = $request->get('name');
        $blog_t['description'] = $request->get('description');
        $blog_t['slug'] = Str::slug($request->get('name'), '-');

        $blogTranslation->update($blog_t);

        return redirect()->route('blogs.index')
                        ->with('success', 'Translation updated successfully');
    }

    /***************************************************************************/

    /**
     * Remove the specified resource from storage.
     *
     * @param int $blogTranslationId
     * @return \Illuminate\Http\Response
     */
    public function destroy($blogTranslationId)
    {
        $blogTranslation = BlogTranslation::find($blogTranslationId);
        $blogTranslation->delete();

        return redirect()->route('blogs.index')
                        ->with('success', __('messages.blog_translation_deleted_successfully'));
    }
}
