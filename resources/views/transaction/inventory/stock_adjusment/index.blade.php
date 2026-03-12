@extends('template.main')

@section('content')
<div class="section__content section__content--p30">
    <div class="container-fluid">

        {{-- HEADER --}}
        <div class="page-header">
            <h2 class="pageheader-title">Stock Adjusment</h2>
            <div class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Inventory</a></li>
                    <li class="breadcrumb-item active">Stock Adjusment</li>
                </ol>
            </div>
        </div>

        {{-- CARD --}}
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <div class="row align-items-center mb-2">
                    <div class="col-lg-1">Date:</div>
                    <div class="col-lg-4"><input type="date" id="date" class="form-control form-control-sm"></div>
                </div>

                <div class="row align-items-center mb-2">
                    <div class="col-lg-2">Categories:</div>
                    <div class="col-lg-8">
                        <label class="mx-3"><input type="radio" name="type" value="1" checked> Part</label>
                        <label class="mx-3"><input type="radio" name="type" value="2"> Production Material</label>
                        <label class="mx-3"><input type="radio" name="type" value="3"> General Item</label>
                        <label><input type="radio" name="type" value="4"> Returnable Packaging</label>
                    </div>
                    <div class="col-lg-2">
                        <input type="text" id="search" class="form-control form-control-sm" placeholder="Search..">
                    </div>
                </div>

                <div class="row text-end mb-2">
                    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalImportExcel">
                        Import Excel
                    </button>
                </div>
            </div>

            <div class="card-body">
                <div id="data"></div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Adjusment Stock -->
<div class="modal fade" id="modalAdjusment" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white">Adjusment Stock</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formAdjusment">
                    <input type="hidden" id="sku_id">

                    <div class="mb-3">
                        <label>Adjustment Qty</label>
                        <input type="text" id="qty" class="form-control" placeholder="ex: 20 or -20" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="btnSubmitAdjusment">Submit</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Import Excel -->
<div class="modal fade" id="modalImportExcel" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title text-white">Import Adjustment Stock</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formImportExcel" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label>Upload Excel</label>
                        <input type="file" id="file_excel" class="form-control" accept=".xlsx,.xls" required>

                        <small class="text-muted d-block mt-2">
                            Format: No | Part Code | Qty
                        </small>

                        <!-- 🔽 Download Template Button -->
                        <div class="mt-2">
                            <a href="{{ asset('assets/template/template_import_adjusment_stock.xlsx') }}"
                                class="btn btn-outline-primary btn-sm"
                                download>
                                <i class="fa fa-download"></i> Download Template
                            </a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" id="btnImportExcel">Import</button>
            </div>
        </div>
    </div>
</div>

@endsection