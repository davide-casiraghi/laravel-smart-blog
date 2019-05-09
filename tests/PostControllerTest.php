<?php

namespace DavideCasiraghi\LaravelSmartBlog\Tests;

use Illuminate\Foundation\Auth\User;
use Illuminate\Foundation\Testing\WithFaker;
use DavideCasiraghi\LaravelSmartBlog\Models\Post;
use DavideCasiraghi\LaravelSmartBlog\Models\Category;

class PostControllerTest extends TestCase
{
    use WithFaker;

    /***************************************************************/

    /** @test */
    public function it_runs_the_test_factory()
    {
        $post = factory(Post::class)->create([
                            'title' => 'Regular Jams',
                            'slug' => 'regular-jams',
                        ]);
        $this->assertDatabaseHas('post_translations', [
                                'locale' => 'en',
                                'title' => 'Regular Jams',
                                'slug' => 'regular-jams',
                ]);
    }

    /** @test */
    public function it_displays_the_event_posts_index_page()
    {
        $this->authenticateAsAdmin();
        $this->get('posts')
            ->assertViewIs('laravel-smart-blog::posts.index')
            ->assertStatus(200);
    }

    /** @test */
    public function it_displays_the_post_create_page()
    {
        $this->authenticateAsAdmin();
        $this->get('posts/create')
             ->assertViewIs('laravel-smart-blog::posts.create')
             ->assertStatus(200);
    }

    /** @test */
    public function it_stores_a_valid_post()
    {
        $this->authenticateAsAdmin();
        $category = factory(Category::class)->create();
        
        $data = [
            'title' => 'test title',
            'body' => 'test body',
            'category_id' => 1,
            'status'  => 1,
        ];
        $response = $this
            ->followingRedirects()
            ->post('/posts', $data);

        $this->assertDatabaseHas('post_translations', ['locale' => 'en']);
        $response->assertViewIs('laravel-smart-blog::posts.index');
    }

    /** @test */
    public function it_does_not_store_invalid_post()
    {
        $this->authenticateAsAdmin();
        $response = $this->post('/posts', []);
        $response->assertSessionHasErrors();
        $this->assertNull(Post::first());
    }

    /** @test */
    public function it_displays_the_post_show_page()
    {
        $this->authenticateAsAdmin();

        $post = factory(Post::class)->create();
        $response = $this->get('/posts/'.$post->id);
        $response->assertViewIs('laravel-smart-blog::posts.show')
                 ->assertStatus(200);
    }

    /** @test */
    public function it_displays_the_post_edit_page()
    {
        $this->authenticateAsAdmin();

        $post = factory(Post::class)->create();
        $response = $this->get("/posts/{$post->id}/edit");
        $response->assertViewIs('laravel-smart-blog::posts.edit')
                 ->assertStatus(200);
    }

    /** @test */
    public function it_updates_valid_post()
    {
        $this->authenticateAsAdmin();
        $category = factory(Category::class)->create();
        $post = factory(Post::class)->create([
            'category_id' => 1,
        ]);

        $attributes = ([
            'title' => 'test title updated',
          ]);

        $response = $this->followingRedirects()
                         ->put('/posts/'.$post->id, $attributes);
        $response->assertViewIs('laravel-smart-blog::posts.index')
                 ->assertStatus(200);
    }

    /** @test */
    public function it_does_not_update_invalid_post()
    {
        $this->authenticateAsAdmin();

        $post = factory(Post::class)->create();
        $response = $this->put('/posts/'.$post->id, []);
        $response->assertSessionHasErrors();
    }

    /** @test */
    public function it_deletes_event_posts()
    {
        $this->authenticateAsAdmin();

        $post = factory(Post::class)->create();

        $response = $this->delete('/posts/'.$post->id);
        $response->assertRedirect('/posts');
    }
}
