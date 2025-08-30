@extends('layouts.app')

@section('content')

@if(session('success'))
    <div class="bg-green-500 text-white p-4 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="container mx-auto px-4">
    <h1 class="text-3xl font-bold mb-4">Галерея</h1>
    <form action="{{ route('posts.index') }}" method="GET" class="mb-4 mt-2">
        <input type="text" name="search" class="w-full p-2 border border-gray-300 rounded-lg" placeholder="Найти" value="{{ request('search') }}">
    </form>
    @can('create', App\Models\Post::class)
    <a href="{{ route('posts.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">Добавить новую публикацию</a>
    @endcan
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mt-4">
        @forelse($posts as $post)
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <img src="{{ asset('uploads/thumbnails/' . $post->image) }}" class="w-full h-56 object-cover" alt="{{ $post->title }}">
                <div class="p-4">
                    <h5 class="text-xl font-semibold mb-2">{{ $post->title }}</h5>
                    <p class="text-gray-700 text-base mb-4 line-clamp-1">{{ $post->description }}</p>
                    <a href="{{ route('posts.show', $post) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">Посмотреть</a>
                </div>
            </div>
        @empty
            <p class="col-span-3 text-center text-gray-600">Нет публикаций</p>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $posts->links('pagination::tailwind') }}
    </div>
</div>
@endsection
