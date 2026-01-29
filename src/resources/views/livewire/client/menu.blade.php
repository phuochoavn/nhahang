<div
    class="min-h-screen bg-gray-50"
    x-data="{ showToast: false, toastMsg: '' }"
    @show-toast.window="toastMsg = $wire.toast; showToast = true; setTimeout(() => showToast = false, 2000)"
>
    {{-- ==================== TOAST NOTIFICATION ==================== --}}
    <div
        x-show="showToast"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-4"
        x-cloak
        class="fixed top-20 left-1/2 -translate-x-1/2 z-[100] bg-green-600 text-white px-5 py-2.5 rounded-xl shadow-lg text-sm font-bold flex items-center space-x-2"
    >
        <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
        <span x-text="toastMsg"></span>
    </div>

    {{-- ==================== HERO BANNER ==================== --}}
    <div class="relative h-48 w-full bg-gray-900 overflow-hidden mt-16">
        <div class="absolute inset-0 bg-gradient-to-br from-green-900 via-green-800 to-amber-900">
            <div class="absolute inset-0 opacity-20" style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%23ffffff&quot; fill-opacity=&quot;0.15&quot;%3E%3Cpath d=&quot;M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        </div>
        <div class="relative h-full flex flex-col justify-end px-5 pb-5">
            <h2 class="text-white font-bold text-2xl leading-tight drop-shadow-lg mb-1">
                Ẩm thực <span class="text-green-300 italic">Suối Đá</span>
            </h2>
            <p class="text-gray-200 text-sm font-medium drop-shadow-md opacity-90">
                Thưởng thức hương vị Tây Nguyên giữa đại ngàn
            </p>
        </div>
    </div>

    {{-- ==================== STICKY CATEGORY NAV ==================== --}}
    <div
        class="sticky top-16 z-40 bg-[#fdfbf7] shadow-sm border-b border-[#78350f]/10"
        x-data="{ active: @entangle('activeCategoryId') }"
    >
        <div class="flex overflow-x-auto py-3 px-4 space-x-2 no-scrollbar scroll-smooth">
            @foreach($categories as $category)
                <button
                    @click="document.getElementById('category-{{ $category->id }}').scrollIntoView({behavior: 'smooth', block: 'start'})"
                    class="whitespace-nowrap px-5 py-2.5 rounded-full text-sm font-bold transition-all duration-300 transform active:scale-95
                    {{ $activeCategoryId === $category->id
                        ? 'bg-[#78350f] text-white shadow-lg shadow-[#78350f]/30 ring-2 ring-[#78350f] ring-offset-2 ring-offset-[#fdfbf7]'
                        : 'bg-white text-gray-500 border border-gray-200 hover:bg-orange-50 hover:text-[#78350f] hover:border-orange-200' }}"
                >
                    {{ $category->name }}
                </button>
            @endforeach
        </div>
    </div>

    {{-- ==================== PRODUCT GRID ==================== --}}
    <div class="p-3 pb-36 space-y-6 bg-gray-50/50">
        @foreach($categories as $category)
            @if($category->products->isNotEmpty())
                <div id="category-{{ $category->id }}" class="scroll-mt-32">
                    {{-- Section Header --}}
                    <div class="flex items-center space-x-3 mb-4 px-2 pt-2">
                        <div class="w-1.5 h-6 bg-gradient-to-b from-[#15803d] to-[#78350f] rounded-full"></div>
                        <h2 class="text-lg font-black text-gray-800 tracking-wide uppercase">{{ $category->name }}</h2>
                    </div>

                    {{-- Grid --}}
                    <div class="grid grid-cols-2 gap-3">
                        @foreach($category->products as $product)
                            <div
                                class="group bg-white rounded-3xl p-2.5 shadow-[0_4px_20px_-2px_rgba(0,0,0,0.05)] border border-gray-100 flex flex-col h-full relative overflow-hidden active:scale-[0.98] transition-all duration-200"
                                wire:key="product-{{ $product->id }}"
                            >
                                {{-- Image Container --}}
                                <div class="relative aspect-square rounded-2xl overflow-hidden bg-gray-100 shadow-inner">
                                    @if($product->image && Storage::disk('public')->exists($product->image))
                                        <img
                                            src="{{ asset('storage/' . $product->image) }}"
                                            alt="{{ $product->name }}"
                                            loading="lazy"
                                            class="w-full h-full object-cover transform transition-transform duration-700 group-hover:scale-110"
                                        >
                                    @else
                                        {{-- Inline SVG Food Placeholder --}}
                                        <div class="w-full h-full flex items-center justify-center bg-green-50">
                                            <svg class="w-16 h-16 text-green-300" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="32" cy="38" rx="22" ry="8" fill="currentColor" opacity="0.3"/>
                                                <ellipse cx="32" cy="36" rx="22" ry="6" stroke="currentColor" stroke-width="2" fill="none"/>
                                                <path d="M10 36c0-12 8-22 22-22s22 10 22 22" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round"/>
                                                <path d="M32 14v-4M32 10c0-2 1-4 3-4" stroke="currentColor" stroke-width="2" stroke-linecap="round" fill="none"/>
                                                <path d="M10 36v4c0 3.3 9.8 6 22 6s22-2.7 22-6v-4" stroke="currentColor" stroke-width="2" fill="none"/>
                                            </svg>
                                        </div>
                                    @endif

                                    {{-- Add Button --}}
                                    <button
                                        wire:click="addToCart({{ $product->id }})"
                                        wire:loading.attr="disabled"
                                        wire:target="addToCart({{ $product->id }})"
                                        class="absolute bottom-2 right-2 w-9 h-9 rounded-full bg-[#15803d] text-white flex items-center justify-center shadow-lg active:scale-90 transition-all duration-200"
                                    >
                                        <span wire:loading.remove wire:target="addToCart({{ $product->id }})">
                                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"/>
                                            </svg>
                                        </span>
                                        <span wire:loading wire:target="addToCart({{ $product->id }})">
                                            <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                            </svg>
                                        </span>
                                    </button>
                                </div>

                                {{-- Info --}}
                                <div class="mt-3 flex flex-col flex-1 px-1">
                                    <h3 class="font-bold text-gray-800 text-[15px] leading-tight line-clamp-2 mb-1 group-hover:text-[#15803d] transition-colors">
                                        {{ $product->name }}
                                    </h3>

                                    <div class="mt-auto flex items-end justify-between">
                                        <div class="flex flex-col">
                                            <span class="font-extrabold text-[#78350f] text-lg leading-none">
                                                {{ number_format($product->price, 0, ',', '.') }}<span class="text-xs align-top font-bold opacity-80">đ</span>
                                            </span>
                                        </div>

                                        {{-- Badge if already in cart --}}
                                        @if(isset($cart[$product->id]))
                                            <span class="bg-green-100 text-green-700 text-[10px] font-bold px-2 py-0.5 rounded-full">
                                                x{{ $cart[$product->id]['quantity'] }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach
    </div>

    {{-- ==================== FLOATING CART BAR ==================== --}}
    @if($this->cartCount > 0)
        <div class="fixed bottom-0 left-0 right-0 z-40 bg-white border-t border-gray-100 shadow-[0_-4px_20px_-2px_rgba(0,0,0,0.1)] p-4 safe-area-bottom">
            <div class="flex items-center justify-between gap-4 max-w-md mx-auto">
                <div class="flex flex-col">
                    <span class="text-[10px] text-gray-400 font-semibold uppercase tracking-wider">Tổng tiền</span>
                    <span class="text-xl font-extrabold text-[#78350f]">{{ number_format($this->cartTotal, 0, ',', '.') }}đ</span>
                </div>

                <button
                    wire:click="toggleCart"
                    class="flex-1 bg-[#15803d] text-white py-3.5 px-6 rounded-xl font-bold shadow-lg shadow-green-900/20 hover:bg-green-700 active:scale-95 transition-all flex items-center justify-center space-x-2"
                >
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    <span>XEM GIỎ</span>
                    <span class="bg-white/20 px-2.5 py-0.5 rounded-full text-xs font-black">{{ $this->cartCount }}</span>
                </button>
            </div>
        </div>
    @endif

    {{-- ==================== CART MODAL ==================== --}}
    @if($showCart)
        <div class="fixed inset-0 z-50">
            {{-- Backdrop --}}
            <div
                wire:click="toggleCart"
                class="absolute inset-0 bg-black/60 backdrop-blur-sm"
            ></div>

            {{-- Modal Content --}}
            <div class="absolute bottom-0 left-0 right-0 bg-white rounded-t-3xl shadow-2xl max-h-[85vh] flex flex-col safe-area-bottom">
                {{-- Header --}}
                <div class="p-5 border-b border-gray-100 flex items-center justify-between bg-white rounded-t-3xl sticky top-0 z-10">
                    <div>
                        <h3 class="font-extrabold text-xl text-gray-800">Giỏ hàng</h3>
                        <p class="text-xs text-gray-400 font-medium">{{ $this->cartCount }} món - Kiểm tra trước khi gửi bếp</p>
                    </div>
                    <button wire:click="toggleCart" class="p-2 bg-gray-100 rounded-full text-gray-500 hover:bg-gray-200 transition-colors">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                {{-- Items List --}}
                <div class="overflow-y-auto p-4 space-y-3 flex-1 bg-gray-50">
                    @forelse($cart as $id => $item)
                        <div wire:key="cart-item-{{ $id }}" class="flex gap-3 bg-white p-3 rounded-2xl shadow-sm border border-gray-100 relative">
                            {{-- Image --}}
                            <div class="w-20 h-20 rounded-xl bg-gray-100 overflow-hidden flex-shrink-0 shadow-inner">
                                @if($item['image'] && Storage::disk('public')->exists($item['image']))
                                    <img
                                        src="{{ asset('storage/' . $item['image']) }}"
                                        alt="{{ $item['name'] }}"
                                        class="w-full h-full object-cover"
                                    >
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-green-50">
                                        <svg class="w-8 h-8 text-green-300" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="32" cy="38" rx="22" ry="8" fill="currentColor" opacity="0.3"/>
                                            <ellipse cx="32" cy="36" rx="22" ry="6" stroke="currentColor" stroke-width="2" fill="none"/>
                                            <path d="M10 36c0-12 8-22 22-22s22 10 22 22" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round"/>
                                            <path d="M32 14v-4M32 10c0-2 1-4 3-4" stroke="currentColor" stroke-width="2" stroke-linecap="round" fill="none"/>
                                            <path d="M10 36v4c0 3.3 9.8 6 22 6s22-2.7 22-6v-4" stroke="currentColor" stroke-width="2" fill="none"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            {{-- Info & Controls --}}
                            <div class="flex-1 flex flex-col justify-between py-0.5">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1 pr-2">
                                        <h4 class="font-bold text-gray-800 text-sm line-clamp-1">{{ $item['name'] }}</h4>
                                        <p class="text-[#78350f] font-bold text-sm mt-0.5">{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}đ</p>
                                    </div>

                                    {{-- Delete Button --}}
                                    <button
                                        wire:click="removeFromCart('{{ $id }}')"
                                        class="p-1.5 text-red-400 hover:text-red-600 bg-red-50 hover:bg-red-100 rounded-full transition-colors flex-shrink-0"
                                        title="Xóa món"
                                    >
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>

                                {{-- Quantity Controls --}}
                                <div class="flex items-center mt-2">
                                    <div class="flex items-center bg-gray-100 rounded-lg p-0.5">
                                        <button
                                            wire:click="updateQuantity('{{ $id }}', -1)"
                                            class="w-8 h-8 flex items-center justify-center bg-white rounded-md shadow-sm text-gray-600 font-bold active:scale-90 transition-transform"
                                        >
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 12H4"/></svg>
                                        </button>
                                        <span class="w-10 text-center font-bold text-sm text-gray-800">{{ $item['quantity'] }}</span>
                                        <button
                                            wire:click="updateQuantity('{{ $id }}', 1)"
                                            class="w-8 h-8 flex items-center justify-center bg-[#15803d] text-white rounded-md shadow-sm font-bold active:scale-90 transition-transform"
                                        >
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-gray-400 py-12 flex flex-col items-center">
                            <div class="bg-gray-100 p-4 rounded-full mb-3">
                                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                            <p>Giỏ hàng đang trống</p>
                        </div>
                    @endforelse
                </div>

                {{-- Footer: Total + Submit --}}
                @if(count($cart) > 0)
                    <div class="p-5 bg-white border-t border-gray-100">
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-gray-500 font-medium">Tạm tính</span>
                            <span class="text-2xl font-black text-[#78350f]">{{ number_format($this->cartTotal, 0, ',', '.') }}đ</span>
                        </div>

                        <button
                            wire:click="submitOrder"
                            wire:loading.attr="disabled"
                            wire:target="submitOrder"
                            class="w-full bg-[#15803d] text-white py-4 rounded-xl font-bold text-lg shadow-lg shadow-green-900/20 hover:bg-[#106630] transition active:scale-[0.98] flex items-center justify-center space-x-2 disabled:opacity-70"
                        >
                            <span wire:loading.remove wire:target="submitOrder" class="flex items-center space-x-2">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                                <span>GỌI MÓN NGAY</span>
                            </span>
                            <span wire:loading wire:target="submitOrder" class="flex items-center space-x-2">
                                <svg class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                </svg>
                                <span>ĐANG GỬI ĐƠN...</span>
                            </span>
                        </button>
                        <p class="text-center text-[10px] text-gray-400 mt-2 font-medium">
                            Nhân viên sẽ xác nhận món ngay sau khi bạn gửi.
                        </p>
                    </div>
                @endif
            </div>
        </div>
    @endif

    {{-- Feedback Modal --}}
    @livewire('client.feedback-modal')
</div>
