<!-- index view for stock_opening -->
@extends('template.main') @section('content') <div class="section__content section__content--p30">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <style>
    .card-header {
      background: #f8f9fa;
      border-bottom: 1px solid #e3e6f0;
    }

    .table thead th {
      background-color: #343a40;
      color: #fff;
      text-align: center;
      vertical-align: middle;
      font-size: 13px;
    }

    .table tbody td {
      font-size: 13px;
      vertical-align: middle;
    }

    .badge {
      font-size: 11px;
      padding: 6px 10px;
    }
  </style>
  <div class="container-fluid">
    <div class="row">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-header">
          <h2 class="pageheader-title">Production Material Request</h2>
          <div class="page-breadcrumb">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="#" class="breadcrumb-link">Transaction</a>
                </li>
                <li class="breadcrumb-item">
                  <a href="#" class="breadcrumb-link">Inventory</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Production Material Request</li>
              </ol>
            </nav>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
          <div class="card-header">
            <div class="row w-100 align-items-end">

              <div class="col-md-3">
                <label>Start Date</label>
                <input name="start_date" type="date" class="form-control"
                  value="{{ date('Y-m-d') }}">
              </div>

              <div class="col-md-3">
                <label>End Date</label>
                <input name="end_date" type="date" class="form-control"
                  value="{{ date('Y-m-d') }}">
              </div>

              <div class="col-md-3">
                <label>Process Type</label>
                <select name="process_type" class="form-control">
                  <option value="">-- All Process --</option>
                  <option value="PLATING">PLATING</option>
                  <option value="ASSEMBLY">ASSEMBLY</option>
                  <option value="BUFFING">BUFFING</option>
                </select>
              </div>

              <div class="col-md-3 text-right">
                <button id="btn_filter" class="btn btn-primary w-100">
                  <i class="fa fa-filter"></i> Apply Filter
                </button>
              </div>

            </div>
          </div>

          <div class="card-body">
            <table id="table_production_material" class="table table-striped table-bordered first">
              <thead>
                <tr>
                  <th>PS Code</th>
                  <th>Process Type</th>
                  <th>Req Date</th>
                  <th>PMR Code</th>
                  <th>Material Code</th>
                  <th>Material Name</th>
                  <th>Item Type</th>
                  <th>Unit</th>
                  <th>Qty</th>
                  <th>Stock</th>
                  <th>Stock Status</th>
                  <th>Request Status</th>
                </tr>
              </thead>


              <tbody>
              </tbody>
            </table>
            <div class="row mt-3">
              <div class="col-md-12 text-right">
                <button id="btnReject" class="btn btn-danger mr-2">
                  ❌ Reject
                </button>
                <button id="btnApprove" class="btn btn-success">
                  ✅ Approve
                </button>
              </div>
            </div>

          </div>

        </div>
      </div>
    </div>


  </div>
</div>

<!-- MODAL -->
@endsection

@section('extra_javascript')
<script src="{{ asset('assets/js/transaction/production_material.js') }}" type="text/javascript"></script>
@endsection