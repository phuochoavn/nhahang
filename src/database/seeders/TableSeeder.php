<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            \App\Models\Table::create([
                'name' => 'Bàn ' . $i,
                'status' => 'available',
                'qr_code_url' => 'https://nhahang.hoadigital.com/?table=' . $i,
            ]);
        }
    }
}
