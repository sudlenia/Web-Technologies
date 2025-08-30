@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-3xl font-bold mb-4">{{ $post->title }}</h1>
    <img src="{{ asset('uploads/original/' . $post->image) }}" alt="{{ $post->title }}" class="w-full h-auto rounded-lg mb-4">
    <p class="text-gray-700 text-lg mb-4">{{ $post->description }}</p>
    <p class="text-sm text-gray-500">Автор: {{ $post->user->name }}</p>
    <div class="mt-6">
        <a href="{{ route('posts.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">Назад к публикациям</a>
        @can('delete', $post)
            <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-700">Удалить</button>
            </form>
        @endcan
    </div>
</div>
@endsection
