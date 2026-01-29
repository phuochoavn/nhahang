<div class="max-w-md mx-auto relative bg-white min-h-screen shadow-2xl overflow-hidden" x-data="{ 
    activeCategory: @entangle('activeCategory'),
    showCart: @entangle('showCart'),
    scrollToCategory(id) {
        this.activeCategory = id;
        document.getElementById('category-' + id).scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
}">
    <!-- Top Header -->
    <div class="sticky top-0 z-50 bg-white/95 backdrop-blur-sm border-b border-gray-100 pb-2">
        <div class="flex items-center justify-between px-4 py-3">
            <div>
                <h1 class="font-bold text-lg text-gray-800">Suối Đá Hòn Giao</h1>
                <p class="text-xs text-gray-500">Bàn {{ $tableId }}</p>
            </div>
            <button class="p-2 rounded-full bg-orange-50 text-orange-600 relative">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <span class="absolute top-1 right-1 h-2 w-2 rounded-full bg-red-500"></span>
            </button>
        </div>

        <!-- Category Horizontal Scroll -->
        <div class="flex overflow-x-auto gap-4 px-4 pb-1 scrollbar-hide">
            @foreach($categories as $category)
            <button 
                @click="scrollToCategory({{ $category->id }})"
                class="flex flex-col items-center flex-shrink-0 transition-all duration-300 group"
                :class="activeCategory == {{ $category->id }} ? 'opacity-100 scale-105' : 'opacity-60 grayscale hover:grayscale-0'"
            >
                <div class="h-14 w-14 rounded-2xl overflow-hidden mb-1 shadow-sm border-2" 
                     :class="activeCategory == {{ $category->id }} ? 'border-orange-500' : 'border-transparent'">
                    <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}" class="h-full w-full object-cover">
                </div>
                <span class="text-xs font-medium whitespace-nowrap" 
                      :class="activeCategory == {{ $category->id }} ? 'text-orange-600 font-bold' : 'text-gray-600'">
                    {{ $category->name }}
                </span>
            </button>
            @endforeach
        </div>
    </div>

    <!-- Product Grid -->
    <div class="pb-24 pt-4 px-4 space-y-8">
        @foreach($categories as $category)
        <div id="category-{{ $category->id }}">
            <h2 class="font-bold text-gray-800 text-lg mb-3 pl-1 border-l-4 border-orange-500 leading-none">
                {{ $category->name }}
            </h2>
            
            <div class="space-y-4">
                @foreach($category->products as $product)
                <div class="flex bg-white rounded-xl p-3 border border-gray-50 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden">
                    <!-- Image -->
                    <div class="h-24 w-24 flex-shrink-0 rounded-lg overflow-hidden bg-gray-100">
                         @if($product->image)
                            <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                        @else
                            <div class="h-full w-full flex items-center justify-center text-gray-300 bg-gray-50">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Content -->
                    <div class="flex-1 ml-3 flex flex-col justify-between">
                        <div>
                            <h3 class="font-semibold text-gray-800 line-clamp-1">{{ $product->name }}</h3>
                            <p class="text-xs text-gray-500 line-clamp-2 mt-1">{{ Str::limit($product->description, 50) }}</p>
                        </div>
                        <div class="flex items-end justify-between mt-2">
                            <span class="font-bold text-orange-600">{{ number_format($product->price, 0, ',', '.') }}đ</span>
                            
                            <!-- Add Button -->
                            <button wire:click="addToCart({{ $product->id }})" class="bg-orange-100 text-orange-600 hover:bg-orange-500 hover:text-white p-2 rounded-full transition-colors active:scale-95 transform">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
                 @if($category->products->isEmpty())
                    <div class="text-center py-8 text-gray-400 text-sm italic">
                        Chưa có món nào trong danh mục này.
                    </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>

    <!-- Floating Cart Button -->
    <div class="fixed bottom-6 left-4 right-4 z-40" x-show="!showCart" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="translate-y-full" x-transition:enter-end="translate-y-0">
        @if($this->cartCount > 0)
        <button @click="showCart = true" class="w-full bg-orange-600 text-white rounded-full p-4 shadow-lg flex items-center justify-between hover:bg-orange-700 transition-colors">
            <div class="flex items-center">
                <div class="bg-white/20 rounded-full h-8 w-8 flex items-center justify-center mr-3 font-bold">
                    {{ $this->cartCount }}
                </div>
                <span class="font-bold">Xem giỏ hàng</span>
            </div>
            <span class="font-bold">{{ number_format($this->cartTotal, 0, ',', '.') }}đ</span>
        </button>
        @endif
    </div>

    <!-- Cart Drawer -->
    <div class="fixed inset-0 z-50 overflow-hidden" aria-labelledby="slide-over-title" role="dialog" aria-modal="true" x-show="showCart" x-cloak>
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="showCart = false"></div>
            <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                <div class="pointer-events-auto w-screen max-w-md">
                    <div class="flex h-full flex-col overflow-y-scroll bg-white shadow-xl">
                        <div class="flex-1 overflow-y-auto px-4 py-6 sm:px-6">
                            <div class="flex items-start justify-between">
                                <h2 class="text-lg font-medium text-gray-900" id="slide-over-title">Giỏ hàng</h2>
                                <div class="ml-3 flex h-7 items-center">
                                    <button type="button" class="-m-2 p-2 text-gray-400 hover:text-gray-500" @click="showCart = false">
                                        <span class="sr-only">Đóng</span>
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <div class="mt-8">
                                <div class="flow-root">
                                    <ul role="list" class="-my-6 divide-y divide-gray-200">
                                        @forelse($cart as $item)
                                        <li class="flex py-6">
                                            <div class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-md border border-gray-200">
                                                @if($item['image'])
                                                <img src="{{ Storage::url($item['image']) }}" class="h-full w-full object-cover object-center">
                                                @else
                                                <div class="h-full w-full bg-gray-100 flex items-center justify-center text-gray-400">
                                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                </div>
                                                @endif
                                            </div>

                                            <div class="ml-4 flex flex-1 flex-col">
                                                <div>
                                                    <div class="flex justify-between text-base font-medium text-gray-900">
                                                        <h3>{{ $item['name'] }}</h3>
                                                        <p class="ml-4">{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}đ</p>
                                                    </div>
                                                </div>
                                                <div class="flex flex-1 items-end justify-between text-sm">
                                                    <div class="flex items-center border rounded-lg">
                                                        <button wire:click="removeFromCart({{ $item['id'] }})" class="px-3 py-1 text-gray-600 hover:bg-gray-100">-</button>
                                                        <span class="px-2 font-medium">{{ $item['quantity'] }}</span>
                                                        <button wire:click="addToCart({{ $item['id'] }})" class="px-3 py-1 text-gray-600 hover:bg-gray-100">+</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        @empty
                                        <li class="py-6 text-center text-gray-500">Giỏ hàng trống</li>
                                        @endforelse
                                    </ul>
                                </div>
                            </div>
                        </div>

                        @if(!empty($cart))
                        <div class="border-t border-gray-200 px-4 py-6 sm:px-6">
                            <div class="flex justify-between text-base font-medium text-gray-900">
                                <p>Tổng cộng</p>
                                <p>{{ number_format($this->cartTotal, 0, ',', '.') }}đ</p>
                            </div>
                            <p class="mt-0.5 text-sm text-gray-500">Đã bao gồm thuế và phí phục vụ.</p>
                            <div class="mt-6">
                                <button wire:click="checkout" wire:loading.attr="disabled" class="w-full flex items-center justify-center rounded-md border border-transparent bg-orange-600 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-orange-700">
                                    <span wire:loading.remove wire:target="checkout">Đặt món ngay</span>
                                    <span wire:loading wire:target="checkout">Đang xử lý...</span>
                                </button>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <livewire:client.feedback-modal />
</div>

<style>
    /* Hide scrollbar for Chrome, Safari and Opera */
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
    /* Hide scrollbar for IE, Edge and Firefox */
    .scrollbar-hide {
        -ms-overflow-style: none;  /* IE and Edge */
        scrollbar-width: none;  /* Firefox */
    }
</style>
