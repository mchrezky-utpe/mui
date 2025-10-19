<meta name="csrf-token" content="{{ csrf_token() }}"> @extends('template.main') @section('content') <style>
  .table-container {
    max-height: 400px;
    overflow-y: auto;
    border: 1px solid #ccc;
    overflow-x: auto;
  }

  .table-container table {
    max-width: 150%;
    width: 150%;
    border-collapse: collapse;
  }
</style>

<div class="section__content section__content--p30">
  <div class="container-fluid">
    
    <div class="row">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-header">
          <h3 class="pageheader-title">Purchase Invoice Detail</h3>
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
              <a href="{{ route('purchase_order_detail.export') }}" class="mr-2 btn btn-success">
                <i class="fas fa-file-excel"></i> Export Excel
              </a>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table id="table-pi-detail" class="table table-striped table-bordered first">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Invoice Codde</th>
                    <th>Invoice Number</th>
                    <th>Invoice Date</th>
                    <th>Department</th>
                    <th>Supplier</th>
                    <th>PR Number</th>
                    <th>PO Number</th>
                    <th>DO Number</th>
                    <th>Item Code</th>
                    <th>Item Name</th>
                    <th>Spec Code</th>
                    <th>Item Type</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Amount</th>
                    <th>Checked</th>
                    <th>Approve</th>
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
@endsection
<!-- MODAL --> 
@section('extra_javascript') 
<script type="module" src="{{ asset('assets/js/transaction/purchase_invoice/pi_detail.js') }}" type="text/javascript"></script> 
@endsection