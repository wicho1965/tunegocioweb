<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        @php
            $store = \App\Helpers\StoreHelper::current();
            $productCount = $store->products()->count();
        @endphp

        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Productos') }}</h1>
                <p class="text-gray-600 dark:text-gray-400 text-sm">{{ __('Administra los productos de tu tienda') }}</p>
            </div>

            @if ($store->canAddProduct())
                <a href="{{ route('dashboard.products.create') }}"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium text-center">
                    + {{ __('Nuevo producto') }}
                </a>
            @else
                <span
                    class="bg-gray-300 dark:bg-gray-600 text-gray-600 dark:text-gray-300 px-4 py-2 rounded-lg text-sm font-medium text-center cursor-not-allowed">
                    + {{ __('Nuevo producto') }}
                </span>
            @endif
        </div>

        {{-- Aviso plan Gratis --}}
        @if ($store->isFree())
            <div
                class="mb-4 p-3 rounded-lg text-sm border
        {{ $productCount >= 20
            ? 'bg-red-100 border-red-300 text-red-800 dark:bg-red-900/40 dark:border-red-700 dark:text-red-200'
            : 'bg-amber-100 border-amber-300 text-amber-900 dark:bg-amber-900/40 dark:border-amber-600 dark:text-amber-100' }}">
                <span class="font-semibold">{{ __('Plan Gratis') }}:</span>
                {{ $productCount }} / 20 {{ __('productos') }}
                @if ($productCount >= 20)
                    — {{ __('Límite alcanzado. Pasá al plan Pro para agregar más.') }}
                @endif
            </div>
        @endif

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 p-4 bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        <div class="mb-4">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="{{ __('Buscar producto...') }}"
                class="w-full max-w-md rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border dark:border-gray-700 overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                            {{ __('Producto') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                            {{ __('Categoría') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                            {{ __('Precio') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                            {{ __('Estado') }}</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                            {{ __('Acciones') }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($products as $product)
                        <tr>
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900 dark:text-white">{{ $product->name }}</div>
                                @if ($product->description)
                                    <div class="text-sm text-gray-500 dark:text-gray-400 truncate max-w-xs">
                                        {{ $product->description }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
                                {{ $product->category?->name ?? __('Sin categoría') }}
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">
                                ${{ number_format($product->price, 2) }}
                            </td>
                            <td class="px-6 py-4">
                                @if ($product->is_available)
                                    <span
                                        class="px-2 py-1 text-xs rounded-full bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">{{ __('Disponible') }}</span>
                                @else
                                    <span
                                        class="px-2 py-1 text-xs rounded-full bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200">{{ __('No disponible') }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right text-sm space-x-2">
                                <a href="{{ route('dashboard.products.edit', $product) }}"
                                    class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 font-medium">{{ __('Editar') }}</a>
                                <button wire:click="delete({{ $product->id }})"
                                    wire:confirm="¿Eliminar este producto?"
                                    class="text-red-600 dark:text-red-400 hover:text-red-800 font-medium">
                                    {{ __('Eliminar') }}
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">
                                {{ __('No hay productos todavía.') }}
                                @if ($store->canAddProduct())
                                    <a href="{{ route('dashboard.products.create') }}"
                                        class="text-indigo-600 dark:text-indigo-400 hover:underline ml-1">
                                        {{ __('Crear el primero') }}
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $products->links() }}
        </div>
    </div>
</div>
