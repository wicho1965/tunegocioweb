<?php

namespace App\Livewire\Store;

use App\Models\Store;
use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.store')]
class Catalog extends Component
{
    public Store $store;

    public ?int $selectedCategory = null;

    public string $search = '';

    public array $cart = [];

    public bool $showCart = false;

    public function mount(Store $store)
    {
        if (!$store->is_active) {
            abort(404);
        }

        $this->store = $store->load(['categories', 'products.category']);
    }

    public function filterByCategory($categoryId = null)
    {
        $this->selectedCategory = $categoryId;
    }

    public function addToCart($productId)
    {
        $product = Product::findOrFail($productId);

        if (isset($this->cart[$productId])) {
            $this->cart[$productId]['quantity']++;
        } else {
            $this->cart[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
            ];
        }
    }

    public function removeFromCart($productId)
    {
        unset($this->cart[$productId]);
    }

    public function increaseQuantity($productId)
    {
        if (isset($this->cart[$productId])) {
            $this->cart[$productId]['quantity']++;
        }
    }

    public function decreaseQuantity($productId)
    {
        if (isset($this->cart[$productId])) {
            if ($this->cart[$productId]['quantity'] > 1) {
                $this->cart[$productId]['quantity']--;
            } else {
                $this->removeFromCart($productId);
            }
        }
    }

    public function getCartTotalProperty()
    {
        return collect($this->cart)->sum(fn($item) => $item['price'] * $item['quantity']);
    }

    public function getCartCountProperty()
    {
        return collect($this->cart)->sum('quantity');
    }

    public function getWhatsappUrlProperty()
    {
        if (empty($this->cart) || empty($this->store->phone)) {
            return null;
        }

        $message = "¡Hola! Quiero hacer el siguiente pedido:\n\n";

        foreach ($this->cart as $item) {
            $subtotal = number_format($item['price'] * $item['quantity'], 2);
            $message .= "• {$item['name']} x{$item['quantity']} - \${$subtotal}\n";
        }

        $message .= "\n*Total: \$" . number_format($this->cartTotal, 2) . "*\n";
        $message .= "\nTienda: {$this->store->name}";

        $phone = preg_replace('/[^0-9]/', '', $this->store->phone);

        return "https://wa.me/{$phone}?text=" . urlencode($message);
    }

    public function getProductsProperty()
    {
        $query = $this->store->products()
            ->where('is_available', true)
            ->with('category');

        if ($this->selectedCategory) {
            $query->where('category_id', $this->selectedCategory);
        }

        if ($this->search) {
            $query->where('name', 'ilike', '%' . $this->search . '%');
        }

        return $query->orderBy('sort_order')->get();
    }

    public function render()
    {
        return view('livewire.store.catalog', [
            'products' => $this->products,
            'categories' => $this->store->categories()->where('is_active', true)->get(),
        ]);
    }
}
