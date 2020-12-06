<?php

namespace Tests\Feature\Http\Controllers;

use App\Site;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\SiteController
 */
class SiteControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $sites = Site::factory()->count(3)->create();

        $response = $this->get(route('site.index'));

        $response->assertOk();
        $response->assertViewIs('site.index');
        $response->assertViewHas('sites');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('site.create'));

        $response->assertOk();
        $response->assertViewIs('site.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\SiteController::class,
            'store',
            \App\Http\Requests\SiteStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $logo = $this->faker->text;
        $favicon = $this->faker->text;
        $smallText = $this->faker->word;
        $title = $this->faker->sentence(4);
        $countary = $this->faker->word;
        $phone = $this->faker->phoneNumber;
        $email = $this->faker->safeEmail;
        $address = $this->faker->word;

        $response = $this->post(route('site.store'), [
            'logo' => $logo,
            'favicon' => $favicon,
            'smallText' => $smallText,
            'title' => $title,
            'countary' => $countary,
            'phone' => $phone,
            'email' => $email,
            'address' => $address,
        ]);

        $sites = Site::query()
            ->where('logo', $logo)
            ->where('favicon', $favicon)
            ->where('smallText', $smallText)
            ->where('title', $title)
            ->where('countary', $countary)
            ->where('phone', $phone)
            ->where('email', $email)
            ->where('address', $address)
            ->get();
        $this->assertCount(1, $sites);
        $site = $sites->first();

        $response->assertRedirect(route('site.index'));
        $response->assertSessionHas('site.id', $site->id);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $site = Site::factory()->create();

        $response = $this->get(route('site.show', $site));

        $response->assertOk();
        $response->assertViewIs('site.show');
        $response->assertViewHas('site');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $site = Site::factory()->create();

        $response = $this->get(route('site.edit', $site));

        $response->assertOk();
        $response->assertViewIs('site.edit');
        $response->assertViewHas('site');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\SiteController::class,
            'update',
            \App\Http\Requests\SiteUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $site = Site::factory()->create();
        $logo = $this->faker->text;
        $favicon = $this->faker->text;
        $smallText = $this->faker->word;
        $title = $this->faker->sentence(4);
        $countary = $this->faker->word;
        $phone = $this->faker->phoneNumber;
        $email = $this->faker->safeEmail;
        $address = $this->faker->word;

        $response = $this->put(route('site.update', $site), [
            'logo' => $logo,
            'favicon' => $favicon,
            'smallText' => $smallText,
            'title' => $title,
            'countary' => $countary,
            'phone' => $phone,
            'email' => $email,
            'address' => $address,
        ]);

        $site->refresh();

        $response->assertRedirect(route('site.index'));
        $response->assertSessionHas('site.id', $site->id);

        $this->assertEquals($logo, $site->logo);
        $this->assertEquals($favicon, $site->favicon);
        $this->assertEquals($smallText, $site->smallText);
        $this->assertEquals($title, $site->title);
        $this->assertEquals($countary, $site->countary);
        $this->assertEquals($phone, $site->phone);
        $this->assertEquals($email, $site->email);
        $this->assertEquals($address, $site->address);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $site = Site::factory()->create();

        $response = $this->delete(route('site.destroy', $site));

        $response->assertRedirect(route('site.index'));

        $this->assertDeleted($site);
    }
}
