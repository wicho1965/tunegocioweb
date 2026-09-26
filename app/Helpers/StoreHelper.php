<?php

namespace App\Helpers;

use App\Models\Store;
use Illuminate\Support\Str;

class StoreHelper
{
    public static function current(): Store
    {
        $user = auth()->user();

        $store = $user->stores()->first();

        if (!$store) {
            $store = Store::create([
                'user_id' => $user->id,
                'name' => $user->name . ' Store',
                'slug' => Str::slug($user->name) . '-' . $user->id,
                'description' => 'Mi tienda digital',
                'phone' => null,
                'is_active' => true,
            ]);
        }

        return $store;
    }
}
