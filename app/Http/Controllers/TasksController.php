<?php

namespace App\Http\Controllers;

use App\Models\Lists;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    // TODO Build view()
    // TODO Build update()
    // TODO Build delete()

    public function create(Request $request, String $list_id): RedirectResponse
    {
        $request->validate([
            $list_id => 'numeric|exists:lists,id',
            'task' => 'string'
        ]);

        $list = Lists::where([
            ['id', '=', $list_id],
            ['user_id', '=', $request->user()->id]
        ])->first();

        $list->tasks()->create([
            'todo' => $request->task,
            'completed' => false
        ]);

        return to_route('lists.view', ['id' => $list_id]);
    }
}
