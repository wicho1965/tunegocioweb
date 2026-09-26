<div x-data="{
    dark: localStorage.getItem('catalog-theme') === 'dark',
    init() {
        if (this.dark) document.documentElement.classList.add('dark');
        this.$watch('dark', value => {
            if (value) {
                document.documentElement.classList.add('dark');
                localStorage.setItem('catalog-theme', 'dark');
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('catalog-theme', 'light');
            }
        })
    }
}" class="min-h-screen bg-gray-50 dark:bg-gray-900 pb-28">
    {{-- Header --}}
    <header class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 sticky top-0 z-40">
        <div class="max-w-5xl mx-auto px-4 py-4 sm:px-6">
            <div class="flex items-center gap-3 sm:gap-4">
                <div
                    class="h-12 w-12 sm:h-14 sm:w-14 rounded-2xl bg-indigo-600 flex items-center justify-center text-white text-lg sm:text-xl font-bold shadow-sm">
                    {{ strtoupper(substr($store->name, 0, 1)) }}
                </div>

                <div class="min-w-0 flex-1">
                    <h1 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white truncate">{{ $store->name }}
                    </h1>
                    @if ($store->description)
                        <p class="text-sm text-gray-500 dark:text-gray-400 truncate">{{ $store->description }}</p>
                    @endif
                </div>

                {{-- Language Switcher --}}
                <div class="flex items-center gap-1">
                    <a href="{{ route('locale.switch', 'es') }}"
                        class="px-2 py-1 rounded text-xs font-bold transition
                       {{ app()->getLocale() === 'es' ? 'bg-indigo-600 text-white' : 'text-gray-500 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        ES
                    </a>
                    <a href="{{ route('locale.switch', 'en') }}"
                        class="px-2 py-1 rounded text-xs font-bold transition
                       {{ app()->getLocale() === 'en' ? 'bg-indigo-600 text-white' : 'text-gray-500 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        EN
                    </a>
                </div>

                {{-- Dark Mode Toggle --}}
                <button @click="dark = !dark"
                    class="p-2.5 rounded-xl text-gray-500 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition"
                    title="Theme">
                    <svg x-show="dark" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <svg x-show="!dark" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                </button>
            </div>
        </div>
    </header>

    <main class="max-w-5xl mx-auto px-4 py-6 sm:px-6">
        {{-- Search --}}
        <div class="mb-5">
            <div class="relative">
                <input type="text" wire:model.live.debounce.300ms="search"
                    placeholder="{{ __('Buscar productos...') }}"
                    class="w-full rounded-2xl border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800 pl-11 pr-4 py-3 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-gray-900 dark:text-white">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-4.35-4.35M17 11A6 6 0 1111 5a6 6 0 016 6z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Categories --}}
        <div class="flex gap-2 overflow-x-auto pb-2 mb-6">
            <button wire:click="filterByCategory(null)"
                class="whitespace-nowrap px-4 py-2 rounded-full text-sm font-medium transition
                    {{ is_null($selectedCategory) ? 'bg-indigo-600 text-white shadow' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                {{ __('Todos') }}
            </button>

            @foreach ($categories as $category)
                <button wire:click="filterByCategory({{ $category->id }})"
                    class="whitespace-nowrap px-4 py-2 rounded-full text-sm font-medium transition
                        {{ $selectedCategory === $category->id ? 'bg-indigo-600 text-white shadow' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                    {{ $category->name }}
                </button>
            @endforeach
        </div>

        {{-- Products --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($products as $product)
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden hover:shadow-md transition">
                    <div
                        class="aspect-[4/3] bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-600 flex items-center justify-center">
                        <span class="text-4xl font-bold text-gray-300 dark:text-gray-500">
                            {{ strtoupper(substr($product->name, 0, 1)) }}
                        </span>
                    </div>

                    <div class="p-4">
                        <div class="flex items-start justify-between gap-2">
                            <div class="min-w-0">
                                <h3 class="font-semibold text-gray-900 dark:text-white leading-tight">
                                    {{ $product->name }}</h3>
                                @if ($product->category)
                                    <p class="text-xs text-indigo-600 dark:text-indigo-400 mt-0.5">
                                        {{ $product->category->name }}</p>
                                @endif
                            </div>
                            <div class="text-right shrink-0">
                                <p class="text-lg font-bold text-gray-900 dark:text-white">
                                    ${{ number_format($product->price, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>

                        @if ($product->description)
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2 line-clamp-2">
                                {{ $product->description }}</p>
                        @endif

                        <button wire:click="addToCart({{ $product->id }})"
                            class="mt-4 w-full bg-indigo-600 hover:bg-indigo-700 active:scale-[0.98] text-white text-sm font-semibold py-2.5 rounded-xl transition">
                            {{ __('Agregar al pedido') }}
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-16">
                    <p class="text-gray-400 dark:text-gray-500 text-lg">{{ __('No se encontraron productos') }}</p>
                </div>
            @endforelse
        </div>
    </main>

    {{-- Floating cart button --}}
    @if ($this->cartCount > 0)
        <div class="fixed bottom-5 inset-x-0 z-50 px-4">
            <div class="max-w-5xl mx-auto">
                <button wire:click="$toggle('showCart')"
                    class="w-full sm:w-auto sm:ml-auto bg-gray-900 dark:bg-indigo-600 hover:bg-black dark:hover:bg-indigo-700 text-white rounded-2xl shadow-xl px-5 py-4 flex items-center justify-between gap-4 transition">
                    <div class="flex items-center gap-3">
                        <span
                            class="bg-indigo-500 dark:bg-white/20 text-white text-xs font-bold rounded-full h-6 w-6 flex items-center justify-center">
                            {{ $this->cartCount }}
                        </span>
                        <span class="font-semibold">{{ __('Ver pedido') }}</span>
                    </div>
                    <span class="font-bold">
                        ${{ number_format($this->cartTotal, 0, ',', '.') }}
                    </span>
                </button>
            </div>
        </div>
    @endif

    {{-- Cart modal --}}
    @if ($showCart)
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-end sm:items-center justify-center min-h-screen px-4 pb-4 pt-4 text-center sm:p-0">
                <div class="fixed inset-0 bg-black/50 transition-opacity" wire:click="$set('showCart', false)"></div>

                <div
                    class="relative bg-white dark:bg-gray-800 rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:max-w-md w-full">
                    <div class="px-5 pt-5 pb-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ __('Tu pedido') }}</h3>
                            <button wire:click="$set('showCart', false)"
                                class="h-8 w-8 rounded-full bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 flex items-center justify-center text-gray-500 dark:text-gray-300">
                                ✕
                            </button>
                        </div>

                        <div class="space-y-3 max-h-72 overflow-y-auto">
                            @foreach ($cart as $item)
                                <div
                                    class="flex items-center justify-between gap-3 py-2 border-b border-gray-100 dark:border-gray-700 last:border-0">
                                    <div class="min-w-0">
                                        <p class="font-medium text-gray-900 dark:text-white truncate">
                                            {{ $item['name'] }}</p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            ${{ number_format($item['price'], 0, ',', '.') }} c/u
                                        </p>
                                    </div>

                                    <div class="flex items-center gap-2 shrink-0">
                                        <button wire:click="decreaseQuantity({{ $item['id'] }})"
                                            class="h-8 w-8 rounded-full bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 font-bold text-gray-700 dark:text-gray-200">−</button>
                                        <span
                                            class="w-6 text-center font-semibold text-gray-900 dark:text-white">{{ $item['quantity'] }}</span>
                                        <button wire:click="increaseQuantity({{ $item['id'] }})"
                                            class="h-8 w-8 rounded-full bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 font-bold text-gray-700 dark:text-gray-200">+</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-5 pt-4 border-t border-gray-100 dark:border-gray-700">
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-gray-600 dark:text-gray-300">{{ __('Total') }}</span>
                                <span class="text-xl font-bold text-gray-900 dark:text-white">
                                    ${{ number_format($this->cartTotal, 0, ',', '.') }}
                                </span>
                            </div>

                            @if ($this->whatsappUrl)
                                <a href="{{ $this->whatsappUrl }}" target="_blank"
                                    class="w-full bg-[#25D366] hover:bg-[#1ebe57] text-white font-semibold py-3.5 px-4 rounded-2xl flex items-center justify-center gap-2 transition">
                                    {{ __('Enviar pedido por WhatsApp') }}
                                </a>
                            @else
                                <p class="text-sm text-red-500 text-center">
                                    {{ __('Esta tienda no tiene WhatsApp configurado.') }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
