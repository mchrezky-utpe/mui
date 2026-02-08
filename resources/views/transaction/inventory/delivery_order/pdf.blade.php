<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Delivery Note</title>
    <style>
        @page {
            margin: 20px;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            line-height: 1.4;
        }

        .container {
            width: 100%;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .header-table td {
            vertical-align: top;
        }

        .company-name {
            font-size: 14px;
            font-weight: bold;
        }

        .title {
            font-size: 13px;
            font-weight: bold;
            margin-top: 10px;
        }

        .border {
            border: 1px solid #000;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            border: 1px solid #000;
            padding: 4px;
        }

        .table th {
            text-align: center;
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .mt-10 {
            margin-top: 10px;
        }

        .signature-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .signature-table td {
            border: 1px solid #000;
            height: 60px;
            text-align: center;
            vertical-align: bottom;
            padding-bottom: 5px;
        }

        .small {
            font-size: 9px;
        }
    </style>
</head>

<body>
    <div class="container">
        <table class="header-table">
            <tr>
                <td width="60%">
                    <table width="100%" style="border-collapse: collapse; margin-bottom: 6px;">
                        <tr>
                            <td width="60" style="vertical-align: top; text-align: center;">
                                <img src="{{ public_path('assets/images/icon/mui.png') }}" style="margin-bottom: 0px;"
                                    height="50">
                                <p style="font-size: 6.5px; margin: 0px; padding: 0px;">PT. MULTI USAGE INDONESIA</p>
                            </td>
                            <td style="vertical-align: middle;">
                                <div class="company-name" style="font-weight: bold; font-size: 14px;">
                                    PT. MULTI USAGE INDONESIA
                                </div>
                            </td>
                        </tr>
                    </table>

                    JL. JABABEKA XII B BLOK W-38<br>
                    KAWASAN INDUSTRI JABABEKA<br>
                    CIKARANG BEKASI - 17530<br>
                    Telp : (021) 89830301<br>
                    Fax : (021) 89830268
                </td>
                <td width="40%" style="padding: 40px;">
                    Cikarang, {{ date('d/m/Y') }}<br>
                    Kepada Yth :<br>
                    <strong>{{ $data->customer_name }}</strong><br>
                    {{ $data->destination_address }}
                </td>
            </tr>
        </table>

        <div class="title">SURAT JALAN No. {{ $data->do_number }}</div>
        <div style="margin-bottom: 8px;">Bersama Kendaraan : _______________________________ kami mengirim barang
            tersebut.</div>

        <table class="table">
            <thead>
                <tr>
                    <th width="8%">DUS</th>
                    <th width="12%">Banyaknya</th>
                    <th width="40%">Nama Barang</th>
                    <th width="15%">P/O</th>
                    <th width="10%">Warna</th>
                    <th width="15%">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td class="text-center">{{ $item->description }}</td>
                        <td class="text-center">{{ $item->total_packaging }}</td>
                        <td>{{ $item->sku_name }}</td>
                        <td class="text-center">
                            @if ($item->source_type == 'CDS')
                                {{ $item->po_number_cds }}
                            @elseif($item->source_type == 'CR')
                                {{ $item->po_number_cr }}
                            @endif
                        </td>
                        <td class="text-center"></td>
                        <td class="text-center">{{ floatval($item->qty) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Tanda Tangan --}}
        <table class="signature-table">
            <tr>
                <td width="25%">Tanda Terima</td>
                <td width="25%">Keamanan</td>
                <td width="25%">Bagian Gudang</td>
                <td width="25%">
                    Hormat kami<br><br>
                    <strong>{{ $pengirim ?? 'RAHMAT HIDAYAT' }}</strong>
                </td>
            </tr>
        </table>

        <div class="small mt-10">
            PMI-8.5.04/46 Rev.1
        </div>

    </div>
</body>

</html>
