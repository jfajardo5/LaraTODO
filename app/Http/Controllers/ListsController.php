<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;

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

    public function create(Request $request): Response
    {
        $request->user()->lists()->create();
        return Inertia::render('List', [
            'lists' => $request->user()->lists()
        ]);
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
