<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('m_barang')->insert([
            [
                'barang_id'    => 1,
                'kategori_id'  => 1,
                'barang_kode'  => 'TV01',
                'barang_nama'  => 'Televisi',
                'harga_beli'   => 3000000,
                'harga_jual'   => 3500000,
            ],
            [
                'barang_id'    => 2,
                'kategori_id'  => 1,
                'barang_kode'  => 'HP01',
                'barang_nama'  => 'Handphone',
                'harga_beli'   => 2000000,
                'harga_jual'   => 2500000,
            ],
            [
                'barang_id'    => 3,
                'kategori_id'  => 2,
                'barang_kode'  => 'BJU01',
                'barang_nama'  => 'Baju Kemeja',
                'harga_beli'   => 150000,
                'harga_jual'   => 200000,
            ],
            [
                'barang_id'    => 4,
                'kategori_id'  => 2,
                'barang_kode'  => 'CLN01',
                'barang_nama'  => 'Celana Jeans',
                'harga_beli'   => 180000,
                'harga_jual'   => 220000,
            ],
            [
                'barang_id'    => 5,
                'kategori_id'  => 3,
                'barang_kode'  => 'MI01',
                'barang_nama'  => 'Mie Instan',
                'harga_beli'   => 2500,
                'harga_jual'   => 3000,
            ],
            [
                'barang_id'    => 6,
                'kategori_id'  => 3,
                'barang_kode'  => 'RC01',
                'barang_nama'  => 'Roti Coklat',
                'harga_beli'   => 5000,
                'harga_jual'   => 7000,
            ],
            [
                'barang_id'    => 7,
                'kategori_id'  => 4,
                'barang_kode'  => 'SRP01',
                'barang_nama'  => 'Sirup',
                'harga_beli'   => 15000,
                'harga_jual'   => 20000,
            ],
            [
                'barang_id'    => 8,
                'kategori_id'  => 4,
                'barang_kode'  => 'KOP01',
                'barang_nama'  => 'Kopi Sachet',
                'harga_beli'   => 2000,
                'harga_jual'   => 3000,
            ],
            [
                'barang_id'    => 9,
                'kategori_id'  => 5,
                'barang_kode'  => 'BLN01',
                'barang_nama'  => 'Blender',
                'harga_beli'   => 500000,
                'harga_jual'   => 600000,
            ],
            [
                'barang_id'    => 10,
                'kategori_id'  => 5,
                'barang_kode'  => 'JM01',
                'barang_nama'  => 'Jam Dinding',
                'harga_beli'   => 50000,
                'harga_jual'   => 75000,
            ],
        ]);
    }
}
