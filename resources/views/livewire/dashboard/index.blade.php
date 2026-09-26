<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Panel de control') }}</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">
                {{ __('Bienvenido al panel de') }} <strong>{{ $store->name }}</strong>
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border dark:border-gray-700">
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('Productos') }}</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $productsCount }}</p>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border dark:border-gray-700">
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('Categorías') }}</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $categoriesCount }}</p>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border dark:border-gray-700">
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('Ventas') }}</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $salesCount }}</p>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border dark:border-gray-700 p-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('Acciones rápidas') }}</h2>

            <div class="flex flex-wrap gap-3">
                <a href="{{ route('dashboard.products.create') }}"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                    + {{ __('Nuevo producto') }}
                </a>

                <a href="{{ route('dashboard.products.index') }}"
                    class="bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 px-4 py-2 rounded-lg text-sm font-medium">
                    {{ __('Ver productos') }}
                </a>

                <a href="{{ route('dashboard.categories.index') }}"
                    class="bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 px-4 py-2 rounded-lg text-sm font-medium">
                    {{ __('Categorías') }}
                </a>

                <a href="{{ route('dashboard.settings') }}"
                    class="bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 px-4 py-2 rounded-lg text-sm font-medium">
                    {{ __('Configuración de tienda') }}
                </a>

                <a href="{{ route('store.catalog', $store) }}" target="_blank"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                    {{ __('Ver mi catálogo público') }}
                </a>
            </div>
        </div>

        <div
            class="mt-6 bg-indigo-50 dark:bg-indigo-900/30 border border-indigo-100 dark:border-indigo-800 rounded-xl p-5">
            <p class="text-sm text-indigo-800 dark:text-indigo-300 font-medium mb-1">{{ __('Link de tu tienda') }}:</p>
            <a href="{{ route('store.catalog', $store) }}" target="_blank"
                class="text-indigo-600 dark:text-indigo-400 hover:underline break-all">
                {{ url('/' . $store->slug) }}
            </a>
        </div>
    </div>
</div>
