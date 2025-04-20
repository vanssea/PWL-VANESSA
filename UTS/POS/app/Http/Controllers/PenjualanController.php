<?php

namespace App\Http\Controllers;

use App\Models\PenjualanModel;
use App\Models\BarangModel;
use App\Models\UserModel;
use App\Models\PenjualanDetailModel;
use App\Models\StokModel;
use App\Http\Controllers\Date;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\Penjualan;

class PenjualanController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Penjualan',
            'list'  => ['Home', 'Penjualan']
        ];

        $page = (object) [
            'title' => 'Data Penjualan Barang'
        ];

        $activeMenu = 'penjualan';
        $user = \App\Models\UserModel::select('user_id', 'username')->get();
        return view('penjualan.index', compact('breadcrumb', 'page', 'activeMenu', 'user'));
    }

    public function list(Request $request)
    {
        $penjualan = PenjualanModel::with(['user'])->get(); // <== ini penting
    
        return DataTables::of($penjualan)
        ->addColumn('aksi', function ($penjualan) {
            $btn  = '<button onclick="modalAction(\'' . url('/penjualan/' . $penjualan->penjualan_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
            $btn .= '<a href="' . url('/penjualan/' . $penjualan->penjualan_id . '/cetak-struk') . '" target="_blank" class="btn btn-success btn-sm"><i class="fas fa-print"></i> Cetak Struk</a> ';            
            $btn .= '<button onclick="modalAction(\''.url('/penjualan/' . $penjualan->penjualan_id . '/delete_ajax').'\')" class="btn btn-danger btn-sm mr-1">Hapus</button>';
            return $btn;        
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }
    

    public function create_ajax()
{
    // Ambil barang yang stoknya masih tersedia (> 0)
    $barang = BarangModel::whereIn('barang_id', function ($query) {
        $query->select('barang_id')
            ->from('t_stok')
            ->where('stok_jumlah', '>', 0);
    })->get();

    // Ambil user yang sedang login
    $user = Auth::user();

    // Generate kode penjualan otomatis
    $lastId = PenjualanModel::orderBy('penjualan_id', 'desc')->value('penjualan_id');
    $kode = 'TRX0' . ($lastId + 1);

    // Return view dengan data
    return view('penjualan.create_ajax')
        ->with('barang', $barang)
        ->with('user', $user)
        ->with('kode', $kode);
}

public function store_ajax(Request $request)
{
    // Proses hanya jika request adalah AJAX
    if ($request->ajax() || $request->wantsJson()) {
        $rules = [
            'user_id' => 'required|exists:m_user,user_id',
            'pembeli' => 'required|max:40',
            'penjualan_kode' => 'required|max:20',
            'penjualan_tanggal' => 'required|date',
            'barang_id' => 'required|array',
            'harga' => 'required|array',
            'jumlah' => 'required|array'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi Gagal',
                'msgField' => $validator->errors()
            ]);
        }

        try {
            DB::beginTransaction();

            // Simpan ke tabel penjualan utama
            $penjualan = PenjualanModel::create([
                'user_id' => $request->user_id,
                'pembeli' => $request->pembeli,
                'penjualan_kode' => $request->penjualan_kode,
                'penjualan_tanggal' => $request->penjualan_tanggal,
            ]);

            // Loop simpan detail dan kurangi stok
            foreach ($request->barang_id as $i => $barang_id) {
                PenjualanDetailModel::create([
                    'penjualan_id' => $penjualan->penjualan_id,
                    'barang_id' => $barang_id,
                    'harga' => $request->harga[$i],
                    'jumlah' => $request->jumlah[$i],
                ]);

                $stok = StokModel::where('barang_id', $barang_id)->first();

                if ($stok) {
                    if ($stok->stok_jumlah >= $request->jumlah[$i]) {
                        $stok->stok_jumlah -= $request->jumlah[$i];
                        $stok->save();
                    } else {
                        DB::rollBack();
                        return response()->json([
                            'status' => false,
                            'message' => 'Stok barang ' . $stok->barang->barang_nama . ' tidak mencukupi'
                        ]);
                    }
                } else {
                    DB::rollBack();
                    return response()->json([
                        'status' => false,
                        'message' => 'Stok untuk barang tidak ditemukan'
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Data Penjualan dan Detail berhasil disimpan'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat menyimpan: ' . $e->getMessage()
            ]);
        }
    }

    return redirect('/');
}


public function show_ajax(string $id)
{
    $penjualan = PenjualanModel::with(['user', 'penjualanDetail.barang'])->find($id);
    return view('penjualan.show_ajax', ['penjualan' => $penjualan]);
}



    public function edit_ajax(string $id)
    {
        $penjualan = PenjualanModel::find($id);
        $barang = BarangModel::select('barang_id', 'barang_nama')->get();
        $user = UserModel::select('user_id', 'nama')->get();
        return view('penjualan.edit_ajax', compact('penjualan', 'barang', 'user'));
    }

    public function update_ajax(Request $request, string $id)
    {
        $rules = [
            'barang_id' => 'required|integer',
            'user_id' => 'required|integer',
            'penjualan_tanggal' => 'required|date',
            'jumlah_terjual' => 'required|integer|min:1',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal.',
                'msgField' => $validator->errors()
            ]);
        }

        $penjualan = PenjualanModel::find($id);
        if ($penjualan) {
            $penjualan->update($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data berhasil diupdate'
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Data tidak ditemukan'
        ]);
    }

    public function import()
    {
        return view('penjualan.import');
    }


    public function confirm_ajax(string $id)
    {
        $penjualan = PenjualanModel::find($id);

        return view('penjualan.confirm_ajax', ['penjualan' => $penjualan]);
    }

    public function delete_ajax(Request $request, $id){
        if ($request->ajax() || $request->wantsJson()) {
            $penjualan = PenjualanModel::find($id);
            if (!$penjualan) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
    
            try {
                $penjualan->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            } catch (\Illuminate\Database\QueryException $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini'
                ]);
            }
        }
    
        return redirect('/');
    }


    public function export_pdf()
    {
        $penjualan = \App\Models\PenjualanModel::with(['user', 'penjualanDetail.barang'])
            ->orderBy('penjualan_tanggal', 'desc')
            ->get();

        $pdf = Pdf::loadView('penjualan.export_pdf', ['penjualan' => $penjualan]);
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOption('isRemoteEnabled', true);
        $pdf->render();

        return $pdf->stream('Data Penjualan ' . date('Y-m-d H:i:s') . '.pdf');
    }



