<?php

namespace App\Http\Controllers;

use App\Models\KategoriModel;
use Illuminate\Http\Request;
use App\DataTables\KategoriDataTable;

class KategoriController extends Controller
{
    public function index(KategoriDataTable $dataTable)
    {
        return $dataTable->render('kategori.index');
    }

    public function create()
    {
        return view('kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kodeKategori' => 'required|unique:kategori,kategori_kode|max:10',
            'namaKategori' => 'required|string|max:255',
        ]);

        KategoriModel::create([
            'kategori_kode' => $request->kodeKategori,
            'kategori_nama' => $request->namaKategori,
        ]);

        return redirect('/kategori')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $kategori = KategoriModel::findOrFail($id);
        return view('kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori_kode' => 'required|string|max:50',
            'kategori_nama' => 'required|string|max:100',
        ]);

        $kategori = KategoriModel::findOrFail($id);
        $kategori->update([
            'kategori_kode' => $request->kategori_kode,
            'kategori_nama' => $request->kategori_nama,
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $kategori = KategoriModel::findOrFail($id);
        $kategori->delete();

        return response()->json(['message' => 'Kategori berhasil dihapus!']);
    }
}


// Jobsheet 5 - Praktikum 2
// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use App\DataTables\KategoriDataTable;

// class KategoriController extends Controller
// {
//     public function index(KategoriDataTable $dataTable)
//     {
//         return $dataTable->render('kategori.index');
//     }
// }

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;

// class KategoriController extends Controller
// {
//     public function index()
//     {
//         // $data = [
//         //     'kategori_kode' => 'SNK',
//         //     'kategori_nama' => 'Snack/Makanan Ringan',
//         //     'created_at' => now()
//         // ];

//         // DB::table('m_kategori')->insert($data);
//         // return 'Insert data baru berhasil';

//         // $row = DB::table('m_kategori') -> where ('kategori_kode', 'SNK') -> update(['kategori_nama' => 'Camilan']);
//         // return 'Update data berhasil. Jumlah data yang diupdate: ' .$row.' baris';

//         // $row = DB::table('m_kategori') -> where ('kategori_kode', 'SNK') -> delete();
//         // return 'Delete data berhasil. Jumlah data yang dihapus: ' .$row.' baris';

//         $data = DB::table('m_kategori')->get();
//         return view('kategori', ['data' => $data]); // Pastikan 'kategori' sesuai dengan nama file view
    
//     }
// }
