<?php

namespace DavideCasiraghi\LaravelSmartBlog\Tests;

use Illuminate\Foundation\Auth\User;
use Illuminate\Foundation\Testing\WithFaker;
use DavideCasiraghi\LaravelSmartBlog\Models\Blog;

class BlogControllerTest extends TestCase
{
    use WithFaker;

    /***************************************************************/

    /** @test */
    /*public function it_runs_the_test_factory()
    {
        $category = factory(Blog::class)->create([
                            'name' => 'Regular Jams',
                            'slug' => 'regular-jams',
                        ]);
        $this->assertDatabaseHas('category_translations', [
                                'locale' => 'en',
                                'name' => 'Regular Jams',
                                'slug' => 'regular-jams',
                ]);
    }*/

    /** @test */
    public function it_displays_the_event_blogs_index_page()
    {
        $this->authenticateAsAdmin();
        $this->get('blogs')
            ->assertViewIs('laravel-smart-blog::blogs.index')
            ->assertStatus(200);
    }

    /** @test */
    public function it_displays_the_blog_create_page()
    {
        $this->authenticateAsAdmin();
        $this->get('blogs/create')
             ->assertViewIs('laravel-smart-blog::blogs.create')
             ->assertStatus(200);
    }

    /** @test */
    public function it_stores_a_valid_blog()
    {
        $this->authenticateAsAdmin();
        
        $category = factory(\DavideCasiraghi\LaravelSmartBlog\Models\Category::class)->create();
        $user = User::first();
        
        $data = [
            'category_id' => '1',
            'layout' => '1',
            'columns' => '3',
            'article_order' => '1',
            'pagination' => '1',
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
            'created_by' => $user->id,  
        ];

        $response = $this
            ->followingRedirects()
            ->post('/blogs', $data);

        $this->assertDatabaseHas('blogs', ['category_id' => '1']);
        $response->assertViewIs('laravel-smart-blog::blogs.index');
    }

    /** @test */
    /*public function it_does_not_store_invalid_category()
    {
        $this->authenticateAsAdmin();
        $response = $this->post('/categories', []);
        $response->assertSessionHasErrors();
        $this->assertNull(Category::first());
    }*/

    /** @test */
    /*public function it_displays_the_category_show_page()
    {
        $this->authenticateAsAdmin();

        $category = factory(Category::class)->create();
        $response = $this->get('/categories/'.$category->id);
        $response->assertViewIs('laravel-smart-blog::categories.show')
                 ->assertStatus(200);
    }*/

    /** @test */
    public function it_displays_the_blog_edit_page()
    {
        $this->authenticateAsAdmin();
        
        $blog = factory(Blog::class)->create();
        $response = $this->get("/blogs/{$blog->id}/edit");
        $response->assertViewIs('laravel-smart-blog::blogs.edit')
                 ->assertStatus(200);
    }

    /** @test */
    /*public function it_updates_valid_category()
    {
        $this->authenticateAsAdmin();
        $category = factory(Category::class)->create();

        $attributes = ([
            'name' => 'test name updated',
            'slug' => 'test slug updated',
          ]);

        $response = $this->followingRedirects()
                         ->put('/categories/'.$category->id, $attributes);
        $response->assertViewIs('laravel-smart-blog::categories.index')
                 ->assertStatus(200);
    }*/

    /** @test */
    /*public function it_does_not_update_invalid_category()
    {
        $this->authenticateAsAdmin();

        $category = factory(Category::class)->create();
        $response = $this->put('/categories/'.$category->id, []);
        $response->assertSessionHasErrors();
    }*/

    /** @test */
    /*public function it_deletes_a_blog()
    {
        $this->authenticateAsAdmin();

        $blog = factory(Blog::class)->create();

        $response = $this->delete('/blogs/'.$blog->id);
        $response->assertRedirect('/blogs');
    }*/
}
