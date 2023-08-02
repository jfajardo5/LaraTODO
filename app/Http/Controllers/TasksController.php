<?php

namespace App\Http\Controllers;

use App\Models\Tasks;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    // TODO Build view()
    // TODO Build delete()
    public function create(Request $request, String $list_id): RedirectResponse
    {
        $request->validate([
            $list_id => 'numeric|exists:lists,id',
            'task' => 'string|required'
        ]);

        $list = $request->user()->lists()->findOrFail($list_id);

        $task = new Tasks;
        $task->todo = $request->task;
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

        $task = Tasks::where([
            'user_id' => $request->user()->id,
            'lists_id' => $list_id
        ])->findOrFail($task_id);

        $task->todo = $request->todo;
        $task->completed = $request->completed;
        $task->save();
    }
}
