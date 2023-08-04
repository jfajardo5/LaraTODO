<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use function PHPUnit\Framework\assertTrue;

class TasksControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_route_creates_a_new_task_successfully(): void
    {
        $user = \App\Models\User::get()->first();
        $list = $user->lists()->get()->first();
        $todo = fake()->sentence();
        $response = $this->actingAs($user)->post(route('tasks.create', ['list_id' => $list->id]), ['todo' => $todo]);
        $response->assertStatus(302);
        $task = $list->tasks()->where('todo', $todo)->get()->first();
        assertTrue($task->todo == $todo);
    }
}
