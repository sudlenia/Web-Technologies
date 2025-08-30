<nav class="flex flex-row bg-white px-12 py-6">
    <ul class="flex flex-row gap-20">
        @foreach($menuItems as $item)
            @if($item->is_visible && (!Auth::check() && $item->user_id === 0) || (Auth::id() === $item->user_id))
                <li>
                    <a class="text-blue-500" href="{{ url($item->url) }}">{{ $item->title }}</a>
                </li>
            @endif
        @endforeach

        @auth
            <li>
                <a class="text-blue-500" href="{{ route('menu.edit') }}">Редактировать меню</a>
            </li>
        @endauth
    </ul>
</nav>
