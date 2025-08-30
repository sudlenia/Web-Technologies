<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuItem;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    public function index()
    {
        $menuItems = MenuItem::where('user_id', Auth::id())
            ->where('is_visible', true)
            ->orderBy('order')
            ->get();

        return view('partials.menu', compact('menuItems'));
    }    

    public function edit()
    {
        $menuItems = MenuItem::where('user_id', Auth::id())
            ->orderBy('order')
            ->get();

        return view('menu.edit', compact('menuItems'));
    }

    public function update(Request $request)
    {
        $menuItems = $request->input('menu_items');

        foreach ($menuItems as $menuItemData) {
            $menuItem = MenuItem::where('id', $menuItemData['id'])
                ->where('user_id', Auth::id())
                ->first();
            
            if ($menuItem) {
                $menuItem->update([
                    'title' => $menuItemData['title'],
                    'url' => $menuItemData['url'],
                    'order' => $menuItemData['order'],
                    'is_visible' => isset($menuItemData['is_visible']) ? true : false,
                ]);
            }
        }

        return redirect()->route('menu.edit')->with('success', 'Меню обновлено!');
    }

}
