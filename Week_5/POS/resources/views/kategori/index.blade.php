@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Kategori')
@section('content_header_title', 'Home')
@section('content_header_subtitle', 'Kategori')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">Manage Kategori</div>
            <a href="{{ route('kategori.create') }}" class="btn btn-primary float-right">
                <i class="fas fa-plus"></i> Add Kategori
            </a>
            <div class="card-body">
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts() }}
    <script>
        $(document).ready(function () {
            $('body').on('click', '.btn-delete', function (e) {
                e.preventDefault();
                let id = $(this).data('id');
                
                if (confirm("Apakah Anda yakin ingin menghapus kategori ini?")) {
                    $.ajax({
                        url: "{{ url('/kategori') }}/" + id,
                        type: "DELETE",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function (response) {
                            alert(response.message);
                            window.LaravelDataTables["dataTableBuilder"].ajax.reload();
                        }
                    });
                }
            });
        });
    </script>
@endpush
