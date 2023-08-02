<?php

namespace App\Http\Controllers;

use App\Models\Lists;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class ListsController extends Controller
{
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

    public function view(Request $request, String $id): Response
    {
        $list = $request->user()->lists()->findOrFail($id);
        return Inertia::render('List', [
            'list' => $list,
            'tasks' => $list->tasks()->get()
        ]);
    }

    public function create(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'string'
        ]);

        $list = new Lists();
        $list->user_id = $request->user()->id;
        $list->title = Str::limit($request->title, 255);
        $list->save();

        return to_route('lists.view', ['id' => $list->id]);
    }

    public function update(Request $request, String $list_id): RedirectResponse
    {
        $request->validate([
            $list_id => 'numeric|exists:lists,id',
            'title' => 'string'
        ]);
        $list = $request->user()->lists()->findOrFail($list_id);
        $list->title = Str::limit($request->title, 255);
        $list->save();
        return to_route('lists.view', ['id' => $list_id]);
    }
}
