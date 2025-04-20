@empty($penjualan)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data yang anda cari tidak ditemukan
                </div>
                <a href="{{ url('/penjualan') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
<form action="{{ url('/penjualan/' . $penjualan->penjualan_id . '/update_ajax') }}" method="POST" id="form-edit">
    @csrf
    @method('PUT')
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Data Penjualan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Barang</label>
                    <select name="barang_id" id="barang_id" class="form-control" required>
                        <option value="" disabled>- Pilih Barang -</option>
                        @foreach ($barang as $b)
                            <option value="{{ $b->barang_id }}" {{ $b->barang_id == $penjualan->barang_id ? 'selected' : '' }}>
                                {{ $b->barang_nama }}
                            </option>
                        @endforeach
                    </select>
                    <small id="error-barang_id" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Jumlah</label>
                    <input type="number" name="penjualan_jumlah" id="penjualan_jumlah" class="form-control" value="{{ $penjualan->penjualan_jumlah }}" required>
                    <small id="error-penjualan_jumlah" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Nama User</label>
                    <select name="user_id" id="user_id" class="form-control" required>
                        <option value="" disabled>- Pilih User -</option>
                        @foreach ($user as $u)
                            <option value="{{ $u->user_id }}" {{ $u->user_id == $penjualan->user_id ? 'selected' : '' }}>
                                {{ $u->nama }}
                            </option>
                        @endforeach
                    </select>
                    <small id="error-user_id" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Tanggal Penjualan</label>
                    <input type="datetime-local" name="penjualan_tanggal" id="penjualan_tanggal" class="form-control" value="{{ \Carbon\Carbon::parse($penjualan->penjualan_tanggal)->format('Y-m-d\TH:i') }}" required>
                    <small id="error-penjualan_tanggal" class="error-text form-text text-danger"></small>
                </div>

                {{-- Jika pakai relasi customer --}}
                {{-- 
                <div class="form-group">
                    <label>Customer</label>
                    <select name="customer_id" id="customer_id" class="form-control">
                        <option value="" disabled>- Pilih Customer -</option>
                        @foreach ($customer as $c)
                            <option value="{{ $c->id }}" {{ $c->id == $penjualan->customer_id ? 'selected' : '' }}>
                                {{ $c->nama }}
                            </option>
                        @endforeach
                    </select>
                    <small id="error-customer_id" class="error-text form-text text-danger"></small>
                </div> 
                --}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function () {
        $('#form-edit').validate({
            rules: {
                barang_id: { required: true, number: true },
                penjualan_jumlah: { required: true, number: true },
                user_id: { required: true, number: true },
                penjualan_tanggal: { required: true }
            },
            submitHandler: function (form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function (response) {
                        if (response.status) {
                            $('#myModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });
                            dataPenjualan.ajax.reload();
                        } else {
                            $('.error-text').text('');
                            $.each(response.msgField, function (prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: response.message
                            });
                        }
                    }
                });
                return false;
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>
@endempty
