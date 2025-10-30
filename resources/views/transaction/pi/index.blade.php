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
    tr.shown {
        background-color: #f8f9fa;
    }
</style>

<div class="section__content section__content--p30">
  <div class="container-fluid">
    <div class="row">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-header">
          <h2 class="pageheader-title">Purchase Invoice</h2>
          <div class="page-breadcrumb">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="#" class="breadcrumb-link">Transaction</a>
                </li>
                <li class="breadcrumb-item">
                  <a href="#" class="breadcrumb-link">Purchase</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Purchase Invoice</li>
              </ol>
            </nav>
          </div>
        </div>
      </div>
    </div>
    <div class="row">

      <div class="card-body">
        <div class="mb-3 row">
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
            <div class="d-flex">
              <button id="add_button" type="button" class="btn btn-primary add_modal" data-toggle="modal"
                data-target="#add_modal">Add +</button>
              <a href="{{ route('purchase_invoice.export') }}" class="mr-2 btn btn-success">
                <i class="fas fa-file-excel"></i> Export Excel
              </a>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table id="table-pi" class="table table-striped table-bordered first">
                <thead>
                  <tr>
                    <th></th>
                    <th>Action</th>
                    <th>Invoice Code</th>
                    <th>Invoice Number</th>
                    <th>Invoice Date</th>
                    <th>Department</th>
                    <th>Supplier</th>
                    <th>Terms</th>
                    <th>Currecny</th>
                    <th>Discount</th>
                    <th>Sub Total</th>
                    <th>PPN</th>
                    <th>PPH</th>
                    <th>Total</th>
                    <th>P1 Receipt Date</th>
                    <th>P1 Recipient</th>
                    <th>P1 Recipient Status</th>
                    <th>P2 Receipt Date</th>
                    <th>P2 Recipient</th>
                    <th>P2 Recipient Status</th>
                    <th>P3 Receipt Date</th>
                    <th>P3 Recipient</th>
                    <th>P3 Recipient Status</th>
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
 @include('transaction.pi._add')
 @include('transaction.pi._edit')
 @include('transaction.pi._detail')
 @include('transaction.pi._item_check')
 @endsection

 @section('extra_javascript')
 <script  type="module" src="{{ asset('assets/js/transaction/purchase_invoice/pi_main.js') }}" type="text/javascript"></script>
 @endsection
