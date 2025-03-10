<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StokSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('t_stok')->insert([
            [
                'barang_id'   => 1,
                'user_id'     => 1,
                'stok_tanggal'=> now(),
                'stok_jumlah' => 20,
            ],
            [
                'barang_id'   => 2,
                'user_id'     => 1,
                'stok_tanggal'=> now(),
                'stok_jumlah' => 25,
            ],
            [
                'barang_id'   => 3,
                'user_id'     => 1,
                'stok_tanggal'=> now(),
                'stok_jumlah' => 30,
            ],
            [
                'barang_id'   => 4,
                'user_id'     => 1,
                'stok_tanggal'=> now(),
                'stok_jumlah' => 35,
            ],
            [
                'barang_id'   => 5,
                'user_id'     => 1,
                'stok_tanggal'=> now(),
                'stok_jumlah' => 40,
            ],
            [
                'barang_id'   => 6,
                'user_id'     => 1,
                'stok_tanggal'=> now(),
                'stok_jumlah' => 45,
            ],
            [
                'barang_id'   => 7,
                'user_id'     => 1,
                'stok_tanggal'=> now(),
                'stok_jumlah' => 50,
            ],
            [
                'barang_id'   => 8,
                'user_id'     => 1,
                'stok_tanggal'=> now(),
                'stok_jumlah' => 55,
            ],
            [
                'barang_id'   => 9,
                'user_id'     => 1,
                'stok_tanggal'=> now(),
                'stok_jumlah' => 60,
            ],
            [
                'barang_id'   => 10,
                'user_id'     => 1,
                'stok_tanggal'=> now(),
                'stok_jumlah' => 65,
            ],
        ]);
    }
}
