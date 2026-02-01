<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - {{ $data->do_number }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.5;
        }

        .header-table {
            width: 100%;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .title {
            text-align: center;
            text-transform: uppercase;
            font-size: 18px;
            font-weight: bold;
            margin: 0;
        }

        .info-table {
            width: 100%;
            margin-bottom: 20px;
        }

        .info-table td {
            vertical-align: top;
            width: 50%;
        }

        .label {
            font-weight: bold;
            width: 120px;
            display: inline-block;
        }

        .content-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .content-table th {
            background-color: #f2f2f2;
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }

        .content-table td {
            border: 1px solid #000;
            padding: 8px;
        }

        .footer-table {
            width: 100%;
            margin-top: 40px;
            text-align: center;
        }

        .signature-box {
            height: 80px;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>

    <table class="header-table">
        <tr>
            <td>
                <h1 class="title">{{ $title }}</h1>
                <div style="text-align: center;">Nomor: {{ $data->do_number }}</div>
            </td>
        </tr>
    </table>

    <table class="info-table">
        <tr>
            <td>
                <div><span class="label">Tanggal</span>: {{ \Carbon\Carbon::parse($data->do_date)->format('d F Y') }}
                </div>
                <div><span class="label">Tipe DO</span>: {{ $data->do_type }}</div>
                <div><span class="label">Sub Tipe</span>: {{ $data->do_sub_type }}</div>
            </td>
            <td>
                <div><span class="label">Customer</span>: {{ $data->customer_name }}</div>
                <div><span class="label">Petugas</span>: {{ $data->do_officer_name }}</div>
                <div><span class="label">Status</span>: <strong>{{ $data->status }}</strong></div>
            </td>
        </tr>
    </table>

    <p>Harap diterima barang-barang berikut dengan baik:</p>

    <table class="content-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Deskripsi Barang</th>
                <th width="15%">Jumlah</th>
                <th width="15%">Satuan</th>
            </tr>
        </thead>
        <tbody>
            {{-- Sesuaikan bagian ini jika Anda memiliki relasi $data->details --}}
            @if (isset($data->items) && count($data->items) > 0)
                @foreach ($data->items as $index => $item)
                    <tr>
                        <td style="text-align: center;">{{ $index + 1 }}</td>
                        <td>{{ $item->name }}</td>
                        <td style="text-align: center;">{{ $item->quantity }}</td>
                        <td style="text-align: center;">{{ $item->unit }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="4" style="text-align: center; font-style: italic;">Tidak ada detail item barang.
                    </td>
                </tr>
            @endif
        </tbody>
    </table>

    @if ($data->do_note)
        <div style="margin-top: 15px;">
            <strong>Catatan:</strong><br>
            {{ $data->do_note }}
        </div>
    @endif

    <table class="footer-table">
        <tr>
            <td width="33%">
                Penerima,<br><br>
                <div class="signature-box"></div>
                ____________________<br>
                ( Stempel & Tanda Tangan )
            </td>
            <td width="33%">
                Sopir,<br><br>
                <div class="signature-box"></div>
                ____________________<br>
                ( {{ $data->driver_id ?? '....................' }} )
            </td>
            <td width="33%">
                Hormat Kami,<br><br>
                <div class="signature-box"></div>
                ____________________<br>
                ( {{ $data->do_officer_name }} )
            </td>
        </tr>
    </table>

</body>

</html>
