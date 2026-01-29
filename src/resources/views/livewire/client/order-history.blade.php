<div class="min-h-screen bg-[#FAFAFA]" x-data>
    <!-- Header -->
    <header class="bg-white sticky top-0 z-10 shadow-sm border-b border-gray-100">
        <div class="px-4 h-16 flex items-center justify-between">
            <a href="{{ route('home') }}" class="p-2 -ml-2 text-gray-500 hover:text-gray-800 active:scale-95 transition-transform">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h1 class="font-bold text-lg text-gray-800">Đơn đã gọi</h1>
            <div class="w-6"></div>
        </div>
    </header>

    <div class="p-4 pb-52 space-y-6">
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

                <div class="bg-white rounded-xl shadow-md border border-gray-100/80 overflow-hidden divide-y divide-gray-100">
                    @foreach($order->items as $item)
                        <div class="p-3 flex items-center space-x-3" wire:key="item-{{ $item->id }}">
                            <!-- Image -->
                            <div class="w-16 h-16 rounded-lg bg-gray-100 overflow-hidden flex-shrink-0">
                                @if($item->product->image && Storage::disk('public')->exists($item->product->image))
                                    <img
                                        src="{{ asset('storage/' . $item->product->image) }}"
                                        alt="{{ $item->product->name }}"
                                        class="w-full h-full object-cover"
                                    >
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-emerald-50 to-amber-50 relative">
                                        <div class="absolute inset-0 opacity-[0.06]" style="background-image: radial-gradient(circle at 2px 2px, #15803d 1px, transparent 0); background-size: 12px 12px;"></div>
                                        <svg class="w-8 h-8 relative" viewBox="0 0 80 80" fill="none">
                                            <path d="M30 28c0-3 2-5 0-8s2-5 0-8" stroke="#86efac" stroke-width="2" stroke-linecap="round" fill="none" opacity="0.6"/>
                                            <path d="M40 26c0-3 2-5 0-8s2-5 0-8" stroke="#86efac" stroke-width="2" stroke-linecap="round" fill="none" opacity="0.4"/>
                                            <path d="M50 28c0-3 2-5 0-8s2-5 0-8" stroke="#86efac" stroke-width="2" stroke-linecap="round" fill="none" opacity="0.6"/>
                                            <ellipse cx="40" cy="44" rx="24" ry="8" fill="#bbf7d0" opacity="0.6"/>
                                            <path d="M16 44c2 10 12 16 24 16s22-6 24-16" fill="#86efac" opacity="0.5"/>
                                            <path d="M16 44c2 10 12 16 24 16s22-6 24-16" stroke="#22c55e" stroke-width="2" fill="none"/>
                                            <ellipse cx="40" cy="44" rx="24" ry="8" stroke="#22c55e" stroke-width="2" fill="none"/>
                                            <circle cx="33" cy="41" r="3" fill="#f59e0b" opacity="0.6"/>
                                            <circle cx="42" cy="39" r="2.5" fill="#ef4444" opacity="0.5"/>
                                            <circle cx="48" cy="42" r="2" fill="#22c55e" opacity="0.6"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <!-- Content -->
                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between items-start mb-1">
                                    <h3 class="font-bold text-gray-800 text-sm truncate pr-2">{{ $item->product->name }}</h3>
                                    <span class="text-xs font-bold text-gray-500 whitespace-nowrap">x{{ $item->quantity }}</span>
                                </div>

                                <div class="flex justify-between items-end">
                                    <p class="text-sm font-bold text-[#78350f]">{{ number_format($item->price, 0, ',', '.') }}đ</p>

                                    @php
                                        $statusClasses = [
                                            'pending' => 'bg-gray-100 text-gray-600',
                                            'processing' => 'bg-orange-100 text-orange-600 animate-pulse',
                                            'completed' => 'bg-green-100 text-green-600',
                                            'cancelled' => 'bg-red-100 text-red-600 line-through',
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
                                                class="text-xs font-bold text-red-500 border border-red-200 px-2 py-1 rounded bg-red-50 hover:bg-red-100 active:scale-95 transition-all disabled:opacity-50"
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
            <div class="text-center py-16">
                <div class="bg-gray-100 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-2">Chưa có đơn hàng nào</h3>
                <p class="text-gray-500 mb-6">Bạn chưa gọi món nào cả.</p>
                <a href="{{ route('home') }}" class="inline-block px-6 py-3 bg-[#15803d] text-white font-bold rounded-xl shadow-md hover:bg-green-700 active:scale-95 transition-all">
                    Xem Menu ngay
                </a>
            </div>
        @endforelse
    </div>

    <!-- Footer Total & Action -->
    <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-100 safe-area-bottom shadow-[0_-4px_20px_-2px_rgba(0,0,0,0.08)] z-20">
        @if(count($orders) > 0)
            <div class="px-5 pt-4 pb-1">
                <div class="flex justify-between items-center py-2 text-sm text-gray-500">
                    <span>Tổng số món đã gọi</span>
                    <span class="font-bold text-gray-800">
                        {{ $orders->sum(fn($o) => $o->items->sum('quantity')) }} món
                    </span>
                </div>
                <div class="flex justify-between items-center py-2 border-t border-dashed border-gray-200">
                    <span class="font-bold text-gray-800 text-base">Tổng tạm tính</span>
                    <span class="font-black text-[#78350f] text-xl">
                        {{ number_format($orders->sum('total_amount'), 0, ',', '.') }}đ
                    </span>
                </div>
            </div>
        @endif

        <div class="px-5 pb-4 pt-2">
            <a
                href="{{ route('home') }}"
                class="w-full bg-[#15803d] text-white py-4 rounded-xl font-bold text-lg shadow-lg shadow-green-900/15 hover:bg-[#106630] transition-all active:scale-[0.97] flex items-center justify-center space-x-2"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                <span>GỌI THÊM MÓN</span>
            </a>
        </div>
    </div>
</div>
