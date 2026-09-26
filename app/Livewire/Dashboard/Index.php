<?php

namespace App\Livewire\Dashboard;

use App\Helpers\StoreHelper;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Dashboard')]
class Index extends Component
{
    public function render()
    {
        $store = StoreHelper::current();

        return view('livewire.dashboard.index', [
            'store' => $store,
            'productsCount' => $store->products()->count(),
            'categoriesCount' => $store->categories()->count(),
            'salesCount' => $store->sales()->count(),
        ]);
    }
}
