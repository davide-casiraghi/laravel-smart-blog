<?php

namespace DavideCasiraghi\LaravelSmartBlog\Tests;

use Illuminate\Foundation\Testing\WithFaker;
use DavideCasiraghi\LaravelSmartBlog\Models\Post;
use DavideCasiraghi\LaravelSmartBlog\Models\Category;
use Illuminate\Support\Facades\Storage;

use DavideCasiraghi\LaravelSmartBlog\Http\Controllers\PostController;

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
            'intro_text'  => 'test intro text',
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
            'intro_text' => 'test intro text updated',
            'body' => 'body updated',
            'category_id' => 1,
            'status'  => 1,
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
    
    /** @test */
    public function it_uploads_a_post_intro_image()
    {
        $this->authenticateAsAdmin();
        
        // Delete directory
        //dd(Storage::directories('public/images')); // List directories
        $directory = 'public/images/posts_intro_images/';
        Storage::deleteDirectory($directory);

        // Symulate the upload
        $local_test_file = __DIR__.'/test_images/test_image_1.jpg';
        $uploadedFile = new \Illuminate\Http\UploadedFile(
                $local_test_file,
                'test_image_1.jpg',
                'image/jpg',
                null,
                null,
                true
            );

        // Call the function uploadImageOnServer()
        $imageFile = $uploadedFile;
        $imageName = $imageFile->hashName();
        $imageSubdir = 'posts_intro_images';
        $imageWidth = '968';
        $thumbWidth = '300';

        PostController::uploadImageOnServer($imageFile, $imageName, $imageSubdir, $imageWidth, $thumbWidth);

        // Leave this lines here - they can be very useful for new tests
        //$directory = "/";
        //dump(Storage::allDirectories($directory));
        //dd(Storage::allFiles($directory));

        $filePath = 'public/images/'.$imageSubdir.'/'.$imageName;

        Storage::assertExists($filePath);
    }
}
