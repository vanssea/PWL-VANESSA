<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('t_penjualan')->insert([
            [
                'penjualan_id'       => 1,
                'user_id'            => 1,
                'pembeli'            => 'Pelanggan 1',
                'penjualan_kode'     => 'TRX001',
                'penjualan_tanggal'  => now(),
            ],
            [
                'penjualan_id'       => 2,
                'user_id'            => 1,
                'pembeli'            => 'Pelanggan 2',
                'penjualan_kode'     => 'TRX002',
                'penjualan_tanggal'  => now(),
            ],
            [
                'penjualan_id'       => 3,
                'user_id'            => 1,
                'pembeli'            => 'Pelanggan 3',
                'penjualan_kode'     => 'TRX003',
                'penjualan_tanggal'  => now(),
            ],
            [
                'penjualan_id'       => 4,
                'user_id'            => 1,
                'pembeli'            => 'Pelanggan 4',
                'penjualan_kode'     => 'TRX004',
                'penjualan_tanggal'  => now(),
            ],
            [
                'penjualan_id'       => 5,
                'user_id'            => 1,
                'pembeli'            => 'Pelanggan 5',
                'penjualan_kode'     => 'TRX005',
                'penjualan_tanggal'  => now(),
            ],
            [
                'penjualan_id'       => 6,
                'user_id'            => 1,
                'pembeli'            => 'Pelanggan 6',
                'penjualan_kode'     => 'TRX006',
                'penjualan_tanggal'  => now(),
            ],
            [
                'penjualan_id'       => 7,
                'user_id'            => 1,
                'pembeli'            => 'Pelanggan 7',
                'penjualan_kode'     => 'TRX007',
                'penjualan_tanggal'  => now(),
            ],
            [
                'penjualan_id'       => 8,
                'user_id'            => 1,
                'pembeli'            => 'Pelanggan 8',
                'penjualan_kode'     => 'TRX008',
                'penjualan_tanggal'  => now(),
            ],
            [
                'penjualan_id'       => 9,
                'user_id'            => 1,
                'pembeli'            => 'Pelanggan 9',
                'penjualan_kode'     => 'TRX009',
                'penjualan_tanggal'  => now(),
            ],
            [
                'penjualan_id'       => 10,
                'user_id'            => 1,
                'pembeli'            => 'Pelanggan 10',
                'penjualan_kode'     => 'TRX010',
                'penjualan_tanggal'  => now(),
            ],
        ]);
    }
}
