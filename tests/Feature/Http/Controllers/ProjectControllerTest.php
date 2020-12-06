<?php

namespace Tests\Feature\Http\Controllers;

use App\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ProjectController
 */
class ProjectControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $projects = Project::factory()->count(3)->create();

        $response = $this->get(route('project.index'));

        $response->assertOk();
        $response->assertViewIs('project.index');
        $response->assertViewHas('projects');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('project.create'));

        $response->assertOk();
        $response->assertViewIs('project.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ProjectController::class,
            'store',
            \App\Http\Requests\ProjectStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $title = $this->faker->sentence(4);
        $image = $this->faker->text;
        $description = $this->faker->text;

        $response = $this->post(route('project.store'), [
            'title' => $title,
            'image' => $image,
            'description' => $description,
        ]);

        $projects = Project::query()
            ->where('title', $title)
            ->where('image', $image)
            ->where('description', $description)
            ->get();
        $this->assertCount(1, $projects);
        $project = $projects->first();

        $response->assertRedirect(route('project.index'));
        $response->assertSessionHas('project.id', $project->id);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $project = Project::factory()->create();

        $response = $this->get(route('project.show', $project));

        $response->assertOk();
        $response->assertViewIs('project.show');
        $response->assertViewHas('project');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $project = Project::factory()->create();

        $response = $this->get(route('project.edit', $project));

        $response->assertOk();
        $response->assertViewIs('project.edit');
        $response->assertViewHas('project');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ProjectController::class,
            'update',
            \App\Http\Requests\ProjectUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $project = Project::factory()->create();
        $title = $this->faker->sentence(4);
        $image = $this->faker->text;
        $description = $this->faker->text;

        $response = $this->put(route('project.update', $project), [
            'title' => $title,
            'image' => $image,
            'description' => $description,
        ]);

        $project->refresh();

        $response->assertRedirect(route('project.index'));
        $response->assertSessionHas('project.id', $project->id);

        $this->assertEquals($title, $project->title);
        $this->assertEquals($image, $project->image);
        $this->assertEquals($description, $project->description);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $project = Project::factory()->create();

        $response = $this->delete(route('project.destroy', $project));

        $response->assertRedirect(route('project.index'));

        $this->assertDeleted($project);
    }
}
