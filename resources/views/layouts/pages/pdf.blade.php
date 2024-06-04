<!DOCTYPE html>
<html>

<head>
    <title>Detail Perhitungan Eclat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            /* Menambahkan layout tetap untuk tabel */
        }

        .table,
        .table th,
        .table td {
            border: 1px solid black;
        }

        .table th,
        .table td {
            padding: 8px;
            text-align: left;
            word-wrap: break-word;
            /* Memungkinkan pemotongan kata jika terlalu panjang */
        }

        th,
        td {
            font-size: 10px;
            /* Menyesuaikan ukuran font agar lebih kecil */
        }
    </style>
</head>

<body>
    <h1>Detail Perhitungan Eclat</h1>
    <p>Rentang tanggal: {{ \Carbon\Carbon::parse($proses->start)->format('d F Y') }} -
        {{ \Carbon\Carbon::parse($proses->end)->format('d F Y') }}</p>
    <p>Min. Support: {{ $proses->min_support }}</p>
    <p>Min. Confidence: {{ $proses->min_confidence }}</p>

    <h2>Itemset 2</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Jenis Obat</th>
                <th>Support</th>
                <th>Keterangan</th>
                <th>Support xUy</th>
                <th>Support x</th>
                <th>Confidence</th>
                <th>Lift Ratio</th>
                <th>Korelasi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($itemset2 as $item)
                <tr>
                    <td>{{ $item->atribut }}</td>
                    <td>{{ $item->support }}</td>
                    <td>{{ $item->keterangan }}</td>
                    @if ($item->confidences->isEmpty())
                        <td colspan="5">Tidak ada data confidence</td>
                    @else
                        @foreach ($item->confidences as $confidence)
                            <td>{{ $confidence->support_xUy }}</td>
                            <td>{{ $confidence->support_x }}</td>
                            <td>{{ $confidence->confidence }}</td>
                            <td>{{ $confidence->lift_ratio }}</td>
                            <td>{{ $confidence->korelasi }}</td>
                        @endforeach
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Itemset 3</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Jenis Obat</th>
                <th>Support</th>
                <th>Keterangan</th>
                <th>Support xUy</th>
                <th>Support x</th>
                <th>Confidence</th>
                <th>Lift Ratio</th>
                <th>Korelasi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($itemset3 as $item)
                <tr>
                    <td>{{ $item->atribut }}</td>
                    <td>{{ $item->support }}</td>
                    <td>{{ $item->keterangan }}</td>
                    @if ($item->confidences->isEmpty())
                        <td colspan="5">Tidak ada data confidence</td>
                    @else
                        @foreach ($item->confidences as $confidence)
                            <td>{{ $confidence->support_xUy }}</td>
                            <td>{{ $confidence->support_x }}</td>
                            <td>{{ $confidence->confidence }}</td>
                            <td>{{ $confidence->lift_ratio }}</td>
                            <td>{{ $confidence->korelasi }}</td>
                        @endforeach
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
