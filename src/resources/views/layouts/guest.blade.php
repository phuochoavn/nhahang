<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Suối Đá Hòn Giao') }}</title>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Styles -->
        @livewireStyles
        <style>
             [x-cloak] { display: none !important; }
        </style>
    </head>
    <body class="font-sans antialiased text-gray-900 bg-[#f8f9fa] pb-24 safe-area-bottom">
        
        <!-- Fixed Header -->
        <!-- Fixed Header -->
        <header class="sticky top-0 z-50 bg-white shadow-sm px-4 py-3 flex justify-between items-center h-16">
            <div class="flex items-center space-x-2 overflow-hidden">
                <!-- Logo -->
                <div class="w-9 h-9 bg-brand-green rounded-full flex items-center justify-center text-white font-bold flex-shrink-0">
                    SĐ
                </div>
                <!-- Brand Name -->
                <div class="flex flex-col overflow-hidden">
                    <h1 class="font-bold text-gray-800 text-sm truncate">Suối Đá Hòn Giao</h1>
                    <span class="text-[10px] text-gray-500 font-medium truncate">Món ngon Tây Nguyên</span>
                </div>
            </div>

            <!-- Table Badge -->
            <div class="flex-shrink-0 ml-2">
                 @if(session('table_id'))
                    @php
                        $tableName = \App\Models\Table::find(session('table_id'))?->name ?? '?';
                        $displayTable = \Illuminate\Support\Str::contains(mb_strtolower($tableName), 'bàn') 
                            ? $tableName 
                            : 'Bàn ' . $tableName;
                    @endphp

                    <div class="flex items-center space-x-2">
                        <a href="{{ route('order.history') }}" class="p-2 text-gray-400 hover:text-brand-green relative transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </a>
                        
                        <div class="bg-green-100 text-green-800 rounded-full px-3 py-1 text-xs font-bold whitespace-nowrap">
                            {{ $displayTable }}
                        </div>
                    </div>
                @endif
            </div>
        </header>

        <!-- Main Content -->
        <main>
            {{ $slot }}
        </main>

        @livewireScripts
    </body>
</html>
