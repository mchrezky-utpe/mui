<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Purchase Order</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        .header, .details, .footer {
            margin-bottom: 10px;
        }
        .details td {
            padding: 4px 4px;
        }
        .items th, .items td {
            border: 1px solid #000;
            padding: 4px;
            text-align: center;
        }
        .signature td {
            padding-top: 40px;
            text-align: center;
        }
        .info-label {
            width: 110px;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <!-- Header -->
<div class="header">
    <table>
        <tr>
            <td style="width: 70%;">
                <img src="{{ public_path('assets/images/icon/mui.png') }}" height="100" alt="Logo MUI"><br>
                <strong>PT. MULTI USAGE INDONESIA</strong>
            </td>
            <td style="text-align: right;">
                <strong>SHIP TO:</strong><br>
                Jl. Jababeka XII B Blok W 38<br>
                Kawasan Industri Jababeka Cikarang<br>
                Bekasi, Jawa Barat 17530
            </td>
        </tr>
    </table>
</div>


    <!-- Title -->
    <h2 style="text-align: center;">PURCHASE ORDER</h2>

    <!-- Detail PO -->
    <table class="details">
        <tr>
            <td class="info-label">SUPPLIER</td>
            <td>: {{ $po->supplier_name ?? '-' }}</td>
            <td class="info-label">PO NUMBER</td>
            <td>: {{ $po->po_number }}</td>
        </tr>
        <tr>
            <td class="info-label">ADDRESS</td>
            <td>: {{ $po->address ?? '-' }}</td>
            <td class="info-label">REVISION</td>
            <td>: 0</td>
        </tr>
        <tr>
            <td class="info-label">PHONE / FAX</td>
            <td>: {{ $po->phone ?? '' }} / {{ $po->fax ?? '' }}</td>
            <td class="info-label">PO DATE</td>
            <td>: {{ \Carbon\Carbon::parse($po->po_date)->format('Y-m-d') }}</td>
        </tr>
        <tr>
            <td class="info-label">ATTENTION</td>
            <td>: {{ $po->attention_to ?? '-' }}</td>
            <td class="info-label">PR NUMBER</td>
            <td>: {{ $po->pr_number }}</td>
        </tr>
        <tr>
            <td class="info-label">EMAIL</td>
            <td>: {{ $po->attention_to ?? '-' }}</td>
            <td class="info-label">TERMS</td>
            <td>: {{ $po->terms }}</td>
        </tr>
        <tr>
            <td class="info-label"></td>
            <td></td>
            <td class="info-label">CURRENCY</td>
            <td>: {{ $po->currency }}</td>
        </tr>
        <tr>
            <td class="info-label"></td>
            <td></td>
            <td class="info-label">DEPARTMENT</td>
            <td>: {{ $po->department }}</td>
        </tr>
    </table>

    <!-- Items Table -->
    <table class="items">
        <thead>
            <tr>
                <th>ITEM CODE</th>
                <th>ITEM NAME</th>
                <th>SPE. CODE</th>
                <th>QTY</th>
                <th>UNIT</th>
                <th>PRICE</th>
                <th>AMOUNT</th>
                <th>REQ DATE</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
            <tr>
                <td>{{ $item['item_code'] ?? '-' }}</td>
                <td>{{ $item['item_name'] }}</td>
                <td>{{ $item['spe_code'] ?? '' }}</td>
                <td>{{ $item['qty'] }}</td>
                <td>{{ $item['unit'] }}</td>
                <td>{{ number_format($item['price'], 0, ',', '.') }}</td>
                <td>{{ number_format($item['amount'], 0, ',', '.') }}</td>
                <td>{{ $item['req_date'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Totals -->
    <table class="details" style="margin-top: 10px;">
        <tr>
            <td class="info-label">SUB TOTAL</td>
            <td>: {{ number_format(collect($items)->sum('amount'), 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="info-label">DISCOUNT</td>
            <td>: 0.0000</td>
        </tr>
        <tr>
            <td class="info-label">PPn</td>
            <td>: 0.0000</td>
        </tr>
        <tr>
            <td class="info-label">TOTAL ORDER</td>
            <td>: {{ number_format(collect($items)->sum('amount'), 0, ',', '.') }}</td>
        </tr>
    </table>

    <!-- Signatures -->
    <table class="signature" width="100%" style="margin-top: 40px;">
        <tr>
            <td>Prepared by</td>
            <td>Approved by</td>
            <td>Received by</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>{{ $po->supplier->contact_person_02 ?? '-' }}<br>{{ $po->supplier->description ?? '-' }}</td>
        </tr>
        <tr>
            <td>__________________</td>
            <td>__________________</td>
            <td>__________________</td>
        </tr>
        <tr>
            <td>Purchasing</td>
            <td>Director</td>
            <td>Supplier Sign</td>
        </tr>
    </table>

</body>
</html>
