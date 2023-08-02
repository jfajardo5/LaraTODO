<?php

namespace App\Http\Controllers;

use App\Models\Lists;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class ListsController extends Controller
{
    // TODO allow for create() to include a name for the list, and fix it to route to the right template
    // TODO Build update()
    // TODO Build delete()
    public function all(Request $request): Response
    {
        $lists = $request->user()->lists()->get()->map(function ($list) {
            return [
                'id' => $list->id,
                'title' => $list->title,
                'url' => "/lists/" . $list->id,
                'tasks_count' => $list->tasks()->count()
            ];
        });
        return Inertia::render('Dashboard', [
            'lists' => $lists
        ]);
    }

    public function create(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'string'
        ]);

        $list = new Lists();
        $list->user_id = $request->user()->id;
        $list->title = $request->title;
        $list->save();

        return to_route('lists.view', ['id' => $list->id]);
    }

    public function view(Request $request, String $id): Response
    {
        $list = $request->user()->lists()->findOrFail($id);
        return Inertia::render('List', [
            'list' => $list,
            'tasks' => $list->tasks()->get()
        ]);
    }
}
