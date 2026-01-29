<div>
    @if(count($cart) > 0)
        <!-- Floating Bar (Bottom) -->
        <div class="fixed bottom-0 left-0 right-0 z-40 bg-white border-t border-gray-100 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)] p-4 safe-area-bottom animate-slide-up">
            <div class="flex items-center justify-between gap-4 max-w-md mx-auto">
                <div class="flex flex-col">
                    <span class="text-xs text-gray-500 font-medium uppercase tracking-wide">Tổng tiền</span>
                    <span class="text-xl font-extrabold text-[#78350f]">{{ number_format($this->total, 0, ',', '.') }}đ</span>
                </div>
                
                <button 
                    wire:click="toggleCart"
                    class="flex-1 bg-brand-green text-white py-3 px-6 rounded-xl font-bold shadow-lg shadow-green-900/10 hover:bg-green-700 active:scale-95 transition-all flex items-center justify-center space-x-2"
                >
                    <span>XEM & GỌI MÓN</span>
                    <div class="bg-white/20 px-2 py-0.5 rounded-full text-xs">
                        {{ $this->count }}
                    </div>
                </button>
            </div>
        </div>
        
        <!-- Spacer to prevent content from being hidden behind the bar -->
        <div class="h-24"></div> 
    @endif

    <!-- Cart Modal -->
    @if($showCart)
        <div class="fixed inset-0 z-50">
            <!-- Backdrop -->
            <div 
                wire:click="toggleCart"
                class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity"
            ></div>

            <!-- Content -->
            <div class="absolute bottom-0 left-0 right-0 bg-white rounded-t-3xl shadow-2xl max-h-[85vh] flex flex-col animate-slide-up safe-area-bottom">
                <!-- Modal Header -->
                <div class="p-5 border-b border-gray-100 flex items-center justify-between bg-white rounded-t-3xl sticky top-0 z-10">
                    <div>
                        <h3 class="font-extrabold text-xl text-gray-800">Giỏ hàng</h3>
                        <p class="text-xs text-gray-400 font-medium">Kiểm tra lại món trước khi gửi</p>
                    </div>
                    <button wire:click="toggleCart" class="p-2 bg-gray-100 rounded-full text-gray-500 hover:bg-gray-200 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Items List -->
                <div class="overflow-y-auto p-5 space-y-6 flex-1 bg-gray-50">
                    @forelse($cart as $item)
                        <div class="flex gap-4 bg-white p-3 rounded-2xl shadow-sm border border-gray-100 relative group">
                             <!-- Delete Button (Top Right) -->
                             <button 
                                wire:click="removeItem({{ $item['id'] }})"
                                class="absolute top-2 right-2 p-1.5 text-gray-400 hover:text-red-500 bg-gray-50 hover:bg-red-50 rounded-full transition-colors"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>

                            <!-- Image -->
                            <div class="w-20 h-20 rounded-xl bg-gray-100 overflow-hidden flex-shrink-0 shadow-inner">
                                <img 
                                    src="{{ $item['image'] ? Storage::url($item['image']) : 'https://placehold.co/100x100' }}" 
                                    onerror="this.onerror=null; this.src='https://placehold.co/100x100?text=No+Image';"
                                    class="w-full h-full object-cover"
                                >
                            </div>
                            
                            <!-- Info -->
                            <div class="flex-1 flex flex-col justify-between py-1">
                                <div>
                                    <h4 class="font-bold text-gray-800 line-clamp-1 pr-6">{{ $item['name'] }}</h4>
                                    <p class="text-[#78350f] font-bold text-sm">{{ number_format($item['price'], 0, ',', '.') }}đ</p>
                                </div>

                                <!-- Quantity Controls -->
                                <div class="flex items-center space-x-3 mt-2">
                                    <div class="flex items-center bg-gray-100 rounded-lg p-1">
                                        <button 
                                            wire:click="updateQuantity({{ $item['id'] }}, -1)"
                                            class="w-7 h-7 flex items-center justify-center bg-white rounded-md shadow-sm text-gray-600 active:scale-95 disabled:opacity-50"
                                            {{ $item['quantity'] <= 1 ? 'disabled' : '' }}
                                        >-</button>
                                        <span class="w-8 text-center font-bold text-sm text-gray-800">{{ $item['quantity'] }}</span>
                                        <button 
                                            wire:click="updateQuantity({{ $item['id'] }}, 1)"
                                            class="w-7 h-7 flex items-center justify-center bg-[#15803d] text-white rounded-md shadow-sm active:scale-95"
                                        >+</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-gray-400 py-12 flex flex-col items-center">
                            <div class="bg-gray-100 p-4 rounded-full mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <p>Giỏ hàng đang trống</p>
                        </div>
                    @endforelse
                </div>

                <!-- Footer Action -->
                @if(count($cart) > 0)
                <div class="p-5 bg-white border-t border-gray-100 safe-area-bottom">
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-gray-500 font-medium">Tạm tính</span>
                        <span class="text-2xl font-black text-[#78350f]">{{ number_format($this->total, 0, ',', '.') }}đ</span>
                    </div>
                    
                    <button 
                        wire:click="checkout"
                        class="w-full bg-[#15803d] text-white py-4 rounded-xl font-bold text-lg shadow-lg shadow-green-900/10 hover:bg-[#106630] transition active:scale-[0.98] flex items-center justify-center space-x-2"
                        wire:loading.attr="disabled"
                    >
                        <span wire:loading.remove>GỬI GỌI MÓN NGAY</span>
                        <div wire:loading class="flex items-center space-x-2">
                             <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span>ĐANG GỬI...</span>
                        </div>
                    </button>
                    <p class="text-center text-[10px] text-gray-400 mt-2 font-medium">
                        Nhân viên sẽ xác nhận món ngay sau khi bạn gửi.
                    </p>
                </div>
                @endif
            </div>
        </div>
    @endif
</div>
