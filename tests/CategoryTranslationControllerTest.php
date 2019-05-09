<?php

namespace DavideCasiraghi\LaravelSmartBlog\Tests;

use Illuminate\Foundation\Testing\WithFaker;
use DavideCasiraghi\LaravelSmartBlog\Models\Category;

class CategoryTranslationControllerTest extends TestCase
{
    use WithFaker;

    /***************************************************************/

    /** @test */
    public function it_displays_the_category_translation_create_page()
    {
        $this->authenticateAsAdmin();

        $categoryId = 1;
        $languageCode = 'es';

        $this->get('/categoryTranslations/'.$categoryId.'/'.$languageCode.'/create')
            ->assertViewIs('laravel-smart-blog::categoryTranslations.create')
            ->assertStatus(200);
    }

    /** @test */
    public function it_stores_a_valid_category_translation()
    {
        $this->authenticateAsAdmin();
        $category = factory(Category::class)->create([
                            'name' => 'Regular Jams',
                            'slug' => 'regular-jams',
                        ]);

        $data = [
            'category_id' => $category->id,
            'language_code' => 'es',
            'name' => 'Spanish category name',
        ];

        $response = $this
            ->followingRedirects()
            ->post('/categoryTranslations/store', $data);

        $this->assertDatabaseHas('category_translations', ['locale' => 'es', 'name' => 'Spanish category name']);
        $response->assertViewIs('laravel-smart-blog::categories.index');
    }

    /** @test */
    public function it_does_not_store_invalid_category_translation()
    {
        $this->authenticateAsAdmin();
        $response = $this
            ->followingRedirects()
            ->post('/categoryTranslations/store', []);

        $response->assertSessionHasErrors();
    }

    /** @test */
    public function it_displays_the_category_translation_edit_page()
    {
        $this->authenticateAsAdmin();
        $category = factory(Category::class)->create([
                            'name' => 'Regular Jams',
                            'slug' => 'regular-jams',
                        ]);

        $data = [
            'category_id' => $category->id,
            'language_code' => 'es',
            'name' => 'Spanish category name',
        ];

        $this->post('/categoryTranslations/store', $data);

        $response = $this->get('/categoryTranslations/'.$category->id.'/'.'es'.'/edit');
        $response->assertViewIs('laravel-smart-blog::categoryTranslations.edit')
                 ->assertStatus(200);
    }

    /** @test */
    public function it_updates_valid_category_translation()
    {
        $this->authenticateAsAdmin();
        $category = factory(Category::class)->create([
                            'name' => 'Regular Jams',
                            'slug' => 'regular-jams',
                        ]);

        $data = [
            'category_id' => $category->id,
            'language_code' => 'es',
            'name' => 'Spanish category name',
        ];

        $this->post('/categoryTranslations/store', $data);

        // Update the translation
        $attributes = ([
            'category_translation_id' => 2,
            'language_code' => 'es',
            'name' => 'Spanish category name updated',
          ]);
        $response = $this->followingRedirects()
                         ->put('/categoryTranslations/update', $attributes);
        $response->assertViewIs('laravel-smart-blog::categories.index')
                 ->assertStatus(200);
        $this->assertDatabaseHas('category_translations', ['locale' => 'es', 'name' => 'Spanish category name updated']);

        // Update with no attributes - to not pass validation
        //$response = $this->followingRedirects()
                        // ->put('/categoryTranslations/update', [])->dump();
                        // ->assertSessionHasErrors();
    }

    /** @test */
    public function it_does_not_update_invalid_category()
    {
        $this->authenticateAsAdmin();
        $category = factory(Category::class)->create([
                            'name' => 'Regular Jams',
                            'slug' => 'regular-jams',
                        ]);

        $data = [
            'category_id' => $category->id,
            'language_code' => 'es',
            'name' => 'Spanish category name',
        ];

        $this->post('/categoryTranslations/store', $data);

        // Update the translation
        $attributes = ([
            'category_translation_id' => 2,
            'language_code' => 'es',
            'name' => '',
          ]);
        $response = $this->followingRedirects()
                         ->put('/categoryTranslations/update', $attributes);
        $response->assertSessionHasErrors();
    }

    /** @test */
    public function it_deletes_category_translation()
    {
        $this->authenticateAsAdmin();
        $category = factory(Category::class)->create();

        $data = [
            'category_id' => $category->id,
            'language_code' => 'es',
            'name' => 'Spanish category name',
        ];

        $this->post('/categoryTranslations/store', $data);

        $response = $this->delete('/categoryTranslations/destroy/2');
        $response->assertRedirect('/categories');
    }
}
