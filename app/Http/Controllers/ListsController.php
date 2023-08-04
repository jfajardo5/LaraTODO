<?php

namespace App\Http\Controllers;

use App\Models\Lists;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

// TODO Write tests
class ListsController extends Controller
{

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

    public function update(Request $request, String $id): RedirectResponse
    {
        $request->validate([
            $id => 'numeric|exists:lists,id',
            'title' => 'string'
        ]);
        $list = $request->user()->lists()->findOrFail($id);
        $list->title = Str::limit($request->title, 255);
        $list->save();
        return to_route('lists.view', ['id' => $id]);
    }

    public function delete(Request $request, String $id): RedirectResponse
    {
        $request->validate([
            $id => 'numeric|exists:lists,id'
        ]);
        $request->user()->lists()->findOrFail($id)->delete();
        return to_route('dashboard');
    }
}
