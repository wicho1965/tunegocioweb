<?php

namespace App\Livewire\Dashboard\Products;

use App\Helpers\StoreHelper;
use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

#[Layout('layouts.app')]
#[Title('Productos')]
class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public function delete($productId)
    {
        $store = StoreHelper::current();

        $product = Product::where('store_id', $store->id)->findOrFail($productId);
        $product->delete();

        session()->flash('success', __('Producto eliminado correctamente.'));
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $store = StoreHelper::current();

        $products = $store->products()
            ->with('category')
            ->when($this->search, function ($query) {
                $query->where('name', 'ilike', '%' . $this->search . '%');
            })
            ->orderBy('sort_order')
            ->paginate(10);

        return view('livewire.dashboard.products.index', [
            'products' => $products,
            'store' => $store,
        ]);
    }
}
