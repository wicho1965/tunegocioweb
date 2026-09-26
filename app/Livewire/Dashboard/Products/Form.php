<?php

namespace App\Livewire\Dashboard\Products;

use App\Helpers\StoreHelper;
use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Str;

#[Layout('layouts.app')]
class Form extends Component
{
    public ?int $productId = null;

    public string $name = '';
    public string $description = '';
    public string $price = '';
    public $category_id = null;
    public bool $is_available = true;

    public function mount($product = null)
    {
        if ($product) {
            $store = StoreHelper::current();
            $productId = is_object($product) ? $product->id : $product;

            $found = Product::where('store_id', $store->id)->find($productId);

            if (!$found) {
                abort(404);
            }

            $this->productId = $found->id;
            $this->name = $found->name;
            $this->description = $found->description ?? '';
            $this->price = (string) $found->price;
            $this->category_id = $found->category_id;
            $this->is_available = $found->is_available;
        }
    }

    public function save()
    {
        $store = StoreHelper::current();

        // Límite plan Gratis: solo al crear
        if (!$this->productId && !$store->canAddProduct()) {
            session()->flash(
                'error',
                __('Has alcanzado el límite de 20 productos del plan Gratis. Pasá al plan Pro para agregar más.')
            );

            return $this->redirect(route('dashboard.products.index'), navigate: true);
        }

        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'is_available' => 'boolean',
        ]);

        if ($this->productId) {
            $product = Product::where('store_id', $store->id)
                ->where('id', $this->productId)
                ->firstOrFail();

            $product->name = $validated['name'];
            $product->description = $validated['description'] ?? null;
            $product->price = $validated['price'];
            $product->category_id = $validated['category_id'] ?: null;
            $product->is_available = $validated['is_available'];
            $product->save();

            session()->flash('success', __('Producto actualizado correctamente.'));
        } else {
            Product::create([
                'store_id' => $store->id,
                'name' => $validated['name'],
                'slug' => Str::slug($validated['name']) . '-' . uniqid(),
                'description' => $validated['description'] ?? null,
                'price' => $validated['price'],
                'category_id' => $validated['category_id'] ?: null,
                'is_available' => $validated['is_available'],
            ]);

            session()->flash('success', __('Producto creado correctamente.'));
        }

        return $this->redirect(route('dashboard.products.index'), navigate: true);
    }

    public function render()
    {
        $store = StoreHelper::current();

        return view('livewire.dashboard.products.form', [
            'categories' => $store->categories()->orderBy('name')->get(),
            'isEditing' => !is_null($this->productId),
        ]);
    }
}
