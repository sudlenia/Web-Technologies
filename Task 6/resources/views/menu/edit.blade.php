@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-semibold mb-6">Редактирование меню</h1>
    <form action="{{ route('menu.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="min-w-full table-auto">
                <thead>
                    <tr class="border-b bg-gray-100">
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Название</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Порядок</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Показ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($menuItems as $item)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-3">
                                <input type="text" name="menu_items[{{ $loop->index }}][title]" value="{{ $item->title }}" class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </td>
                            <td class="px-4 py-3 hidden">
                                <input type="text" name="menu_items[{{ $loop->index }}][url]" value="{{ $item->url }}" class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </td>
                            <td class="px-4 py-3">
                                <input type="number" name="menu_items[{{ $loop->index }}][order]" value="{{ $item->order }}" class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </td>
                            <td class="px-4 py-3">
                                <input type="checkbox" name="menu_items[{{ $loop->index }}][is_visible]" value="1" {{ $item->is_visible ? 'checked' : '' }} class="rounded border-gray-300 focus:ring-2 focus:ring-blue-500">
                            </td>
                            <input type="hidden" name="menu_items[{{ $loop->index }}][id]" value="{{ $item->id }}">
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6 text-right">
            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg shadow hover:bg-blue-600 transition-colors duration-300">Сохранить</button>
        </div>
    </form>
</div>
@endsection
