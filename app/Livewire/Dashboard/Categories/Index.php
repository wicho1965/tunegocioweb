<?php

namespace App\Livewire\Dashboard\Categories;

use App\Helpers\StoreHelper;
use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Categorías')]
class Index extends Component
{
    public string $name = '';

    public ?int $editingId = null;

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:100',
        ]);

        $store = StoreHelper::current();

        if ($this->editingId) {
            $category = Category::where('store_id', $store->id)->findOrFail($this->editingId);
            $category->update([
                'name' => $this->name,
                'slug' => Str::slug($this->name),
            ]);
            session()->flash('success', 'Categoría actualizada.');
        } else {
            Category::create([
                'store_id' => $store->id,
                'name' => $this->name,
                'slug' => Str::slug($this->name),
                'sort_order' => $store->categories()->count() + 1,
                'is_active' => true,
            ]);
            session()->flash('success', 'Categoría creada.');
        }

        $this->reset(['name', 'editingId']);
    }

    public function edit($id)
    {
        $store = StoreHelper::current();
        $category = Category::where('store_id', $store->id)->findOrFail($id);

        $this->editingId = $category->id;
        $this->name = $category->name;
    }

    public function cancelEdit()
    {
        $this->reset(['name', 'editingId']);
    }

    public function delete($id)
    {
        $store = StoreHelper::current();
        Category::where('store_id', $store->id)->where('id', $id)->delete();
        session()->flash('success', 'Categoría eliminada.');
    }

    public function render()
    {
        $store = StoreHelper::current();

        return view('livewire.dashboard.categories.index', [
            'categories' => $store->categories()->orderBy('sort_order')->get(),
        ]);
    }
}
