<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: monospace;
            font-size: 10px;
            margin: 0;
            padding: 8px;
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-left { text-align: left; }

        .header-title {
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 6px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 6px;
        }

        th, td {
            padding: 3px 0;
        }

        .summary-table th {
            width: 40%;
            text-align: left;
        }

        .items-table thead th {
            border-top: 1px dashed #000;
            border-bottom: 1px dashed #000;
            padding-top: 4px;
            padding-bottom: 4px;
        }

        .items-table tfoot th {
            border-top: 1px dashed #000;
            padding-top: 4px;
        }

        .footer {
            text-align: center;
            font-size: 9px;
            margin-top: 10px;
        }
    </style>
</head>
<body>

    <div class="text-center header-title">TOKO SEKAWAN</div>
    <div class="text-center header-title">Jl. Kembang Turi No. 40 <br>
    Telp. 085812431350</div>

    <table class="summary-table">
        <tr>
            <th>Kode</th>
            <td>: {{ $penjualan->penjualan_kode }}</td>
        </tr>
        <tr>
            <th>Tanggal</th>
            <td>: {{ \Carbon\Carbon::parse($penjualan->penjualan_tanggal)->format('d-m-Y H:i') }}</td>
        </tr>
        <tr>
            <th>Kasir</th>
            <td>: {{ $penjualan->user->nama ?? '-' }}</td>
        </tr>
        <tr>
            <th>Pembeli</th>
            <td>: {{ $penjualan->pembeli ?? '-' }}</td>
        </tr>
        <tr>
            <th>Total Barang</th>
            <td>: {{ $penjualan->penjualanDetail->sum('jumlah') }} item</td>
        </tr>
    </table>

    <table class="items-table">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th>Barang</th>
                <th class="text-center" style="width: 10%;">Qty</th>
                <th class="text-right" style="width: 20%;">Harga</th>
                <th class="text-right" style="width: 25%;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($penjualan->penjualanDetail as $i => $detail)
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td>{{ $detail->barang->barang_nama ?? '-' }}</td>
                    <td class="text-center">{{ $detail->jumlah }}</td>
                    <td class="text-right">Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($detail->harga * $detail->jumlah, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4" class="text-right">Total</th>
                <th class="text-right">
                    Rp {{ number_format($penjualan->penjualanDetail->sum(fn($d) => $d->harga * $d->jumlah), 0, ',', '.') }}
                </th>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <small>Terima kasih telah berbelanja!</small>
    </div>

</body>
</html>
