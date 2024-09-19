@extends('layouts.app')

@section('title', 'View Todo')

@section('content')
    <h1 class="text-3xl font-bold mb-6">View Todo</h1>
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">
                    Date
                </label>
                <p class="text-gray-700">{{ $todo->date->format('Y-m-d H:i:s') }}</p>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">
                    Description
                </label>
                <p class="text-gray-700">{{ $todo->description }}</p>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">
                    Photos
                </label>
                <div class="flex flex-wrap">
                    @foreach ($todo->images as $image)
                        <div class="w-1/2 p-2">
                            <img src="{{ asset('storage/' . $image->path) }}" alt="Todo image" class="w-full h-auto">
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="flex items-center justify-between">
                <a href="{{ route('todos.edit', $todo) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Edit Todo
                </a>
                <a href="{{ route('todos.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Back to List
                </a>
            </div>
        </div>
    </div>
    @endsection
