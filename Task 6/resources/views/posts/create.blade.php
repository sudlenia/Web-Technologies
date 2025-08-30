@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-3xl font-bold mb-4">Создать новую публикацию</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label for="title" class="block text-sm font-semibold text-gray-700">Название</label>
            <input type="text" name="title" id="title" class="w-full p-3 border border-gray-300 rounded-lg" value="{{ old('title') }}" required>
        </div>

        <div class="mb-4">
            <label for="description" class="block text-sm font-semibold text-gray-700">Описание</label>
            <textarea name="description" id="description" class="w-full p-3 border border-gray-300 rounded-lg" rows="5" required>{{ old('description') }}</textarea>
        </div>

        <div class="mb-4">
            <label for="image" class="block text-sm font-semibold text-gray-700">Изображение</label>
            <input type="file" name="image" id="image" class="w-full p-3 border border-gray-300 rounded-lg" accept="image/*">
        </div>

        <button type="submit" class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-700">Создать публикацию</button>
    </form>
</div>
@endsection
