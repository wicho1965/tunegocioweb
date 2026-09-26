<div class="py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">
                {{ $isEditing ? 'Editar producto' : 'Nuevo producto' }}
            </h1>
        </div>

        <form wire:submit="save" class="bg-white rounded-xl shadow-sm border p-6 space-y-6">

            {{-- Nombre --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre del producto</label>
                <input type="text" wire:model="name"
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    required>
                @error('name')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Descripción --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                <textarea wire:model="description" rows="3"
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
            </div>

            {{-- Precio y Categoría --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Precio</label>
                    <input type="number" step="0.01" wire:model="price"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        required>
                    @error('price')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Categoría</label>
                    <select wire:model="category_id"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Sin categoría</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Disponible --}}
            <div class="flex items-center gap-2">
                <input type="checkbox" wire:model="is_available" id="is_available"
                    class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                <label for="is_available" class="text-sm text-gray-700">Producto disponible</label>
            </div>

            {{-- Botones --}}
            <div class="flex justify-end gap-3 pt-4 border-t">
                <a href="{{ route('dashboard.products.index') }}"
                    class="px-4 py-2 rounded-lg border text-gray-700 hover:bg-gray-50 text-sm font-medium">
                    Cancelar
                </a>
                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                    {{ $isEditing ? 'Actualizar producto' : 'Crear producto' }}
                </button>
            </div>
        </form>
    </div>
</div>
