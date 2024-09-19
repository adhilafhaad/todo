<!DOCTYPE html>
@extends('layouts.app')

@section('title', 'Todo List')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Todo List</h1>
        <a href="{{ route('todos.create') }}" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Add Todo</a>
    </div>
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">Date</th>
                        <th class="py-3 px-6 text-left">Description</th>
                        <th class="py-3 px-6 text-left">Photos</th>
                        <th class="py-3 px-6 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    @foreach ($todos as $todo)
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                {{ $todo->date->format('Y-m-d H:i:s') }}
                            </td>
                            <td class="py-3 px-6 text-left">
                                {{ Str::limit($todo->description, 50) }}
                            </td>
                            <td class="py-3 px-6 text-left">
                                @foreach ($todo->images as $image)
                                    <img src="{{ asset('storage/' . $image->path) }}" alt="Todo image" class="w-10 h-10 rounded-full inline-block mr-2">
                                @endforeach
                            </td>
                            <td class="py-3 px-6 text-center">
                                <a href="{{ route('todos.show', $todo) }}" class="text-blue-500 hover:underline mr-2">View</a>
                                <a href="{{ route('todos.edit', $todo) }}" class="text-green-500 hover:underline mr-2">Edit</a>
                                <form action="{{ route('todos.destroy', $todo) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Are you sure you want to delete this todo?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endsection

