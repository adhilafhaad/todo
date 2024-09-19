@extends('layouts.app')

@section('title', 'Edit Todo')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Edit Todo</h1>
    <form action="{{ route('todos.update', $todo) }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="date">
                    Date
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="date" type="text" value="{{ $todo->date->format('Y-m-d H:i:s') }}" readonly>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                    Description
                </label>
                <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="description" name="description" rows="3" required>{{ $todo->description }}</textarea>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="photos">
                    Add More Photos
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="photos" type="file" name="photos[]" multiple>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">
                    Current Photos
                </label>
                <div class="flex flex-wrap">
                    @foreach ($todo->images as $image)
                        <div class="w-1/4 p-2">
                            <img src="{{ asset('storage/' . $image->path) }}" alt="Todo image" class="w-full h-auto">
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="flex items-center justify-between">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                    Update Todo
                </button>
            </div>
        </form>
        @endsection