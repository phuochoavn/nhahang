<div class="min-h-screen bg-gray-50">
    <!-- Hero Banner -->
    <div class="relative h-48 w-full bg-gray-900 overflow-hidden mt-16">
        <div class="absolute inset-0 opacity-60">
            <img 
                src="https://images.unsplash.com/photo-1555396273-367ea4eb4db5?q=80&w=1000&auto=format&fit=crop" 
                alt="Hero Background" 
                class="w-full h-full object-cover"
            >
        </div>
        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-transparent to-transparent"></div>
        <div class="relative h-full flex flex-col justify-end px-5 pb-5">
            <h2 class="text-white font-bold text-2xl leading-tight drop-shadow-lg mb-1">
                Ẩm thực <span class="text-brand-green italic">Suối Đá</span>
            </h2>
            <p class="text-gray-200 text-sm font-medium drop-shadow-md opacity-90">
                Thưởng thức hương vị Tây Nguyên giữa đại ngàn
            </p>
        </div>
    </div>

    <!-- Sticky Category Navigation -->
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

    <!-- Product Grid -->
    <div class="p-3 pb-28 space-y-6 bg-gray-50/50">
        @foreach($categories as $category)
            @if($category->products->isNotEmpty())
                <div id="category-{{ $category->id }}" class="scroll-mt-32">
                    <!-- Section Header -->
                    <div class="flex items-center space-x-3 mb-4 px-2 pt-2">
                        <div class="w-1.5 h-6 bg-gradient-to-b from-[#15803d] to-[#78350f] rounded-full"></div>
                        <h2 class="text-lg font-black text-gray-800 tracking-wide uppercase">{{ $category->name }}</h2>
                    </div>
                    
                    <!-- Grid -->
                    <div class="grid grid-cols-2 gap-3">
                        @foreach($category->products as $product)
                            <!-- High-End Product Card -->
                            <div 
                                class="group bg-white rounded-3xl p-2.5 shadow-[0_4px_20px_-2px_rgba(0,0,0,0.05)] border border-gray-100 flex flex-col h-full relative overflow-hidden active:scale-[0.98] transition-all duration-200"
                                wire:key="product-{{ $product->id }}"
                            >
                                <!-- Image Container -->
                                <div class="relative aspect-square rounded-2xl overflow-hidden bg-gray-100 shadow-inner">
                                    @if($product->image_url)
                                        <img 
                                            src="{{ Storage::url($product->image_url) }}" 
                                            alt="{{ $product->name }}" 
                                            loading="lazy"
                                            onerror="this.onerror=null; this.src='https://placehold.co/400x400?text=No+Image';"
                                            class="w-full h-full object-cover transform transition-transform duration-700 group-hover:scale-110"
                                        >
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gray-100 text-gray-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                    
                                    <!-- Best Seller Tag -->
                                    @if($product->is_best_seller)
                                        <div class="absolute top-0 left-0 bg-[#ef4444] text-white text-[9px] font-black px-2 py-1 rounded-br-lg shadow-sm z-10">
                                            LÊN ĐĨA NHIỀU
                                        </div>
                                    @endif

                                    <!-- Add Button (Overlay on Image for Modern Look) -->
                                    <button 
                                        wire:click="addToCart({{ $product->id }})"
                                        class="absolute bottom-2 right-2 w-8 h-8 rounded-full bg-white/90 backdrop-blur-sm text-[#15803d] flex items-center justify-center shadow-lg active:bg-[#15803d] active:text-white transition-all duration-200"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                                        </svg>
                                    </button>
                                </div>
                                
                                <!-- Info -->
                                <div class="mt-3 flex flex-col flex-1 px-1">
                                    <h3 class="font-bold text-gray-800 text-[15px] leading-tight line-clamp-2 mb-1 group-hover:text-[#15803d] transition-colors">
                                        {{ $product->name }}
                                    </h3>
                                    
                                    <div class="mt-auto flex items-end justify-between">
                                        <div class="flex flex-col">
                                            <span class="text-xs text-gray-400 font-medium line-through decoration-gray-300 decoration-1">{{ number_format($product->price * 1.2, 0, ',', '.') }}</span>
                                            <span class="font-extrabold text-[#78350f] text-lg leading-none">
                                                {{ number_format($product->price, 0, ',', '.') }}<span class="text-xs align-top font-bold opacity-80">đ</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach
    </div>

    <!-- Cart Button Component -->
    @livewire('client.cart-button')

    <!-- Feedback Modal -->
    @livewire('client.feedback-modal')
</div>
