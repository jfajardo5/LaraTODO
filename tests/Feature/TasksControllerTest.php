<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use function PHPUnit\Framework\assertTrue;
use function PHPUnit\Framework\assertEmpty;

class TasksControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_tasks_create_route_creates_a_new_task_successfully(): void
    {
        $user = \App\Models\User::get()->first();
        $list = $user->lists()->get()->first();
        $todo = fake()->sentence();
        $response = $this->actingAs($user)->post(route('tasks.create', ['list_id' => $list->id]), ['todo' => $todo]);
        $response->assertStatus(302);
        $task = $list->tasks()->where('todo', $todo)->get()->first();
        assertTrue($task->todo == $todo);
    }

    public function test_tasks_update_route_updates_a_task_successfully(): void
    {
        $user = \App\Models\User::get()->first();
        $list = $user->lists()->get()->first();
        $task = $list->tasks()->get()->first();
        $todo = fake()->sentence();
        $completed = true;
        $response = $this->actingAs($user)->patch(
            route(
                'tasks.update',
                [
                    'list_id' => $list->id,
                    'task_id' => $task->id
                ]
            ),
            [
                'todo' => $todo,
                'completed' => $completed
            ]
        );
        $response->assertOk();
        $task->refresh();
        assertTrue($task->todo == $todo);
        assertTrue($task->completed == $completed);
    }

    public function test_tasks_delete_route_deletes_a_task_successfully(): void
    {
        $user = \App\Models\User::get()->first();
        $list = $user->lists()->get()->first();
        $task = $list->tasks()->get()->first();
        $response = $this->actingAs($user)->delete(route(
            'tasks.delete',
            [
                'list_id' => $list->id,
                'task_id' => $task->id
            ]
        ));
        $response->assertStatus(302);
        assertEmpty(\App\Models\Tasks::where('id', $task->id)->get());
    }
}
