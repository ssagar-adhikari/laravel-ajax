<?php

namespace App\Http\Controllers;

use App\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index()
    {
        return view('welcome', ['todos' => Todo::orderBy('id', 'DESC')->get()]);
    }

    public function edit(Todo $todo)
    {
        return response()->json($todo);
    }

    public function store(Request $request)
    {
        $todo = Todo::updateOrCreate(
            ['id' => $request->id], //condition for update
            ['name' => $request->name,] //data to store
        );
        return response()->json($todo);
    }

    public function delete(Todo $todo)
    {
        $todo->delete();
        return response()->json('success');
    }
}
