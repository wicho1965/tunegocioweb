<?php

namespace App\Livewire\Dashboard\Products;

use App\Helpers\StoreHelper;
use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

#[Layout('layouts.app')]
class Form extends Component
{
    use WithFileUploads;

    public ?int $productId = null;

    public string $name = '';
    public string $description = '';
    public string $price = '';
    public $category_id = null;
    public bool $is_available = true;

    public $image = null;          // archivo nuevo
    public ?string $currentImage = null; // ruta guardada

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
            $this->currentImage = $found->image;
        }
    }

    public function save()
    {
        $store = StoreHelper::current();

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
            'image' => 'nullable|image|max:2048', // máx 2MB
        ]);

        $imagePath = $this->currentImage;

        if ($this->image) {
            // borrar imagen anterior si existe
            if ($this->currentImage && Storage::disk('public')->exists($this->currentImage)) {
                Storage::disk('public')->delete($this->currentImage);
            }

            $imagePath = $this->image->store('products', 'public');
        }

        if ($this->productId) {
            $product = Product::where('store_id', $store->id)
                ->where('id', $this->productId)
                ->firstOrFail();

            $product->name = $validated['name'];
            $product->description = $validated['description'] ?? null;
            $product->price = $validated['price'];
            $product->category_id = $validated['category_id'] ?: null;
            $product->is_available = $validated['is_available'];
            $product->image = $imagePath;
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
                'image' => $imagePath,
            ]);

            session()->flash('success', __('Producto creado correctamente.'));
        }

        return $this->redirect(route('dashboard.products.index'), navigate: true);
    }

    public function removeImage()
    {
        if ($this->currentImage && Storage::disk('public')->exists($this->currentImage)) {
            Storage::disk('public')->delete($this->currentImage);
        }

        $this->currentImage = null;
        $this->image = null;

        if ($this->productId) {
            Product::where('id', $this->productId)->update(['image' => null]);
        }
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

