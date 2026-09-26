<div class="py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Categorías') }}</h1>
            <p class="text-gray-600 dark:text-gray-400 text-sm">{{ __('Organiza tus productos por categorías') }}</p>
        </div>

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border dark:border-gray-700 p-5 mb-6">
            <form wire:submit="save" class="flex flex-col sm:flex-row gap-3">
                <div class="flex-1">
                    <input type="text" wire:model="name" placeholder="{{ __('Nombre de la categoría') }}"
                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        required>
                    @error('name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-2">
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                        {{ $editingId ? __('Actualizar') : __('Agregar') }}
                    </button>

                    @if ($editingId)
                        <button type="button" wire:click="cancelEdit"
                            class="px-4 py-2 rounded-lg border text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                            {{ __('Cancelar') }}
                        </button>
                    @endif
                </div>
            </form>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border dark:border-gray-700 overflow-hidden">
            <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($categories as $category)
                    <li class="px-5 py-4 flex items-center justify-between">
                        <div>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $category->name }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $category->products()->count() }} {{ __('productos') }}
                            </p>
                        </div>

                        <div class="flex gap-3 text-sm">
                            <button wire:click="edit({{ $category->id }})"
                                class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 font-medium">
                                {{ __('Editar') }}
                            </button>
                            <button wire:click="delete({{ $category->id }})" wire:confirm="¿Eliminar esta categoría?"
                                class="text-red-600 hover:text-red-800 dark:text-red-400 font-medium">
                                {{ __('Eliminar') }}
                            </button>
                        </div>
                    </li>
                @empty
                    <li class="px-5 py-10 text-center text-gray-500 dark:text-gray-400">
                        {{ __('No hay categorías todavía. Crea la primera arriba.') }}
                    </li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
