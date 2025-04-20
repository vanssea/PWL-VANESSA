@empty($penjualan)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-danger shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="fas fa-exclamation-triangle mr-2"></i>Kesalahan</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Tutup">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <div class="alert alert-danger mb-4">
                    <h5><i class="icon fas fa-ban"></i> Data Tidak Ditemukan</h5>
                    Maaf, data penjualan yang Anda cari tidak tersedia.
                </div>
                <a href="{{ url('/penjualan') }}" class="btn btn-warning">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                </a>
            </div>
        </div>
    </div>
@else
    <div id="modal-master" class="modal-dialog modal-xl" role="document">
        <div class="modal-content shadow-sm">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-receipt mr-2"></i>Detail Data Penjualan</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Tutup">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Informasi Umum Penjualan -->
                <table class="table table-sm table-borderless mb-4">
                    <tbody style="font-size: 0.95rem;">
                        <tr>
                            <th class="text-muted w-30">ID Penjualan</th>
                            <td>{{ $penjualan->penjualan_id }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Kode Penjualan</th>
                            <td>{{ $penjualan->penjualan_kode }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Tanggal</th>
                            <td>{{ \Carbon\Carbon::parse($penjualan->penjualan_tanggal)->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Pengguna</th>
                            <td>{{ $penjualan->user->nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Dibuat pada</th>
                            <td>{{ $penjualan->created_at ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Diperbarui pada</th>
                            <td>{{ $penjualan->updated_at ?? '-' }}</td>
                        </tr>
                    </tbody>
                </table>

                <!-- Detail Barang Terjual -->
                <h6 class="text-secondary font-weight-bold mb-2">Detail Barang Terjual:</h6>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-striped">
                        <thead class="thead-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($penjualan->penjualanDetail as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->barang->barang_nama ?? '-' }}</td>
                                <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                <td>{{ $item->jumlah }}</td>
                                <td>Rp {{ number_format($item->harga * $item->jumlah, 0, ',', '.') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Tidak ada data detail penjualan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                        @if($penjualan->penjualanDetail->count() > 0)
                        <tfoot>
                            <tr class="bg-light font-weight-bold">
                                <th colspan="4" class="text-right">Total</th>
                                <th>Rp {{ number_format($penjualan->penjualanDetail->sum(fn($d) => $d->harga * $d->jumlah), 0, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                        @endif
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-outline-secondary">
                    <i class="fas fa-times mr-1"></i> Tutup
                </button>
            </div>
        </div>
    </div>
@endempty
