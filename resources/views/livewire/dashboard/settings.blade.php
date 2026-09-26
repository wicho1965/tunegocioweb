<div class="py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Configuración de tienda') }}</h1>
            <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">{{ __('Datos que verán tus clientes') }}</p>
        </div>

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @php
            $store = \App\Helpers\StoreHelper::current();
            $storeUrl = url('/' . $store->slug);
            $qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&margin=10&data=' . urlencode($storeUrl);
        @endphp

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border dark:border-gray-700 p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">{{ __('Código QR de tu tienda') }}</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                {{ __('Tus clientes pueden escanear este código para abrir tu catálogo') }}
            </p>

            <div class="flex flex-col sm:flex-row items-center gap-6">
                <div class="bg-white p-4 rounded-xl border dark:border-gray-600 shadow-sm">
                    <img src="{{ $qrUrl }}" alt="QR" width="180" height="180" class="rounded">
                </div>

                <div class="flex-1 space-y-3">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">{{ __('Link de tu tienda') }}:</p>
                        <a href="{{ $storeUrl }}" target="_blank"
                            class="text-indigo-600 dark:text-indigo-400 hover:underline break-all text-sm">
                            {{ $storeUrl }}
                        </a>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        <a href="{{ $storeUrl }}" target="_blank"
                            class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                            {{ __('Ver catálogo público') }}
                        </a>

                        <a href="{{ $qrUrl }}" target="_blank"
                            class="inline-flex items-center gap-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 px-4 py-2 rounded-lg text-sm font-medium">
                            {{ __('Descargar QR') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <form wire:submit="save"
            class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border dark:border-gray-700 p-6 space-y-6">
            <div>
                <label
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Nombre de la tienda') }}</label>
                <input type="text" wire:model="name"
                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    required>
            </div>

            <div>
                <label
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Descripción') }}</label>
                <textarea wire:model="description" rows="3"
                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
            </div>

            <div>
                <label
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Teléfono / WhatsApp') }}</label>
                <input type="text" wire:model="phone" placeholder="5491112345678"
                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    {{ __('Incluye código de país (ej: 54911...)') }}</p>
            </div>

            <div>
                <label
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Dirección') }}</label>
                <input type="text" wire:model="address"
                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <div class="flex justify-end pt-4 border-t dark:border-gray-700">
                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                    {{ __('Guardar cambios') }}
                </button>
            </div>
        </form>
    </div>
</div>
