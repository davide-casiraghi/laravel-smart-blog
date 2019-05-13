<?php

namespace DavideCasiraghi\LaravelSmartBlog\Tests;

use Illuminate\Foundation\Testing\WithFaker;
use DavideCasiraghi\LaravelSmartBlog\Models\Blog;

class BlogTranslationControllerTest extends TestCase
{
    use WithFaker;

    /***************************************************************/

    /** @test */
    public function it_displays_the_blog_translation_create_page()
    {
        $this->authenticateAsAdmin();

        $blogId = 1;
        $languageCode = 'es';

        $this->get('/blogTranslations/'.$blogId.'/'.$languageCode.'/create')
            ->assertViewIs('laravel-smart-blog::blogTranslations.create')
            ->assertStatus(200);
    }

    /** @test */
    public function it_stores_a_valid_blog_translation()
    {
        $this->authenticateAsAdmin();
        $blog = factory(Blog::class)->create([
                            'category_id' => '1',
                            'layout' => '1',
                            'columns_number' => '3',
                            'columns_width' => '200',
                            'article_order' => '1',
                            'items_per_page' => '20',
                            'featured_articles' => '1',
                            'show_category_title' => '1',
                            'show_category_subtitle' => '1',
                            'show_category_description' => '1',
                            'show_category_image' => '1',
                            'show_post_title' => '1',
                            'post_linked_titles' => '1',
                            'show_post_intro_text' => '1',
                            'show_post_author' => '1',
                            'link_post_author' => '1',
                            'show_create_date' => '1',
                            'show_modify_date' => '1',
                            'show_publish_date' => '1',
                            'show_read_more' => '1',
                            'created_by' => '1',
                        ]);

        $data = [
            'blog_id' => $blog->id,
            'language_code' => 'es',
            'name' => 'Spanish category name',
        ];

        $response = $this
            ->followingRedirects()
            ->post('/blogTranslations/store', $data);

        $this->assertDatabaseHas('blog_translations', ['locale' => 'es', 'name' => 'Spanish category name']);
        $response->assertViewIs('laravel-smart-blog::blogs.index');
    }

    /** @test */
    public function it_does_not_store_invalid_blog_translation()
    {
        $this->authenticateAsAdmin();
        $response = $this
            ->followingRedirects()
            ->post('/blogTranslations/store', []);

        $response->assertSessionHasErrors();
    }

    /** @test */
    public function it_displays_the_blog_translation_edit_page()
    {
        $this->authenticateAsAdmin();
        $blog = factory(Blog::class)->create([
                        'category_id' => '1',
                        'layout' => '1',
                        'columns_number' => '3',
                        'columns_width' => '200',
                        'article_order' => '1',
                        'items_per_page' => '20',
                        'featured_articles' => '1',
                        'show_category_title' => '1',
                        'show_category_subtitle' => '1',
                        'show_category_description' => '1',
                        'show_category_image' => '1',
                        'show_post_title' => '1',
                        'post_linked_titles' => '1',
                        'show_post_intro_text' => '1',
                        'show_post_author' => '1',
                        'link_post_author' => '1',
                        'show_create_date' => '1',
                        'show_modify_date' => '1',
                        'show_publish_date' => '1',
                        'show_read_more' => '1',
                        'created_by' => '1',
                        ]);

        $data = [
            'blog_id' => $blog->id,
            'language_code' => 'es',
            'name' => 'Spanish category name',
        ];

        $this->post('/blogTranslations/store', $data);

        $response = $this->get('/blogTranslations/'.$blog->id.'/'.'es'.'/edit');
        $response->assertViewIs('laravel-smart-blog::blogTranslations.edit')
                 ->assertStatus(200);
    }

    /** @test */
    public function it_updates_valid_blog_translation()
    {
        $this->authenticateAsAdmin();
        $blog = factory(Blog::class)->create([
                        'category_id' => '1',
                        'layout' => '1',
                        'columns_number' => '3',
                        'columns_width' => '200',
                        'article_order' => '1',
                        'items_per_page' => '20',
                        'featured_articles' => '1',
                        'show_category_title' => '1',
                        'show_category_subtitle' => '1',
                        'show_category_description' => '1',
                        'show_category_image' => '1',
                        'show_post_title' => '1',
                        'post_linked_titles' => '1',
                        'show_post_intro_text' => '1',
                        'show_post_author' => '1',
                        'link_post_author' => '1',
                        'show_create_date' => '1',
                        'show_modify_date' => '1',
                        'show_publish_date' => '1',
                        'show_read_more' => '1',
                        'created_by' => '1',
                        ]);

        $data = [
            'blog_id' => $blog->id,
            'language_code' => 'es',
            'name' => 'Spanish category name',
        ];

        $this->post('/blogTranslations/store', $data);

        // Update the translation
        $attributes = ([
            'blog_translation_id' => 2,
            'language_code' => 'es',
            'name' => 'Spanish category name updated',
          ]);
        $response = $this->followingRedirects()
                         ->put('/blogTranslations/update', $attributes);
        $response->assertViewIs('laravel-smart-blog::blogs.index')
                 ->assertStatus(200);
        $this->assertDatabaseHas('blog_translations', ['locale' => 'es', 'name' => 'Spanish category name updated']);
    }

    /** @test */
    public function it_does_not_update_invalid_blog()
    {
        $this->authenticateAsAdmin();
        $blog = factory(Blog::class)->create([
                'category_id' => '1',
                'layout' => '1',
                'columns_number' => '3',
                'columns_width' => '200',
                'article_order' => '1',
                'items_per_page' => '20',
                'featured_articles' => '1',
                'show_category_title' => '1',
                'show_category_subtitle' => '1',
                'show_category_description' => '1',
                'show_category_image' => '1',
                'show_post_title' => '1',
                'post_linked_titles' => '1',
                'show_post_intro_text' => '1',
                'show_post_author' => '1',
                'link_post_author' => '1',
                'show_create_date' => '1',
                'show_modify_date' => '1',
                'show_publish_date' => '1',
                'show_read_more' => '1',
                'created_by' => '1',
                        ]);

        $data = [
            'blog_id' => $blog->id,
            'language_code' => 'es',
            'name' => 'Spanish category name',
        ];

        $this->post('/blogTranslations/store', $data);

        // Update the translation
        $attributes = ([
            'blog_translation_id' => 2,
            'language_code' => 'es',
            'name' => '',
          ]);
        $response = $this->followingRedirects()
                         ->put('/blogTranslations/update', $attributes);
        $response->assertSessionHasErrors();
    }

    /** @test */
    public function it_deletes_blog_translation()
    {
        $this->authenticateAsAdmin();
        $blog = factory(Blog::class)->create();

        $data = [
            'blog_id' => $blog->id,
            'language_code' => 'es',
            'name' => 'Spanish category name',
        ];

        $this->post('/blogTranslations/store', $data);

        $response = $this->delete('/blogTranslations/destroy/2');
        $response->assertRedirect('/blogs');
    }
}
