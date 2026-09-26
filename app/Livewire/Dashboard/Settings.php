<?php

namespace App\Livewire\Dashboard;

use App\Helpers\StoreHelper;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Str;

#[Layout('layouts.app')]
#[Title('Configuración')]
class Settings extends Component
{
    public string $name = '';
    public string $description = '';
    public string $phone = '';
    public string $address = '';

    public function mount()
    {
        $store = StoreHelper::current();

        $this->name = $store->name;
        $this->description = $store->description ?? '';
        $this->phone = $store->phone ?? '';
        $this->address = $store->address ?? '';
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string|max:255',
        ]);

        $store = StoreHelper::current();

        $store->update([
            'name' => $this->name,
            'slug' => Str::slug($this->name) . '-' . $store->id,
            'description' => $this->description,
            'phone' => $this->phone,
            'address' => $this->address,
        ]);

        session()->flash('success', 'Tienda actualizada correctamente.');
    }

    public function render()
    {
        return view('livewire.dashboard.settings');
    }
}
