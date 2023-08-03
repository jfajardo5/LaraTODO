<?php

namespace App\Http\Controllers;

use App\Models\Tasks;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

// TODO Write tests
class TasksController extends Controller
{
    public function create(Request $request, String $list_id): RedirectResponse
    {
        $request->validate([
            $list_id => 'numeric|exists:lists,id',
            'task' => 'string|required'
        ]);

        $list = $request->user()->lists()->findOrFail($list_id);

        $task = new Tasks;
        $task->todo = Str::limit($request->task, 255);
        $task->user_id = $request->user()->id;
        $task->lists_id = $list->id;
        $task->save();

        return to_route('lists.view', ['id' => $list->id]);
    }

    public function update(Request $request, String $list_id, String $task_id)
    {
        $request->validate([
            $list_id => 'numeric|exists:lists,id',
            $task_id => 'numeric|exists:tasks,id',
            'todo' => 'string|required',
            'completed' => 'boolean|required'
        ]);

        $task = $request->user()
            ->lists()
            ->findOrFail($list_id)
            ->tasks()->findOrFail($task_id);

        $task->todo = Str::limit($request->todo, 255);
        $task->completed = $request->completed;
        $task->save();
    }

    public function delete(Request $request, String $list_id, String $task_id): RedirectResponse
    {
        $request->validate([
            $list_id => 'numeric|exists:lists,id',
            $task_id => 'numeric|exists:tasks,id'
        ]);

        $request->user()->lists()->findOrFail($list_id)->tasks()->findOrFail($task_id)->delete();

        return to_route('lists.view', ['id' => $list_id]);
    }
}
