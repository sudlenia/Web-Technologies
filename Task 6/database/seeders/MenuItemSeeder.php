<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MenuItem;

class MenuItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MenuItem::create(['title' => 'Главная', 'url' => '/home', 'order' => 1, 'is_visible' => true, 'user_id' => 2]);
        MenuItem::create(['title' => 'Галерея', 'url' => '/posts', 'order' => 2, 'is_visible' => true, 'user_id' => 2]);
        MenuItem::create(['title' => 'XML импорт', 'url' => '/import/xml', 'order' => 3, 'is_visible' => true, 'user_id' => 2]);
    }
}
