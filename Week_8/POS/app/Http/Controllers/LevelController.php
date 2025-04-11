<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class LevelController extends Controller
{
    public function index() {
        $level = LevelModel::all();
       
        $breadcrumb = (Object) [    
            'title' => 'Daftar Level',
            'list'  => ['Home', 'Level']
        ];

        $page = (object) [
            'title' => 'Daftar Level user yang terdaftar dalam sistem'
        ];

        $activeMenu = 'level';

        return view('level.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request) {
        $level = LevelModel::select('level_id', 'level_kode', 'level_nama');

        if ($request->level_id) {
            $level->where('level_id', $request->level_id);
        }
    
        return DataTables::of($level)
            ->addIndexColumn()
            ->addColumn('aksi', function ($level) {
                // $btn = '<a href="'.url('/level/' .$level->level_id).'" class="btn btn-info btn-sm">Detail</a> ';
                // $btn .= '<a href="'.url('/level/' .$level->level_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';
                // $btn .= '<form class="d-inline-block" method="POST" action="'.url('/level/'.$level->level_id).'">'
                //      . csrf_field() . method_field('DELETE')
                //      . '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah anda yakin menghapus data ini?\');">Hapus</button></form>';

                $btn = '<button onclick="modalAction(\''.url('/level/' . $level->level_id . '/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/level/' . $level->level_id . '/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/level/' . $level->level_id . '/delete_ajax').'\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn; 
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }
    
    public function create() {
        $breadcrumb = (object) [
            'title' => 'Tambah Level',
            'list'  => ['Home', 'Level', 'Tambah'] 
        ];

        $page = (object) [
            'title' => 'Tambah Level baru'
        ];

        $activeMenu = 'level';

        return view('level.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request) {
        $request->validate([
            'level_kode'  => 'required|string|max:3',
            'level_nama'  => 'required|string',
        ]);

        LevelModel::create([
            'level_kode'  => $request->level_kode,
            'level_nama'  => $request->level_nama,
        ]);

        return redirect('/level')->with('success', 'Data level berhasil disimpan');
    }

    public function create_ajax() {
        $level = LevelModel::all();

        return view('level.create_ajax', ['level' => $level]);
    }

    public function store_ajax(Request $request) {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_kode' => 'required|string|max:3|regex:/^[A-Z]+$/',
                'level_nama' => 'required|string|min:3|max:50|regex:/^[a-zA-Z\s]+$/'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status'   => false, 
                    'message'  =>'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            LevelModel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data Level berhasil disimpan'
            ]);
        }
        redirect('/');
    }

    public function show(string $id) {
        $level = LevelModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Level',
            'list'  => ['Home', 'Level', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail level'
        ];
        
        $activeMenu = 'level';

        return view('level.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    public function edit(string $id) {
        $level = LevelModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Edit Level',
            'list'  => ['Home', 'Level', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit level'
        ];

        $activeMenu = 'level';

        return view('level.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    public function edit_ajax(string $id) {
        $level = LevelModel::find($id);

        return view('level.edit_ajax', ['level' => $level]); 
    }

    public function update(Request $request, string $id) {

        $request->validate([
            'level_kode'    => 'required|max:3|unique:m_level,level_kode',
            'level_nama'    => 'required|string'
        ]);

        LevelModel::find($id)->update([
            'level_kode'    => $request->level_kode,
            'level_nama'    => $request->level_nama
        ]);

        return redirect('/level')->with('succes', 'Data level berhasil diubah');
    }

    public function update_ajax(Request $request, $id) {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_kode' => 'required|string|max:3|regex:/^[A-Z]+$/',
                'level_nama' => 'required|string|min:3|max:50|regex:/^[a-zA-Z\s]+$/'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status'   => false,
                    'message'  => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            $check = LevelModel::find($id);
            if ($check) {
                $check->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate'
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

    public function destroy(string $id) {
        $check = LevelModel::find($id);
        if (!$check) {
            return redirect('/level')->with('error', 'Data level tidak ditemukan');
        }

        try {
            LevelModel::destroy($id);

            return redirect('/level')->with('success', 'Data level berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/level')->with('error', 'Data level gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    public function confirm_ajax(string $id) {
        $level = LevelModel::find($id);

        return view('level.confirm_ajax', ['level' => $level]);
    }

    public function delete_ajax(Request $request, $id)
    {
    // cek apakah request dari ajax
    if ($request->ajax() || $request->wantsJson()) {
        try {
            $level = LevelModel::find($id);
            if ($level) {
                $level->delete();
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
        return view('level.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {

            $rules = [
                // Validasi file harus xlsx, maksimal 1MB
                'file_level' => ['required', 'mimes:xlsx', 'max:1024']
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
            $file = $request->file('file_level');

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
                            'level_kode' => $value['A'],
                            'level_nama' => $value['B'],
                            'created_at'  => now(),
                        ];
                    }
                }

                if (count($insert) > 0) {
                    // Insert data ke database, jika data sudah ada, maka diabaikan
                    LevelModel::insertOrIgnore($insert);
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
          $level = LevelModel::select(
              'level_kode',
              'level_nama',
          )
          ->orderBy('level_id')
          ->get();
  
          //load library excel
          $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
          $sheet = $spreadsheet->getActiveSheet(); //ambil sheet aktif
  
          $sheet->setCellValue('A1', 'No');
          $sheet->setCellValue('B1', 'Kode level');
          $sheet->setCellValue('C1', 'Nama level');
  
          $sheet->getStyle('A1:C1')->getFont()->setBold(true); // Set header bold
  
          $no = 1; //Nomor value dimulai dari 1
          $baris = 2; //Baris value dimulai dari 2
          foreach ($level as $key => $value) {
              $sheet->setCellValue('A' . $baris, $no);
              $sheet->setCellValue('B' . $baris, $value->level_kode);
              $sheet->setCellValue('C' . $baris, $value->level_nama);
              $no++;
              $baris++;
          }
  
          foreach (range('A', 'C') as $columnID) {
              $sheet->getColumnDimension($columnID)->setAutoSize(true); //set auto size untuk kolom
          }
  
          $sheet->setTitle('Data Level'); //set judul sheet
          
          $writer = IOFactory ::createWriter($spreadsheet, 'Xlsx'); //set writer
          $filename = 'Data_level_' . date('Y-m-d_H-i-s') . '.xlsx'; //set nama file
  
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
