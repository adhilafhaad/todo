<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Models\TodoImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


use Illuminate\Support\Facades\Storage;

class TodoController extends Controller
{
    public function index()
    {
        $todos = auth()->user()->todos()->with('images')->latest()->get();
        return view('todos.index', compact('todos'));
    }

    public function create()
    {
        return view('todos.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'description' => 'required|max:1000',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:10240'
        ]);

        try {
            $todo = new Todo([
                'user_id' => Auth::id(),
                'date' => now(),
                'description' => $validatedData['description']
            ]);

            $todo->save();

            Log::info('Todo saved successfully', ['todo_id' => $todo->id]);

            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $photo) {
                    $path = $photo->store('todo_images', 'public');
                    $todo->images()->create(['path' => $path]);
                    Log::info('Photo saved for todo', ['todo_id' => $todo->id, 'photo_path' => $path]);
                }
            }

            return redirect()->route('todos.index')->with('success', 'Todo created successfully.');
        } catch (\Exception $e) {
            Log::error('Error saving todo', ['error' => $e->getMessage()]);
            return back()->withInput()->withErrors(['error' => 'An error occurred while saving the todo. Please try again.']);
        }
    }

    public function show(Todo $todo)
    {
        return view('todos.show', compact('todo'));
    }

    public function edit(Todo $todo)
    {
        return view('todos.edit', compact('todo'));
    }

    public function update(Request $request, Todo $todo)
    {
        $validatedData = $request->validate([
            'description' => 'required',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $todo->update([
            'description' => $validatedData['description']
        ]);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('todo_images', 'public');
                $todo->images()->create(['path' => $path]);
            }
        }

        return redirect()->route('todos.index')->with('success', 'Todo updated successfully.');
    }

    public function destroy(Todo $todo)
    {
        foreach ($todo->images as $image) {
            Storage::disk('public')->delete($image->path);
            $image->delete();
        }

        $todo->delete();

        return redirect()->route('todos.index')->with('success', 'Todo deleted successfully.');
    }
}