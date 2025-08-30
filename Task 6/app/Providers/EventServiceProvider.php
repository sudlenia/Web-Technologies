<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Карта событий и слушателей приложения.
     *
     * @var array
     */
    protected $listen = [
        \Illuminate\Auth\Events\Registered::class => [
            \App\Listeners\AddMenuItemsForNewUser::class,
        ],
    ];

    /**
     * Регистрация любых дополнительных событий для вашего приложения.
     */
    public function boot(): void
    {
        parent::boot();
    }
}
