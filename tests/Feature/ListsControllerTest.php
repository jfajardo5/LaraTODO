<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use function PHPUnit\Framework\assertEmpty;
use function PHPUnit\Framework\assertTrue;

class ListsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_route_receives_the_correct_json_response(): void
    {
        $user = \App\Models\User::get()->first();
        $lists = $user->lists()->get()->map(function ($list) {
            return [
                'id' => $list->id,
                'title' => $list->title,
                'url' => "/lists/" . $list->id,
                'tasks_count' => $list->tasks()->count()
            ];
        });
        $response = $this->actingAs($user)->get(route('dashboard'));
        $response->assertOk();
        $response->assertSee($lists);
    }

    public function test_lists_view_route_receives_the_correct_json_response(): void
    {
        $user = \App\Models\User::get()->first();
        $list = $user->lists()->get()->first();
        $tasks = $list->tasks()->get();
        $response = $this->actingAs($user)->get(route('lists.view', ['id' => $list->id]));
        $response->assertOk();
        $response->assertSee($list);
        $response->assertSee($tasks);
    }

    public function test_lists_create_route_successfully_creates_a_list(): void
    {
        $user = \App\Models\User::get()->first();
        $title = fake()->sentence();
        $response = $this->actingAs($user)->post(route('lists.create'), ['title' => $title]);
        $response->assertStatus(302);
        $list = $user->lists()->where('title', $title)->get()->first();
        assertTrue($list->title == $title);
    }

    public function test_lists_delete_route_deletes_a_list_successfully(): void
    {
        $user = \App\Models\User::get()->first();
        $list = $user->lists()->get()->first();
        $response = $this->actingAs($user)->delete(route('lists.delete', ['id' => $list->id]));
        $response->assertStatus(302);
        assertEmpty(\App\Models\Lists::where('id', $list->id)->get());
    }
}
