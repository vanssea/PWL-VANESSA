@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <button onclick="modalAction('{{ url('/penjualan/import') }}')" class="btn btn-sm btn-info">Import Penjualan</button> 
                <a href="{{ url('/penjualan/export_excel') }}" class="btn btn-sm btn-primary"><i class="fa fa-file-excel"></i> Export Penjualan</a>
                <a href="{{ url('/penjualan/export_pdf') }}" class="btn btn-sm btn-warning"><i class="fa fa-file-pdf"></i> Export Penjualan</a> 
                {{-- <a class="btn btn-sm btn-primary mt-1" href="{{ url('penjualan/create') }}">Tambah</a> --}}
                <button onclick="modalAction('{{ url('penjualan/create_ajax') }}')" class="btn btn-sm btn-success mt-1">Tambah Ajax</button>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="filter_user_id">Filter Petugas:</label>
                    <select class="form-control" id="filter_user_id" name="filter_user_id">
                        <option value="">- Semua -</option>
                       @foreach($user as $user)
                            <option value="{{ $user->user_id }}">{{ $user->username }}</option>
                        @endforeach
                    </select>
                    <small class="form-text text-muted">Berdasarkan Kasir penjualan</small>
                </div>
            </div>

            <table class="table table-bordered table-striped table-hover table-sm" id="table_penjualan">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Tanggal</th>
                        <th>Pembeli</th>
                        <th>Kasir</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>

        <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog"
             data-backdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true"></div>
    </div>
@endsection

@push('js')
<script>
    function modalAction(url = '') {
        $('#myModal').load(url, function() {
            $('#myModal').modal('show');
        });
    }

    var dataPenjualan;

    $(document).ready(function() {
        dataPenjualan = $('#table_penjualan').DataTable({
            serverSide: true,
            processing: true,
            ajax: {
                url: "{{ url('penjualan/list') }}",
                type: "POST",
                data: function(d) {
                    d.user_id = $('#filter_user_id').val();
                }
            },
            columns: [
                { data: 'penjualan_id',   className: 'text-center', orderable: false, searchable: false },
                { data: 'penjualan_kode', className: '',           orderable: true,  searchable: true  },
                { data: 'penjualan_tanggal', className: '',        orderable: true,  searchable: false },
                { data: 'pembeli',        className: '',           orderable: true,  searchable: true  },
                { data: 'user.username',  className: '',           orderable: false, searchable: false },
                { data: 'aksi',           className: '',           orderable: false, searchable: false }
            ],
            order: [[2, 'desc']]
        });

        $('#filter_user_id').on('change', function(){
            dataPenjualan.ajax.reload();
        });
    });
</script>
@endpush