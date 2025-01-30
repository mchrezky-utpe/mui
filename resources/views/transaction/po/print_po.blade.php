<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print PO</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .logo {
            /* position: absolute; */
            top: 20px;
            left: 20px;
            width: 50px; /* Ukuran logo */
        }

        .content {
            margin: 20px;
            page-break-before: always;
        }

        /* Label di atas tabel */
        .label {
            font-size: 16px;
            margin-bottom: 10px;
        }

        /* Tabel */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            page-break-inside: avoid;  /* Hindari pemisahan tabel antar halaman */
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        /* Subtotal & Total di bawah tabel */
        .totals {
            margin-top: 20px;
            text-align: right;
        }

        .totals span {
            font-weight: bold;
        }

        /* Media query untuk cetak */
        @media print {
            /* Menghilangkan tombol print saat pencetakan */
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>

<!-- Konten Utama -->
<div class="content">

    <div  class="label">
        <img src="https://example.com/logo.png" alt="Logo" class="logo"/>
    </div>
    <!-- Label -->
    <div class="label">PURCHASE ORDER</div>
    <!-- Label Supplier dan Alamat -->
    <div class="label">
        SUPPLIER: PT. ABC
    </div>
    <div class="label">
        ADDRESS: Jl. Raya No. 123, Jakarta
    </div>
    <div class="label">
        PHONE/FAX: Jl. Raya No. 123, Jakarta
    </div>
    <div class="label">
        ATTENTION TO: Jl. Raya No. 123, Jakarta
    </div>
    <div class="label">
        VALID DATE: Jl. Raya No. 123, Jakarta
    </div>

    <!-- Tabel -->
    <table>
        <thead>
            <tr>
                <th>ITEM CODE</th>
                <th>ITEM NAME</th>
                <th>SPE. CODE</th>
                <th>QTY</th>
                <th>UNIT</th>
                <th>PRICE</th>
                <th>AMOUNT</th>
                <th>REQ. DATE</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Produk A</td>
                <td>10</td>
                <td>Rp 50.000</td>
                <td>Rp 500.000</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
            </tr>        
        </tbody>
    </table>

    <!-- Subtotal dan Total -->
    <div class="totals">
        <div><span>Subtotal:</span> Rp 1.450.000</div>
        <div><span>DISCOUNT:</span> </div>
        <div><span>PPN (11%):</span> </div>
        <div><span>PPH23:</span> </div>
        <div><span>TOTAL ORDER:</span> Rp 1.450.000</div>
    </div>
</div>

<!-- Tombol untuk men-trigger Print (hanya untuk tampilan layar, disembunyikan saat print) -->
<a class="no-print" href="/po">Back</a>
<button class="no-print" onclick="window.print()">Print</button>
<script>
    // Membuka dialog print otomatis saat halaman dimuat
    window.onload = function() {
        window.print();
    }
</script>

</body>
</html>
