<div class="min-h-screen flex items-center justify-center bg-gray-900 text-white">
    <div class="bg-gray-800 p-8 rounded-xl shadow-2xl w-full max-w-md text-center border border-gray-700">
        <h1 class="text-3xl font-bold mb-6 text-orange-500">🔐 Bếp Đăng Nhập</h1>
        
        <p class="text-gray-400 mb-8">Nhập mã PIN để truy cập màn hình Bếp.</p>

        <form wire:submit="login" class="space-y-6">
            <div>
                <input type="password" wire:model="pin" 
                    class="w-full text-center text-4xl tracking-widest bg-gray-700 border border-gray-600 rounded-lg py-4 focus:ring-2 focus:ring-orange-500 focus:outline-none text-white placeholder-gray-500" 
                    placeholder="••••" autofocus>
                @if($error)
                    <p class="text-red-500 mt-2 text-sm">{{ $error }}</p>
                @endif
            </div>

            <button type="submit" 
                class="w-full bg-orange-600 hover:bg-orange-500 text-white font-bold py-4 rounded-lg transition transform active:scale-95 text-xl">
                Truy Cập
            </button>
        </form>
    </div>
</div>
