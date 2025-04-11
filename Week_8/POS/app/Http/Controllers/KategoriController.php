<?php

namespace App\Http\Controllers;

use App\Models\KategoriModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = KategoriModel::all();

        $breadcrumb = (object) [
            'title' => 'Daftar Kategori',
            'list'  => ['Home', 'Kategori']
        ];

        $page = (object) [
            'title' => 'Daftar Kategori yang terdaftar dalam sistem'
        ];

        $activeMenu = 'kategori';

        return view('kategori.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $kategori = KategoriModel::select('kategori_id', 'kategori_kode', 'kategori_nama');

        if ($request->kategori_id) {
            $kategori->where('kategori_id', $request->kategori_id);
        }

        return DataTables::of($kategori)
            ->addIndexColumn()
            ->addColumn('aksi', function ($kategori) {
                // $btn = '<a href="' . url('/kategori/' . $kategori->kategori_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                // $btn .= '<a href="' . url('/kategori/' . $kategori->kategori_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                // $btn .= '<form class="d-inline-block" method="POST" action="' . url('/kategori/' . $kategori->kategori_id) . '">'
                //     . csrf_field() . method_field('DELETE')
                //     . '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah anda yakin menghapus data ini?\');">Hapus</button></form>';

                $btn = '<button onclick="modalAction(\''.url('/kategori/' . $kategori->kategori_id . '/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/kategori/' . $kategori->kategori_id . '/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/kategori/' . $kategori->kategori_id . '/delete_ajax').'\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah kategori',
            'list'  => ['Home', 'kategori', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah kategori baru'
        ];

        $activeMenu = 'kategori';

        return view('kategori.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function create_ajax()
     {
         return view('kategori.create_ajax');
     }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_kode'  => 'required|string',
            'kategori_nama'  => 'required|string',
        ]);

        KategoriModel::create([
            'kategori_kode'  => $request->kategori_kode,
            'kategori_nama'  => $request->kategori_nama,
        ]);

        return redirect('/kategori')->with('success', 'Data kategori berhasil disimpan');
    }

    public function store_ajax(Request $request)
     {
         // cek apakah request berupa ajax
         if ($request->ajax() || $request->wantsJson()) {
             $rules = [
             'kategori_kode' => 'required|string|max:10|unique:m_kategori,kategori_kode',
             'kategori_nama' => 'required|string|max:100',
             ];
 
 
             $validator = Validator::make($request->all(), $rules);
 
             if ($validator->fails()) {
                 return response()->json([
                     'status' => false, // response status, false: error/gagal, true: berhasil
                     'message' => 'Validasi Gagal',
                     'msgField' => $validator->errors() // pesan error validasi
                 ]);
             }
 
             KategoriModel::create($request->all());
 
             return response()->json([
                 'status' => true,
                 'message' => 'Data kategori berhasil disimpan'
             ]);
         }
 
         redirect('/');
     }

    public function show(string $id)
    {
        $kategori = KategoriModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail kategori',
            'list'  => ['Home', 'kategori', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail kategori'
        ];

        $activeMenu = 'kategori';

        return view('kategori.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

    public function edit(string $id)
    {
        $kategori = KategoriModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Edit kategori',
            'list'  => ['Home', 'kategori', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit kategori'
        ];

        $activeMenu = 'kategori';

        return view('kategori.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

    public function edit_ajax(string $id)
     {
         $kategori = KategoriModel::find($id);
         return view('kategori.edit_ajax', ['kategori' => $kategori]);
     }

    public function update(Request $request, string $id)
    {

        $request->validate([
            'kategori_kode'    => 'required|string|max:3|unique:m_kategori,kategori_kode',
            'kategori_nama'    => 'required|string',
        ]);

        KategoriModel::find($id)->update([
            'kategori_kode'    => $request->kategori_kode,
            'kategori_nama'    => $request->kategori_nama
        ]);

        return redirect('/kategori')->with('succes', 'Data kategori berhasil diubah');
    }
    
    public function update_ajax(Request $request, string $id)
     {
         // cek apakah request berupa ajax
         if ($request->ajax() || $request->wantsJson()) {
             $rules = [
             'kategori_kode' => 'required|string|max:10|unique:m_kategori,kategori_kode,'.$id.',kategori_id',
             'kategori_nama' => 'required|string|max:100',
             ];
 
             $validator = Validator::make($request->all(), $rules);
 
             if ($validator->fails()) {
                 return response()->json([
                     'status' => false, // response status, false: error/gagal, true: berhasil
                     'message' => 'Validasi Gagal',
                     'msgField' => $validator->errors() // pesan error validasi
                 ]);
             }
 
             KategoriModel::find($id)->update($request->all());
 
             return response()->json([
                 'status' => true,
                 'message' => 'Data kategori berhasil diubah'
             ]);
         }
 
         redirect('/');
     }

     public function confirm_ajax(string $id)
    {
        $kategori = KategoriModel::find($id);

        return view('kategori.confirm_ajax', ['kategori' => $kategori]);
    }

    public function destroy(string $id)
    {
        $check = KategoriModel::find($id);
        if (!$check) {
            return redirect('/kategori')->with('error', 'Data kategori tidak ditemukan');
        }

        try {
            KategoriModel::destroy($id);

            return redirect('/kategori')->with('success', 'Data kategori berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/kategori')->with('error', 'Data kategori gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    public function delete_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $kategori = KategoriModel::find($id);
            if ($kategori) {
                $kategori->delete();
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
        }
        return redirect('/');
    }

    public function import(){
        return view('kategori.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {

            $rules = [
                // Validasi file harus xlsx, maksimal 1MB
                'file_kategori' => ['required', 'mimes:xlsx', 'max:1024']
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
            $file = $request->file('file_kategori');

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
                            'kategori_kode' => $value['A'],
                            'kategori_nama' => $value['B'],
                            'created_at'  => now(),
                        ];
                    }
                }

                if (count($insert) > 0) {
                    // Insert data ke database, jika data sudah ada, maka diabaikan
                    KategoriModel::insertOrIgnore($insert);
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

    public function export_excel()
      {
          //Ambil value barang yang akan diexport
          $kategori = KategoriModel::select(
              'kategori_kode',
              'kategori_nama',
          )
          ->orderBy('kategori_id')
          ->get();
  
          //load library excel
          $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
          $sheet = $spreadsheet->getActiveSheet(); //ambil sheet aktif
  
          $sheet->setCellValue('A1', 'No');
          $sheet->setCellValue('B1', 'Kode kategori');
          $sheet->setCellValue('C1', 'Nama kategori');
  
          $sheet->getStyle('A1:C1')->getFont()->setBold(true); // Set header bold
  
          $no = 1; //Nomor value dimulai dari 1
          $baris = 2; //Baris value dimulai dari 2
          foreach ($kategori as $key => $value) {
              $sheet->setCellValue('A' . $baris, $no);
              $sheet->setCellValue('B' . $baris, $value->kategori_kode);
              $sheet->setCellValue('C' . $baris, $value->kategori_nama);
              $no++;
              $baris++;
          }
  
          foreach (range('A', 'C') as $columnID) {
              $sheet->getColumnDimension($columnID)->setAutoSize(true); //set auto size untuk kolom
          }
  
          $sheet->setTitle('Data Kategori'); //set judul sheet
          
          $writer = IOFactory ::createWriter($spreadsheet, 'Xlsx'); //set writer
          $filename = 'Data_Kategori_' . date('Y-m-d_H-i-s') . '.xlsx'; //set nama file
  
          header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
          header('Content-Disposition: attachment; filename="' . $filename . '"');
          header('Cache-Control: max-age=0');
          header('Cache-Control: max-age=1');
          header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
          header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
          header('Cache-Control: cache, must-revalidate');
          header('Pragma: public');
  
          $writer->save('php://output'); //simpan file ke output
          exit; //keluar dari scriptA
      }

}

