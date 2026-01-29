<div class="min-h-screen bg-gray-900 text-white p-4" x-data="{
    playSound() {
        const audio = new Audio('https://cdn.freesound.org/previews/320/320655_5260872-lq.mp3'); // Example ding sound
        audio.play().catch(e => console.log('Audio playback failed', e));
    }
}"
@play-new-order-sound.window="playSound()"
wire:poll.10s="refreshOrders">
    
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-bold text-orange-500">BẾP - DANH SÁCH ĐƠN</h1>
        <div class="text-xl" wire:poll.10s>{{ now()->format('H:i') }}</div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
        @forelse($orders as $order)
        <div class="bg-gray-800 rounded-xl p-4 border-l-4 {{ $order->status == 'pending' ? 'border-red-500' : 'border-blue-500' }} shadow-lg">
            <div class="flex justify-between items-start mb-3 border-b border-gray-700 pb-2">
                <div>
                    <span class="text-2xl font-bold bg-white text-black px-2 py-0.5 rounded">
                        Bàn {{ $order->table->name ?? '?' }}
                    </span>
                    <div class="text-xs text-gray-400 mt-1">#{{ $order->id }} - {{ $order->created_at->format('H:i') }}</div>
                </div>
                <div>
                    @if($order->status == 'pending')
                    <span class="animate-pulse bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded">MỚI</span>
                    @else
                    <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">ĐANG LÀM</span>
                    @endif
                </div>
            </div>

            <div class="space-y-3 mb-4">
                @foreach($order->items as $item)
                <div class="flex justify-between items-center text-lg">
                    <div class="flex items-center">
                        <span class="font-bold text-orange-400 mr-2">{{ $item->quantity }}x</span>
                        <span>{{ $item->product->name }}</span>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-4 flex gap-2">
                @if($order->status == 'pending')
                <button wire:click="updateStatus({{ $order->id }}, 'processing')" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition-colors">
                    NHẬN ĐƠN
                </button>
                @endif

                @if($order->status == 'processing')
                <button wire:click="updateStatus({{ $order->id }}, 'completed')" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition-colors">
                    HOÀN THÀNH
                </button>
                @endif
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-20 text-gray-500">
            <svg class="mx-auto h-20 w-20 opacity-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            <p class="mt-4 text-xl">Chưa có đơn hàng nào</p>
        </div>
        @endforelse
    </div>
</div>