public function export_excel()
{
    // Ambil data penjualan lengkap dengan relasi user
    $penjualan = PenjualanModel::select(
        'penjualan_id',
        'user_id',
        'pembeli',
        'penjualan_kode',
        'penjualan_tanggal',
        
    )
    ->with('user') // pastikan ada relasi 'user' di model Penjualan
    ->orderBy('penjualan_tanggal', 'desc')
    ->get();

    // Load library Excel
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Header Excel
    $sheet->setCellValue('A1', 'No');
    $sheet->setCellValue('B1', 'Kode Penjualan');
    $sheet->setCellValue('C1', 'Tanggal');
    $sheet->setCellValue('D1', 'Pembeli');
    $sheet->setCellValue('E1', 'Pengguna');

    // Format header bold
    $sheet->getStyle('A1:E1')->getFont()->setBold(true);

    // Isi data
    $no = 1;
    $baris = 2;
    foreach ($penjualan as $value) {
        $sheet->setCellValue('A' . $baris, $no);
        $sheet->setCellValue('B' . $baris, $value->penjualan_kode);
        $sheet->setCellValue('C' . $baris, $value->penjualan_tanggal);
        $sheet->setCellValue('D' . $baris, $value->pembeli );
        $sheet->setCellValue('E' . $baris, $value->user->nama ?? '-');
        $no++;
        $baris++;
    }

    // Otomatis atur lebar kolom
    foreach (range('A', 'E') as $columnID) {
        $sheet->getColumnDimension($columnID)->setAutoSize(true);
    }

    // Judul sheet
    $sheet->setTitle('Data Penjualan');

    // Siapkan file untuk diunduh
    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $filename = 'Data_Penjualan_' . date('Y-m-d_H-i-s') . '.xlsx';

    // Header browser untuk download
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Cache-Control: max-age=0');
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
    header('Cache-Control: cache, must-revalidate');
    header('Pragma: public');

    // Outputkan file
    $writer->save('php://output');
    exit;
}

public function cetakStruk($id)
{
    $penjualan = \App\Models\PenjualanModel::with(['penjualanDetail.barang', 'user'])->find($id);

    if (!$penjualan) {
        return redirect()->back()->with('error', 'Data penjualan tidak ditemukan.');
    }

    $pdf = Pdf::loadView('penjualan.cetak_struk', compact('penjualan'))
    ->setPaper([0, 0, 226.77, 1000], 'portrait'); // 80mm = 226.77pt
return $pdf->stream('Struk-Penjualan-' . $penjualan->penjualan_kode . '.pdf');
}



}