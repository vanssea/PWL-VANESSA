<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('m_kategori')->insert([
            [
                'kategori_id'   => 1, 
                'kategori_kode' => 'ELEK', 
                'kategori_nama' => 'Elektronik'
            ],
            [
                'kategori_id'   => 2, 
                'kategori_kode' => 'PAK', 
                'kategori_nama' => 'Pakaian'
            ],
            [
                'kategori_id'   => 3, 
                'kategori_kode' => 'MAK', 
                'kategori_nama' => 'Makanan'
            ],
            [
                'kategori_id'   => 4, 
                'kategori_kode' => 'MIN', 
                'kategori_nama' => 'Minuman'
            ],
            [
                'kategori_id'   => 5, 
                'kategori_kode' => 'RUM', 
                'kategori_nama' => 'Peralatan Rumah Tangga'
            ],
        ]);
    }
}
