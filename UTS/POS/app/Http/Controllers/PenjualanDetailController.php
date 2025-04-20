<?php

namespace App\Http\Controllers;

use App\Models\PenjualanModel;
use App\Models\BarangModel;
use App\Models\PenjualanDetailModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;


class PenjualanDetailController extends Controller
{


  public function create($penjualan_id)
  {
    $breadcrumb = (object) [
      'title' => 'Tambah Detail Penjualan',
      'list' => ['Home', 'Penjualan', 'Detail', 'Tambah']
    ];

    $page = (object) [
      'title' => 'Tambah detail penjualan'
    ];

    $activeMenu = 'penjualan';

    $penjualan = PenjualanModel::findOrFail($penjualan_id);
    $barang = BarangModel::all();

    return view('penjualandetail.create', compact('breadcrumb', 'page', 'activeMenu', 'penjualan', 'barang'));
  }

  public function store(Request $request, $penjualan_id)
  {
    $request->validate([
      'barang_id' => 'required|integer',
      'jumlah' => 'required|integer|min:1',
      'harga' => 'required|numeric|min:0',
    ]);

    $request['penjualan_id'] = $penjualan_id;
    PenjualanDetailModel::create($request->all());

    return redirect("/penjualan/$penjualan_id")->with('success', 'Detail penjualan berhasil ditambahkan');
  }

  public function edit($penjualan_id, $id)
  {
    $detail = PenjualanDetailModel::findOrFail($id);
    $barang = BarangModel::all();
    $penjualan = PenjualanModel::findOrFail($penjualan_id);

    $breadcrumb = (object) [
      'title' => 'Edit Detail Penjualan',
      'list' => ['Home', 'Penjualan', 'Detail', 'Edit']
    ];

    $page = (object) [
      'title' => 'Edit detail penjualan'
    ];

    $activeMenu = 'penjualan';

    return view('penjualandetail.edit', compact('breadcrumb', 'page', 'activeMenu', 'penjualan', 'barang', 'detail'));
  }

  public function update(Request $request, $penjualan_id, $id)
  {
    $request->validate([
      'barang_id' => 'required|integer',
      'jumlah' => 'required|integer|min:1',
      'harga' => 'required|numeric|min:0',
    ]);

    $detail = PenjualanDetailModel::findOrFail($id);
    $detail->update($request->all());

    return redirect("/penjualan/$penjualan_id")->with('success', 'Detail penjualan berhasil diubah');
  }

  public function destroy($penjualan_id, $id)
  {
    $check = PenjualanDetailModel::find($id);

    if (!$check) {
      return redirect("/penjualan/$penjualan_id")->with('error', 'Data detail penjualan tidak ditemukan');
    }

    try {
      PenjualanDetailModel::destroy($id);
      return redirect("/penjualan/$penjualan_id")->with('success', 'Detail penjualan berhasil dihapus');
    } catch (\Illuminate\Database\QueryException $e) {
      return redirect("/penjualan/$penjualan_id")->with('error', 'Gagal menghapus detail karena masih terhubung dengan data lain');
    }
}
}
    