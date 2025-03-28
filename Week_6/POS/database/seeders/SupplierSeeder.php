<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'supplier_id' => 1,
                'supplier_kode' => 'VCN',
                'supplier_nama' => 'Vanessa Cristin Natalia',
                'supplier_alamat' => 'Malang',
            ],
            [
                'supplier_id' => 2,
                'supplier_kode' => 'JJH',
                'supplier_nama' => 'Jung Jae Hyun',
                'suplier_alamat' => 'Korea',
            ],
            [
                'supplier_id' => 3,
                'supplier_kode' => 'SBR',
                'supplier_nama' => 'Sabar',
                'supplier_alamat' => 'Papua',
            ],
        ];
        DB::table('m_supplier')->insert($data);
    }
}