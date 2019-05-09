<?php

namespace DavideCasiraghi\LaravelSmartBlog\Tests;

use Illuminate\Foundation\Testing\WithFaker;
use DavideCasiraghi\LaravelSmartBlog\Models\Post;

class PostTranslationControllerTest extends TestCase
{
    use WithFaker;

    /***************************************************************/

    /** @test */
    public function it_displays_the_post_translation_create_page()
    {
        $this->authenticateAsAdmin();

        $postId = 1;
        $languageCode = 'es';

        $this->get('/postTranslations/'.$postId.'/'.$languageCode.'/create')
            ->assertViewIs('laravel-smart-blog::postTranslations.create')
            ->assertStatus(200);
    }

    /** @test */
    public function it_stores_a_valid_post_translation()
    {
        $this->authenticateAsAdmin();
        $post = factory(Post::class)->create([
                            'name' => 'Regular Jams',
                            'slug' => 'regular-jams',
                        ]);

        $data = [
            'category_id' => $post->id,
            'language_code' => 'es',
            'name' => 'Spanish category name',
        ];

        $response = $this
            ->followingRedirects()
            ->post('/postTranslations/store', $data);

        $this->assertDatabaseHas('post_translations', ['locale' => 'es', 'name' => 'Spanish category name']);
        $response->assertViewIs('laravel-smart-blog::posts.index');
    }

    /** @test */
    public function it_does_not_store_invalid_post_translation()
    {
        $this->authenticateAsAdmin();
        $response = $this
            ->followingRedirects()
            ->post('/postTranslations/store', []);

        $response->assertSessionHasErrors();
    }

    /** @test */
    public function it_displays_the_post_translation_edit_page()
    {
        $this->authenticateAsAdmin();
        $post = factory(Post::class)->create([
                            'name' => 'Regular Jams',
                            'slug' => 'regular-jams',
                        ]);

        $data = [
            'category_id' => $post->id,
            'language_code' => 'es',
            'name' => 'Spanish category name',
        ];

        $this->post('/postTranslations/store', $data);

        $response = $this->get('/postTranslations/'.$post->id.'/'.'es'.'/edit');
        $response->assertViewIs('laravel-smart-blog::postTranslations.edit')
                 ->assertStatus(200);
    }

    /** @test */
    public function it_updates_valid_post_translation()
    {
        $this->authenticateAsAdmin();
        $post = factory(Post::class)->create([
                            'name' => 'Regular Jams',
                            'slug' => 'regular-jams',
                        ]);

        $data = [
            'category_id' => $post->id,
            'language_code' => 'es',
            'name' => 'Spanish category name',
        ];

        $this->post('/postTranslations/store', $data);

        // Update the translation
        $attributes = ([
            'category_translation_id' => 2,
            'language_code' => 'es',
            'name' => 'Spanish category name updated',
          ]);
        $response = $this->followingRedirects()
                         ->put('/postTranslations/update', $attributes);
        $response->assertViewIs('laravel-smart-blog::posts.index')
                 ->assertStatus(200);
        $this->assertDatabaseHas('post_translations', ['locale' => 'es', 'name' => 'Spanish category name updated']);

        // Update with no attributes - to not pass validation
        //$response = $this->followingRedirects()
                        // ->put('/postTranslations/update', [])->dump();
                        // ->assertSessionHasErrors();
    }

    /** @test */
    public function it_does_not_update_invalid_category()
    {
        $this->authenticateAsAdmin();
        $post = factory(Post::class)->create([
                            'name' => 'Regular Jams',
                            'slug' => 'regular-jams',
                        ]);

        $data = [
            'category_id' => $post->id,
            'language_code' => 'es',
            'name' => 'Spanish category name',
        ];

        $this->post('/postTranslations/store', $data);

        // Update the translation
        $attributes = ([
            'category_translation_id' => 2,
            'language_code' => 'es',
            'name' => '',
          ]);
        $response = $this->followingRedirects()
                         ->put('/postTranslations/update', $attributes);
        $response->assertSessionHasErrors();
    }

    /** @test */
    public function it_deletes_post_translation()
    {
        $this->authenticateAsAdmin();
        $post = factory(Post::class)->create();

        $data = [
            'category_id' => $post->id,
            'language_code' => 'es',
            'name' => 'Spanish category name',
        ];

        $this->post('/postTranslations/store', $data);

        $response = $this->delete('/postTranslations/destroy/2');
        $response->assertRedirect('/posts');
    }
}
