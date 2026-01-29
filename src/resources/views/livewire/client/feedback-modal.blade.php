<div>
    @if($show)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 px-4">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6 relative animate-fade-in-up">
            <button wire:click="closeModal" class="absolute top-2 right-2 text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>

            @if($submitted)
                <div class="text-center py-8">
                    <div class="text-green-500 mb-4">
                        <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Cảm ơn bạn!</h3>
                    <p class="text-gray-600">Ý kiến của bạn đã được ghi nhận.</p>
                    <button wire:click="closeModal" class="mt-6 px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition">Đóng</button>
                </div>
            @else
                <h3 class="text-xl font-bold text-gray-800 mb-4 text-center">Đánh giá bữa ăn</h3>
                <p class="text-gray-600 text-center mb-6">Bạn thấy món ăn hôm nay thế nào?</p>

                <div class="flex justify-center space-x-2 mb-6">
                    @foreach(range(1, 5) as $star)
                        <button wire:click="$set('rating', {{ $star }})" class="focus:outline-none transition transform hover:scale-110">
                            <svg class="w-10 h-10 {{ $rating >= $star ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        </button>
                    @endforeach
                </div>

                <div class="mb-4">
                    <textarea wire:model="content" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-orange-500 focus:border-orange-500" rows="3" placeholder="Góp ý thêm (không bắt buộc)..."></textarea>
                </div>

                <button wire:click="submit" class="w-full bg-orange-500 text-white py-3 rounded-lg font-bold hover:bg-orange-600 shadow-md transition transform active:scale-95">
                    Gửi đánh giá
                </button>
            @endif
        </div>
    </div>
    @endif
</div>
