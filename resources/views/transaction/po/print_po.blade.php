<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>mui_mrp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
        
</head>

<body>
    <!-- First Section -->
    <div class="container-fluid d-flex w-100">
        <div class="d-flex align-items-center w-50">
            <div>
            {{-- <img src="{{ assets('assets/images/icon/mui.png') }}" width="100px" /> --}}
            <img src="{{ asset('assets/images/icon/mui.png') }}" width="100px" />

            </div>
            <div>
                <h6>PT. MULTI USAGE INDONESIA</h6>
            </div>
        </div>
        <div class="d-flex justify-content-end w-50">
            <div class="me-2">
                <h6>SHIP TO :</h6>
            </div>
            <div class="ms-2">
                <h6>Jl. Jababeka XII B Blok W 38</h6>
                <h6>Kawasan Industri Jababeka Cikarang</h6>
                <h6>Bekasi, Jawa Barat 17530</h6>
            </div>
        </div>
    </div>

    <div class="text-center">
        <h3>PURCHASE ORDER</h3>
    </div>

    <!-- Second Section (same as first section) -->
    <div class="container-fluid d-flex">
        <div class="d-flex w-75">
            <div class="me-2">
                <p style="line-height: 0.5;">SUPPLIER</p>
                <p style="line-height: 0.5;">ADDRESS</p>
                <p style="line-height: 0.5;">&nbsp;</p>
                <p style="line-height: 0.5;">&nbsp;</p>
                <p style="line-height: 0.5;">PHONE / FAX</p>
                <p style="line-height: 0.5;">ATTENTION TO</p>
                <p style="line-height: 0.5;">VALID DATE</p>
            </div>
            <div class="me-2">
                <p style="line-height: 0.5;">:</p>
                <p style="line-height: 0.5;">:</p>
                <p style="line-height: 0.5;">&nbsp;</p>
                <p style="line-height: 0.5;">&nbsp;</p>
                <p style="line-height: 0.5;">:</p>
                <p style="line-height: 0.5;">:</p>
                <p style="line-height: 0.5;">:</p>
            </div>
            <div>
                <p style="line-height: 0.5;">{{ $header->supplier_name }}&nbsp;</p>
                <p style="line-height: 0.5;">{{ $header->address_01 }}&nbsp;</p>
                <p style="line-height: 0.5;">&nbsp;</p>
                <p style="line-height: 0.5;">&nbsp;</p>
                <p style="line-height: 0.5;">{{ $header->phone_01 }}&nbsp; / {{ $header->fax_01 }}&nbsp;</p>
                <p style="line-height: 0.5;">{{ $header->email_01 }}&nbsp;</p>
                <p style="line-height: 0.5;">&nbsp;</p>
            </div>
        </div>
        
        <div class="d-flex justify-content-end w-50">
            <div class="me-2">
                <p style="line-height: 0.5;">PO NUMBER</p>
                <p style="line-height: 0.5;">REVISION</p>
                <p style="line-height: 0.5;">PO DATE</p>
                <p style="line-height: 0.5;">PR NUMBER</p>
                <p style="line-height: 0.5;">TERMS</p>
                <p style="line-height: 0.5;">CURRENCY</p>
                <p style="line-height: 0.5;">DEPARTMENT</p>
            </div>
            <div class="me-2">
                <p style="line-height: 0.5;">:</p>
                <p style="line-height: 0.5;">:</p>
                <p style="line-height: 0.5;">:</p>
                <p style="line-height: 0.5;">:</p>
                <p style="line-height: 0.5;">:</p>
                <p style="line-height: 0.5;">:</p>
                <p style="line-height: 0.5;">:</p>
            </div>
            <div>
                <p style="line-height: 0.5;">{{ $header->doc_num }}&nbsp;</p>
                <p style="line-height: 0.5;">{{ $header->revision }}&nbsp;</p>
                <p style="line-height: 0.5;">{{ $header->trans_date }}&nbsp;</p>
                <p style="line-height: 0.5;">{{ $header->purchase }}&nbsp;</p>
                <p style="line-height: 0.5;">{{ $header->terms }}&nbsp;</p>
                <p style="line-height: 0.5;">{{ $header->currency }}&nbsp;</p>
                <p style="line-height: 0.5;">{{ $header->department }}&nbsp;</p>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <table class="table table-bordered">
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
                <tbody> @foreach($data as $key => $value) 
                <tr>
                    <td>{{ $value->sku_prefix }}</td>
                    <td>{{ $value->sku_description }}</td>
                    <td></td>
                    <td>{{ $value->qty }}</td>
                    <td></td>
                    <td>{{ $value->price_d }}</td>
                    <td>{{ $value->price_d }}</td>
                    <td></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="container-fluid d-flex">
        <div class="text-center" style="width: 100px;">Prepared by</div>
        <div class="text-center" style="width: 100px;">Approved by</div>
        <div class="text-center" style="width: 100px;">Received by</div>
    </div>
    <br />
    <br />
    <div class="container-fluid d-flex">
        <div class="text-center" style="width: 100px;"></div>
        <div class="text-center" style="width: 100px;">YG. Tan</div>
        <div class="text-center" style="width: 100px;">{{ $header->supplier_name }}&nbsp;</div>
    </div>
    <div class="container-fluid d-flex">
        <div class="text-center" style="width: 100px;">========</div>
        <div class="text-center" style="width: 100px;">========</div>
        <div class="text-center" style="width: 100px;">========</div>
    </div>
    <div class="container-fluid d-flex">
        <div class="text-center" style="width: 100px;">Purchasing</div>
        <div class="text-center" style="width: 100px;">Director</div>
        <div class="text-center" style="width: 100px;">Suplier Sign</div>
    </div>
    <div class="container-fluid d-flex">
        <div class="me-3">MUI-S-F-PU-02-001 </div>
        <div >Rev.5</div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>
<script>
    window.onload = function() {
        window.print();
    };
</script>


</html>