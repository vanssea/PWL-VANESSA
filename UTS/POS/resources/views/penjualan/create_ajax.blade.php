<form action="{{ url('/penjualan/ajax') }}" method="POST" id="form-tambah">
    @csrf
    <div class="modal-dialog modal-xl" role="document" id="modal-master">
        <div class="modal-content shadow-lg rounded">
            <div class="modal-header bg-primary text-white">
                <h4 class="modal-title">
                    <i class="fa fa-plus-circle mr-2"></i> Form Entri Penjualan Baru
                </h4>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body p-4 bg-light">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label><strong>Anda Sebagai:</strong></label>
                        <div class="form-control-plaintext">{{ $user->nama }} ({{ $user->level->level_nama }})</div>
                        <input type="hidden" name="user_id" value="{{ $user->user_id }}">
                        <small id="error-user-id" class="text-danger form-text"></small>
                    </div>
                    <div class="col-md-6">
                        <label><strong>Pembeli</strong></label>
                        <input type="text" name="pembeli" id="pembeli" class="form-control" placeholder="Nama Pembeli" required>
                        <small id="error-pembeli" class="text-danger form-text"></small>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label><strong>Kode Penjualan</strong></label>
                        <input type="text" name="penjualan_kode" id="penjualan_kode" class="form-control bg-light" value="{{ old('penjualan_kode', $kode) }}" readonly>
                        <small id="error-penjualan-kode" class="text-danger form-text"></small>
                    </div>
                    <div class="col-md-6">
                        <label><strong>Tanggal Penjualan</strong></label>
                        <input type="datetime-local" name="penjualan_tanggal" id="penjualan_tanggal" class="form-control" required>
                        <small id="error-penjualan-tanggal" class="text-danger form-text"></small>
                    </div>
                </div>

                <hr>
                <h5 class="text-primary">Detail Barang</h5>

                <div id="detail-container">
                    <div class="form-row detail-item mb-3">
                        <div class="col-md-4">
                            <label>Barang</label>
                            <select name="barang_id[]" class="form-control">
                                <option value="">- Pilih Barang -</option>
                                @foreach ($barang as $b)
                                    <option value="{{ $b->barang_id }}" data-harga="{{ $b->harga_jual }}">
                                        {{ $b->barang_nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label>Harga</label>
                            <input type="number" name="harga[]" class="form-control bg-light" readonly required>
                        </div>
                        <div class="col-md-2">
                            <label>Jumlah</label>
                            <input type="number" name="jumlah[]" class="form-control" required>
                        </div>
                        <div class="col-md-2">
                            <label>Subtotal</label>
                            <input type="text" name="subtotal[]" class="form-control subtotal bg-light" readonly>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="button" class="btn btn-sm btn-danger remove-detail w-100">Hapus</button>
                        </div>
                    </div>
                </div>

                <div class="text-right my-3">
                    <button type="button" id="btn-tambah-detail" class="btn btn-outline-primary btn-block">
                        + Tambah Barang
                    </button>
                </div>

                <div class="form-group text-right">
                    <label class="font-weight-bold text-success">Total Keseluruhan</label>
                    <input type="text" id="totalKeseluruhan" class="form-control font-weight-bold text-right bg-white" readonly>
                </div>
            </div>

            <div class="modal-footer bg-light">
                <button type="button" data-dismiss="modal" class="btn btn-secondary">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Penjualan</button>
            </div>
        </div>
    </div>
</form>

<script>
    $('#form-tambah').on('submit', function (e) {
    e.preventDefault(); // stop submit biasa

    $.ajax({
        url: "{{ url('/penjualan/ajax') }}",
        method: "POST",
        data: $(this).serialize(),
        success: function (res) {
            if (res.status) {
                Swal.fire({
                    title: 'Berhasil!',
                    text: res.message,
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    location.reload(); // reload atau redirect
                });
            } else {
                Swal.fire({
                    title: 'Gagal',
                    text: res.message,
                    icon: 'error'
                });

                // Tampilkan error validasi jika ada
                if (res.msgField) {
                    for (const [key, val] of Object.entries(res.msgField)) {
                        $('#error-' + key.replace('.', '-')).text(val[0]);
                    }
                }
            }
        },
        error: function (xhr) {
            Swal.fire({
                title: 'Oops!',
                text: 'Terjadi kesalahan server.',
                icon: 'error'
            });
            console.error(xhr.responseText);
        }
    });
});

</script>


<script>
    $(document).ready(function () {
        // Fungsi saat ganti barang
        $(document).on('change', 'select[name="barang_id[]"]', function () {
            var selected = $(this).find(':selected');
            var harga = selected.data('harga') || 0;
            var row = $(this).closest('.detail-item');
    
            row.find('input[name="harga[]"]').val(harga);
            hitungSubtotal(row);
            hitungTotal();
        });
    
        // Fungsi saat jumlah diubah
        $(document).on('input', 'input[name="jumlah[]"]', function () {
            var row = $(this).closest('.detail-item');
            hitungSubtotal(row);
            hitungTotal();
        });
    
        // Fungsi tambah baris detail
        $('#btn-tambah-detail').click(function () {
            var detailItem = $('.detail-item:first').clone();
            detailItem.find('select').val('');
            detailItem.find('input').val('');
            $('#detail-container').append(detailItem);
        });
    
        // Fungsi hapus baris detail
        $(document).on('click', '.remove-detail', function () {
            if ($('.detail-item').length > 1) {
                $(this).closest('.detail-item').remove();
                hitungTotal();
            }
        });
    
        function hitungSubtotal(row) {
            var harga = parseFloat(row.find('input[name="harga[]"]').val()) || 0;
            var jumlah = parseFloat(row.find('input[name="jumlah[]"]').val()) || 0;
            var subtotal = harga * jumlah;
            row.find('.subtotal').val(subtotal.toLocaleString());
        }
    
        function hitungTotal() {
            var total = 0;
            $('.subtotal').each(function () {
                var val = $(this).val().replace(/,/g, '') || 0;
                total += parseFloat(val);
            });
            $('#totalKeseluruhan').val(total.toLocaleString());
        }
    });
    </script>
    