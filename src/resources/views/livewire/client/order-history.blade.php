<div class="min-h-screen bg-[#FAFAFA]" x-data>
    <!-- Header -->
    <header class="bg-white sticky top-0 z-10 shadow-sm border-b border-gray-100">
        <div class="px-4 h-16 flex items-center justify-between">
            <a href="{{ route('home') }}" class="text-gray-500 hover:text-gray-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h1 class="font-bold text-lg text-gray-800">Đơn đã gọi</h1>
            <div class="w-6"></div> <!-- Spacer for center alignment -->
        </div>
    </header>

    <div class="p-4 pb-20 space-y-6">
        @forelse($orders as $order)
            <div class="space-y-4">
                <div class="flex items-center space-x-2 text-sm text-gray-500 font-medium ml-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Lượt gọi lúc {{ $order->created_at->format('H:i') }}</span>
                    <span>•</span>
                    <span>{{ $order->items->count() }} món</span>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden divide-y divide-gray-100">
                    @foreach($order->items as $item)
                        <div class="p-3 flex items-center space-x-3" wire:key="item-{{ $item->id }}">
                            <!-- Image -->
                            <div class="w-16 h-16 rounded-lg bg-gray-100 overflow-hidden flex-shrink-0">
                                <img 
                                    src="{{ $item->product->image_url ? Storage::url($item->product->image_url) : 'https://placehold.co/100x100' }}" 
                                    onerror="this.onerror=null; this.src='https://placehold.co/100x100?text=No+Image';"
                                    class="w-full h-full object-cover"
                                >
                            </div>

                            <!-- Content -->
                                    <div class="flex-1 min-w-0">
                                        <div class="flex justify-between items-start mb-1">
                                            <h3 class="font-bold text-gray-800 text-sm truncate pr-2">{{ $item->product->name }}</h3>
                                            <span class="text-xs font-bold text-gray-500 whitespace-nowrap">x{{ $item->quantity }}</span>
                                        </div>
                                        
                                        <div class="flex justify-between items-end">
                                            <p class="text-sm font-medium text-brand-brown">{{ number_format($item->price, 0, ',', '.') }}đ</p>
                                            
                                            @php
                                                $statusClasses = [
                                                    'pending' => 'bg-gray-100 text-gray-600',
                                                    'processing' => 'bg-orange-100 text-orange-600 animate-pulse',
                                                    'completed' => 'bg-green-100 text-green-600',
                                                    'cancelled' => 'bg-red-100 text-red-600',
                                                ];
                                                $statusLabels = [
                                                    'pending' => 'Đang chờ',
                                                    'processing' => 'Đang nấu',
                                                    'completed' => 'Đã lên món',
                                                    'cancelled' => 'Đã hủy',
                                                ];
                                                $status = $item->status ?? 'pending';
                                            @endphp

                                            <div class="flex items-center space-x-2">
                                                @if($status === 'pending')
                                                    <button 
                                                        wire:click="cancelItem({{ $item->id }})"
                                                        wire:confirm="Bạn có chắc chắn muốn hủy món này không?"
                                                        wire:loading.attr="disabled"
                                                        wire:target="cancelItem({{ $item->id }})"
                                                        class="text-xs font-bold text-red-500 border border-red-200 px-2 py-1 rounded bg-red-50 hover:bg-red-100 disabled:opacity-50"
                                                    >
                                                        <span wire:loading.remove wire:target="cancelItem({{ $item->id }})">Hủy</span>
                                                        <span wire:loading wire:target="cancelItem({{ $item->id }})">...</span>
                                                    </button>
                                                @endif
                                                
                                                <span class="px-2 py-1 rounded-md text-xs font-bold {{ $statusClasses[$status] ?? 'bg-gray-100' }}">
                                                    {{ $statusLabels[$status] ?? 'Chờ xác nhận' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="text-center py-12">
                <div class="bg-gray-100 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-2">Chưa có đơn hàng nào</h3>
                <p class="text-gray-500 mb-6">Bạn chưa gọi món nào cả.</p>
                <a href="{{ route('home') }}" class="inline-block px-6 py-2 bg-brand-green text-white font-bold rounded-lg shadow-md hover:bg-green-700">
                    Xem Menu ngay
                </a>
            </div>
        @endforelse
    </div>
    
    <!-- Footer Total & Action -->
    <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-100 p-4 safe-area-bottom shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)]">
        @if(count($orders) > 0)
            <div class="flex justify-between items-center text-sm mb-3 text-gray-500">
                <span>Tổng số món đã gọi</span>
                <span class="font-bold text-gray-800">
                    {{ $orders->sum(fn($o) => $o->items->sum('quantity')) }} món
                </span>
            </div>
            <div class="flex justify-between items-center text-lg mb-4">
                <span class="font-bold text-gray-800">Tổng tạm tính</span>
                <span class="font-bold text-brand-green text-xl">
                    {{ number_format($orders->sum('total_amount'), 0, ',', '.') }}đ
                </span>
            </div>
        @endif
        
        <a 
            href="{{ route('home') }}"
            class="w-full bg-[#15803d] text-white py-3.5 rounded-xl font-bold text-lg shadow-lg shadow-green-900/10 hover:bg-[#106630] transition active:scale-[0.98] flex items-center justify-center space-x-2"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            <span>GỌI THÊM MÓN</span>
        </a>
    </div>
</div>
