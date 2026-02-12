@extends('template.main')

@section('content')
<div class="section__content section__content--p30">
    <div class="container-fluid">

        {{-- HEADER --}}
        <div class="page-header">
            <h2 class="pageheader-title">Minimun Stock</h2>
            <div class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Inventory</a></li>
                    <li class="breadcrumb-item active">Minimun Stock</li>
                </ol>
            </div>
        </div>

        {{-- CARD --}}
        <div class="card shadow-sm">
            <div class="card-header bg-light">
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
            </div>

            <div class="card-body">
                <div id="data"></div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Minimum Stock -->
<div class="modal fade" id="modalMinimum" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white">Minimum Stock</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formMinimum">
                    <input type="hidden" id="sku_id">

                    <div class="mb-3">
                        <label>Minimum Qty</label>
                        <input type="number" id="qty" class="form-control" min="1" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="btnSubmitMinimum">Submit</button>
            </div>
        </div>
    </div>
</div>

@endsection