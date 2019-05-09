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
                            'title' => 'English post title',
                            'slug' => 'english-post-title',
                        ]);

        $data = [
            'post_id' => $post->id,
            'language_code' => 'es',
            'title' => 'Spanish post title',
            'body' => 'Spanish post body',
        ];

        $response = $this
            ->followingRedirects()
            ->post('/postTranslations/store', $data);

        $this->assertDatabaseHas('post_translations', ['locale' => 'es', 'title' => 'Spanish post title']);
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
                            'title' => 'Regular Jams',
                            'slug' => 'regular-jams',
                        ]);

        $data = [
            'post_id' => $post->id,
            'language_code' => 'es',
            'title' => 'Spanish post title',
            'body' => 'Spanish post body',
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
                            'title' => 'Regular Jams',
                            'slug' => 'regular-jams',
                        ]);

        $data = [
            'post_id' => $post->id,
            'language_code' => 'es',
            'title' => 'Spanish post title',
            'body' => 'Spanish post body',
        ];

        $this->post('/postTranslations/store', $data);

        // Update the translation
        $attributes = ([
            'post_translation_id' => 2,
            'language_code' => 'es',
            'title' => 'Spanish post title updated',
            'body' => 'Spanish post body updated',
          ]);
        $response = $this->followingRedirects()
                         ->put('/postTranslations/update', $attributes);
        $response->assertViewIs('laravel-smart-blog::posts.index')
                 ->assertStatus(200);
        $this->assertDatabaseHas('post_translations', ['locale' => 'es', 'title' => 'Spanish post title updated']);

        // Update with no attributes - to not pass validation
        //$response = $this->followingRedirects()
                        // ->put('/postTranslations/update', [])->dump();
                        // ->assertSessionHasErrors();
    }

    /** @test */
    public function it_does_not_update_invalid_post_translation()
    {
        $this->authenticateAsAdmin();
        $post = factory(Post::class)->create([
                            'title' => 'Regular Jams',
                            'slug' => 'regular-jams',
                        ]);

        $data = [
            'post_id' => $post->id,
            'language_code' => 'es',
            'title' => 'Spanish post title',
            'body' => 'Spanish post body',
        ];

        $this->post('/postTranslations/store', $data);

        // Update the translation
        $attributes = ([
            'category_translation_id' => 2,
            'language_code' => 'es',
            'title' => '',
            'body' => 'Spanish post body 2',
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
            'post_id' => $post->id,
            'language_code' => 'es',
            'title' => 'Spanish post title',
            'body' => 'Spanish post body',
        ];

        $this->post('/postTranslations/store', $data);

        $response = $this->delete('/postTranslations/destroy/2');
        $response->assertRedirect('/posts');
    }
}
