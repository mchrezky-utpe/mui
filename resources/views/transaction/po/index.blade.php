<meta name="csrf-token" content="{{ csrf_token() }}">
@extends('template.main') @section('content')
<style>
  .table-container {
        max-height: 400px;
        overflow-y: auto;
        border: 1px solid #ccc;
        overflow-y: auto;
    }

    .table-container table {
        width: 100%;
        border-collapse: collapse;
    }
</style>

<div class="section__content section__content--p30">
  <div class="container-fluid">
    <div class="row">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-header">
          <h2 class="pageheader-title">Purchase Order</h2>
          <div class="page-breadcrumb">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="#" class="breadcrumb-link">Transaction</a>
                </li>
                <li class="breadcrumb-item">
                  <a href="#" class="breadcrumb-link">Purchase</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Purchase Order(PO)</li>
              </ol>
            </nav>
          </div>
        </div>
      </div>
    </div>
    <div class="row">

      <div class="card-body">
        <div class="row mb-3">
          <div class="col-md-3">
            <div class="form-group">
              <label for="start_date">Start Date</label>
              <input type="date" class="form-control" id="start_date" name="start_date">
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="end_date">End Date</label>
              <input type="date" class="form-control" id="end_date" name="end_date">
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group" style="margin-top: 32px;">
              <button type="button" id="btn-filter" class="btn btn-primary">
                <i class="fas fa-search"></i> Filter </button>
              <button type="button" id="btn-reset" class="btn btn-secondary">
                <i class="fas fa-sync"></i> Reset </button>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">List</h5>
            {{-- <button id="add_button"  type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_modal">Add +</button> --}}
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table id="table-po" class="table table-striped table-bordered first">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>PO Number</th>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Supplier</th>
                    <th>Remark</th>
                    <th>PR Number</th>
                    <th>PO</th>
                    <th>PDF</th>
                    <th>EDI</th>
                    <th>Revison</th>
                    <th>Terms</th>
                    <th>Currency</th>
                    <th>Sub Total</th>
                    <th>PPN</th>
                    <th>PPH23</th>
                    <th>Discount</th>
                    <th>Total</th>
                    <th>Action</th>
                  </tr>
                </thead>
                </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- MODAL -->
 @include('transaction.po._add')
 @include('transaction.po._edit')
 @include('transaction.po._upload')
 @include('transaction.po._detail')
 @endsection

 @section('extra_javascript')
 <script  type="module" src="{{ asset('assets/js/transaction/purchase_order/po_main.js') }}" type="text/javascript"></script>
 @endsection
