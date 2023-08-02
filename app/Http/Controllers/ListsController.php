<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;

class ListsController extends Controller
{
    // TODO Build create()
    // TODO Build view()
    // TODO Build edit()
    // TODO Build delete()
    public function all(Request $request): Response
    {
        return Inertia::render('Dashboard', [
            'lists' => $request->user()->lists()
        ]);
    }

    public function view(Request $request): Response
    {
        return Inertia::render('List', []);
    }
}
