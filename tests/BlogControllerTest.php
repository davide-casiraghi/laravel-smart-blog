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
    /*public function it_displays_the_event_categories_index_page()
    {
        $this->authenticateAsAdmin();
        $this->get('categories')
            ->assertViewIs('laravel-smart-blog::categories.index')
            ->assertStatus(200);
    }*/

    /** @test */
    public function it_displays_the_blog_create_page()
    {
        $this->authenticateAsAdmin();
        $this->get('blogs/create')
             ->assertViewIs('laravel-smart-blog::blogs.create')
             ->assertStatus(200);
    }

    /** @test */
    /*public function it_stores_a_valid_category()
    {
        $this->authenticateAsAdmin();

        $data = [
            'name' => 'test title',
            'slug' => 'test body',
        ];

        $response = $this
            ->followingRedirects()
            ->post('/categories', $data);

        $this->assertDatabaseHas('category_translations', ['locale' => 'en']);
        $response->assertViewIs('laravel-smart-blog::categories.index');
    }*/

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
    /*public function it_displays_the_category_edit_page()
    {
        $this->authenticateAsAdmin();

        $category = factory(Category::class)->create();
        $response = $this->get("/categories/{$category->id}/edit");
        $response->assertViewIs('laravel-smart-blog::categories.edit')
                 ->assertStatus(200);
    }*/

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
    /*public function it_deletes_event_categories()
    {
        $this->authenticateAsAdmin();

        $category = factory(Category::class)->create();

        $response = $this->delete('/categories/'.$category->id);
        $response->assertRedirect('/categories');
    }*/
}
