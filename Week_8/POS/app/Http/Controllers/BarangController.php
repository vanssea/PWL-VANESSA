<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Validator;
use App\Models\KategoriModel; // Pastikan model kategori tersedia

class BarangController extends Controller
{
    // Menampilkan halaman daftar barang + filter kategori
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Barang',
            'list'  => ['Home', 'Barang']
        ];

        $page = (object) [
            'title' => 'Daftar barang yang terdaftar dalam sistem'
        ];

        $activeMenu = 'barang'; // menu aktif

        // Ambil semua data kategori untuk dropdown filter
        // $kategori = KategoriModel::all();

        // Mengambil semua data kategori untuk filed kategeri_id dan kategori_nama
        $kategori = KategoriModel::select('kategori_id', 'kategori_nama')->get();

        return view('barang.index', [
            'breadcrumb' => $breadcrumb,
            'page'       => $page,
            'kategori'   => $kategori,
            'activeMenu' => $activeMenu
        ]);
    }

    // Mengambil data barang dalam bentuk JSON (untuk DataTables)
    public function list(Request $request)
    {
        // Select kolom yang ditampilkan di tabel list
        $barang = BarangModel::select(
            'barang_id',
            'kategori_id',
            'barang_kode',
            'barang_nama',
            'harga_jual',
            'harga_beli',
        )
        ->with('kategori'); // relasi ke tabel kategori

        // Filter data berdasarkan kategori_id
        // if ($request->filter_kategori) {
        //     $barang->where('kategori_id', $request->filter_kategori);
        // }

        $kategori_id = $request->input('filter_kategori');
        if(!empty($kategori_id)){
            $barang->where('kategori_id', $kategori_id);
        }


        return DataTables::of($barang)
        ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom:DT_RowIndex)

        ->addColumn('aksi', function ($barang) { // menambahkan kolom aksi
            /* $btn = '<a href="'.url('/user/' . $user->user_id).'" class="btn btn-info btnsm">Detail</a> ';
            $btn .= '<a href="'.url('/user/' . $user->user_id . '/edit').'" class="btn btnwarning btn-sm">Edit</a> ';
            $btn .= '<form class="d-inline-block" method="POST" action="'. url('/user/'.$user-
            >user_id).'">'
            . csrf_field() . method_field('DELETE') .
            '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakit menghapus data ini?\');">Hapus</button></form>';*/
            $btn = '<button onclick="modalAction(\'' . url('/barang/' . $barang->barang_id .
                '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
            $btn .= '<button onclick="modalAction(\'' . url('/barang/' . $barang->barang_id .
                '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
            $btn .= '<button onclick="modalAction(\'' . url('/barang/' . $barang->barang_id .
                '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    // Menampilkan halaman form tambah barang
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Barang',
            'list'  => ['Home', 'Barang', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah barang baru'
        ];

        // Ambil data kategori untuk select
        $kategori = KategoriModel::all();
        $activeMenu = 'barang';

        return view('barang.create', [
            'breadcrumb' => $breadcrumb,
            'page'       => $page,
            'kategori'   => $kategori,
            'activeMenu' => $activeMenu
        ]);
    }

    // Menyimpan data barang baru
    public function store(Request $request)
    {
        $request->validate([
            'kategori_id'  => 'required|integer',
            'barang_kode'  => 'required|string|max:10|unique:m_barang,barang_kode',
            'barang_nama'  => 'required|string|max:100',
            'harga_jual'   => 'required|numeric',
            'harga_beli'   => 'required|numeric'
        ]);

        BarangModel::create([
            'kategori_id'  => $request->kategori_id,
            'barang_kode'  => $request->barang_kode,
            'barang_nama'  => $request->barang_nama,
            'harga_jual'   => $request->harga_jual,
            'harga_beli'   => $request->harga_beli
        ]);

        return redirect('/barang')->with('success', 'Data barang berhasil disimpan');
    }

    // Menampilkan detail barang (harga_jual dan harga_beli ikut ditampilkan)
    public function show(string $id)
    {
        // Gunakan with('kategori') agar bisa menampilkan info kategori di detail
        $barang = BarangModel::with('kategori')->find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Barang',
            'list'  => ['Home', 'Barang', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail barang'
        ];

        $activeMenu = 'barang';

        return view('barang.show', [
            'breadcrumb' => $breadcrumb,
            'page'       => $page,
            'barang'     => $barang,
            'activeMenu' => $activeMenu
        ]);
    }

    // Menampilkan halaman form edit barang
    public function edit(string $id)
    {
        $barang = BarangModel::find($id);

        // Ambil data kategori untuk select
        $kategori = KategoriModel::all();

        $breadcrumb = (object) [
            'title' => 'Edit Barang',
            'list'  => ['Home', 'Barang', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit barang'
        ];

        $activeMenu = 'barang';

        return view('barang.edit', [
            'breadcrumb' => $breadcrumb,
            'page'       => $page,
            'barang'     => $barang,
            'kategori'   => $kategori,
            'activeMenu' => $activeMenu
        ]);
    }

    // Menyimpan perubahan data barang
    public function update(Request $request, string $id)
    {
        $request->validate([
            'kategori_id'  => 'required|integer',
            'barang_kode'  => 'required|string|max:10|unique:m_barang,barang_kode,'.$id.',barang_id',
            'barang_nama'  => 'required|string|max:100',
            'harga_jual'   => 'required|numeric',
            'harga_beli'   => 'required|numeric'
        ]);

        $barang = BarangModel::find($id);
        if (!$barang) {
            return redirect('/barang')->with('error', 'Data barang tidak ditemukan');
        }

        $barang->update([
            'kategori_id'  => $request->kategori_id,
            'barang_kode'  => $request->barang_kode,
            'barang_nama'  => $request->barang_nama,
            'harga_jual'   => $request->harga_jual,
            'harga_beli'   => $request->harga_beli
        ]);

        return redirect('/barang')->with('success', 'Data barang berhasil diubah');
    }

    // Menghapus data barang
    public function destroy(string $id)
    {
        $check = BarangModel::find($id);
        if (!$check) {
            return redirect('/barang')->with('error', 'Data barang tidak ditemukan');
        }

        try {
            BarangModel::destroy($id);
            return redirect('/barang')->with('success', 'Data barang berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            // Jika ada constraint foreign key, dsb.
            return redirect('/barang')->with(
                'error',
                'Data barang gagal dihapus karena masih terdapat data lain yang terkait'
            );
        }
    }

    public function create_ajax()
    {
        $kategori = KategoriModel::select('kategori_id', 'kategori_nama')->get();
        return view('barang.create_ajax')->with('kategori', $kategori);
    }

    public function store_ajax(Request $request)
    {
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kategori_id' => ['required', 'integer', 'exists:m_kategori,kategori_id'],
                'barang_kode' => ['required', 'min:3', 'max:20',
                'unique:m_barang,barang_kode'],
                'barang_nama' => ['required', 'string', 'max:100'],
                'harga_beli' => ['required', 'numeric'],
                'harga_jual' => ['required', 'numeric'],
            ];


            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // response status, false: error/gagal, true: berhasil
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors() // pesan error validasi
                ]);
            }

            BarangModel::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data barang berhasil disimpan'
            ]);
        }

        redirect('/');
    }

    public function edit_ajax(string $id)
    {
        $barang = BarangModel::find($id);
        $kategori = KategoriModel::select('kategori_id', 'kategori_nama')->get();
        return view('barang.edit_ajax', ['barang' => $barang, 'kategori' => $kategori]);
    }

    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kategori_id' => ['required', 'integer', 'exists:m_kategori,kategori_id'],
                'barang_kode' => ['required', 'min:3', 'max:20', 'unique:m_barang,barang_kode, '. $id .',barang_id'],
                'barang_nama' => ['required', 'string', 'max:100'],
                'harga_beli' => ['required', 'numeric'],
                'harga_jual' => ['required', 'numeric'],

            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status'   => false,
                    'message'  => 'Validasi gagal.',
                    'msgField' => $validator->errors(),
                ]);
            }

            $barang = BarangModel::find($id);
            if ($barang) {
                $barang->update($request->all());

                return response()->json([
                    'status'  => true,
                    'message' => 'Data barang berhasil diupdate.',
                ]);
            }

            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan.',
            ]);
        }

        return redirect('/');
    }

    public function confirm_ajax(string $id) {
        $barang = BarangModel::find($id);

        return view('barang.confirm_ajax', ['barang' => $barang]);
    }

    public function delete_ajax(Request $request, $id)
    {
    // cek apakah request dari ajax
    if ($request->ajax() || $request->wantsJson()) {
        try {
            $barang = BarangModel::find($id);
            if ($barang) {
                $barang->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Data gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini'
            ]);
        }
    }

    return redirect('/');
    }

    public function import(){
        return view('barang.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {

            $rules = [
                // Validasi file harus xlsx, maksimal 1MB
                'file_barang' => ['required', 'mimes:xlsx', 'max:1024']
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status'   => false,
                    'message'  => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            // Ambil file dari request
            $file = $request->file('file_barang');

            // Membuat reader untuk file excel dengan format Xlsx
            $reader = IOFactory::createReader('Xlsx');
            $reader->setReadDataOnly(true); // Hanya membaca data saja

            // Load file excel
            $spreadsheet = $reader->load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet(); // Ambil sheet yang aktif

            // Ambil data excel sebagai array
            $data = $sheet->toArray(null, false, true, true);
            $insert = [];

            // Pastikan data memiliki lebih dari 1 baris (header + data)
            if (count($data) > 1) {
                foreach ($data as $baris => $value) {
                    if ($baris > 1) { // Baris pertama adalah header, jadi lewati
                        $insert[] = [
                            'kategori_id' => $value['A'],
                            'barang_kode' => $value['B'],
                            'barang_nama' => $value['C'],
                            'harga_beli'  => $value['D'],
                            'harga_jual'  => $value['E'],
                            'created_at'  => now(),
                        ];
                    }
                }

                if (count($insert) > 0) {
                    // Insert data ke database, jika data sudah ada, maka diabaikan
                    BarangModel::insertOrIgnore($insert);
                }

                return response()->json([
                    'status'  => true,
                    'message' => 'Data berhasil diimport'
                ]);
            } else {
                return response()->json([
                    'status'  => false,
                    'message' => 'Tidak ada data yang diimport'
                ]);
            }
        }

        return redirect('/');
    }

}