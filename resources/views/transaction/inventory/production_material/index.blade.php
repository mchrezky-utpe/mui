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

    .dataTables_processing {
      position: absolute !important;
      top: 50% !important;
      left: 50% !important;
      transform: translate(-50%, -50%);
      background: rgba(255, 255, 255, 0.85);
      padding: 20px 30px;
      border-radius: 12px;
      z-index: 10;

      display: flex;
      align-items: center;
      justify-content: center;
    }

    table.dataTable {
      width: 100% !important;
    }

    .dataTables_wrapper {
      width: 100% !important;
    }

    .tab-pane {
      width: 100%;
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
          <ul class="nav nav-tabs px-3 pt-3" id="pmrTabs" role="tablist">
            <li class="nav-item">
              <a class="nav-link active"
                id="tab-request"
                data-toggle="tab"
                href="#tab-request-content"
                role="tab">
                📦 Production Material Request
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link"
                id="tab-second"
                data-toggle="tab"
                href="#tab-second-content"
                role="tab">
                🏭 General Stock Issue
              </a>
            </li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane fade show active"
              id="tab-request-content"
              role="tabpanel">
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
                    <button id="btn_filter_pmr" class="btn btn-primary w-100">
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
            <!-- TAB 2 -->
            <div class="tab-pane fade"
              id="tab-second-content"
              role="tabpanel">

              <div class="card-header">
                <div class="row w-100 align-items-end">
                  <div class="col-md-3">
                    <label>Stock Issue Date</label>
                    <input name="stock_issue_date" type="date" class="form-control"
                      value="{{ date('Y-m-d') }}">
                  </div>
                  <div class="col-md-3">
                    <label>Type</label>
                    <select name="stock_issue_type" class="form-control">
                      <option value="General">General</option>
                      <option value="Anhilination">Anhilination</option>
                    </select>
                  </div>
                  <div class="col-md-3 text-right">
                    <button id="btn_filter_stock" class="btn btn-primary w-100">
                      <i class="fa fa-filter"></i> Apply Filter
                    </button>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <table id="table_stock_issue" class="table table-striped table-bordered first">
                  <thead>
                    <tr>
                      <th>Item Code</th>
                      <th>Item Name</th>
                      <th>Specification Code</th>
                      <th>Item Type</th>
                      <th>Unit</th>
                      <th>Stock</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- MODAL STOCK ISSUE -->
<div class="modal fade" id="modalStockIssue" tabindex="-1">
  <div class="modal-dialog modal-md modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">Stock Issue</h5>
        <button type="button" class="close text-white" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <input type="hidden" id="si_sku_id">
        <input type="hidden" id="si_stock">

        <div class="form-group">
          <label>Item</label>
          <input type="text" id="si_item_name" class="form-control" readonly>
        </div>

        <div class="form-group">
          <label>Current Stock</label>
          <input type="number" id="si_stock_view" class="form-control" readonly>
        </div>

        <div class="form-group">
          <label>Qty Issue</label>
          <input type="number" id="si_qty" class="form-control" min="1">
          <small class="text-danger d-none" id="qtyError">
            Qty cannot be greater than available stock
          </small>
        </div>
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button class="btn btn-success" id="btnSubmitStockIssue">
          ✅ Submit
        </button>
      </div>
    </div>
  </div>
</div>

@endsection

@section('extra_javascript')
<script src="{{ asset('assets/js/transaction/production_material.js') }}" type="text/javascript"></script>
@endsection