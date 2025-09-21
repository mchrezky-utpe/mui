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
          <h3 class="pageheader-title">Purchase Requisition</h3>

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
            <button id="add_button" type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_modal">Add +</button>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table id="table-pr" class="table table-striped table-bordered first">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>PR Number</th>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Purpose</th>
                    <th>Supplier</th>
                    <th>Status</th>
                    <th>Remark</th>
                    <th>Amount</th>
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
@include('transaction.pr._detail') 
@include('transaction.pr._add_po') 
@include('transaction.pr._add')
@include('transaction.pr._edit') @endsection @section('extra_javascript') <script type="module" src="{{ asset('assets/js/transaction/purchase_order_request/pr_main.js') }}" type="text/javascript"></script> @endsection