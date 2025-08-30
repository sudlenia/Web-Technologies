<?php

namespace App\Listeners;

use App\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\MenuItem;
use Illuminate\Auth\Events\Registered as AuthRegistered;

class AddMenuItemsForNewUser
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(AuthRegistered $event): void
    {
        $user = $event->user;

        $existingMenuItems = MenuItem::where('user_id', $user->id)->count();

        if ($existingMenuItems === 0) {
            $defaultMenuItems = [
                ['title' => 'Главная', 'url' => '/', 'order' => 1, 'is_visible' => true],
                ['title' => 'Галерея', 'url' => '/posts', 'order' => 2, 'is_visible' => true],
                ['title' => 'XML импорт', 'url' => '/import/xml', 'order' => 3, 'is_visible' => true],
            ];

            foreach ($defaultMenuItems as $item) {
                MenuItem::create(array_merge($item, ['user_id' => $user->id]));
            }
        }
        
    }
}
