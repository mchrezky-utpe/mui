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

    .select2-container .select2-selection--single {
      height: 38px;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
      line-height: 38px;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
      height: 38px;
    }
  </style>
  <div class="container-fluid">
    <div class="row">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-header">
          <h2 class="pageheader-title">Customer Delivery Schedule</h2>
          <div class="page-breadcrumb">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="#" class="breadcrumb-link">Transaction</a>
                </li>
                <li class="breadcrumb-item">
                  <a href="#" class="breadcrumb-link">Inventory</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Customer Delivery Schedule</li>
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
                📦 Customer Delivery Schedule
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link"
                id="tab-second"
                data-toggle="tab"
                href="#tab-second-content"
                role="tab">
                🏭 Customer Delivery Schedule List
              </a>
            </li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane fade show active"
              id="tab-request-content"
              role="tabpanel">
              <div class="card-header">
                <div class="row w-100 mb-2">
                  <div class="col-md-2">
                    <label>CDS Date</label>
                    <input type="date" class="form-control"
                      value="{{ date('Y-m-d') }}" disabled>
                  </div>
                  <div class="col-md-2">
                    <label>Cust Delivery Num.</label>
                    <input type="text" name="cust_delivery_num"
                      id="cust_delivery_num"
                      class="form-control"
                      placeholder="Cust Delivery Num">
                  </div>
                  <div class="col-md-3">
                    <label>Customer</label>
                    <select name="customer" id="customer" class="form-control">
                      <option value="">-- Select Customer --</option>
                    </select>
                  </div>
                  <div class="col-md-2">
                    <label>Valid From</label>
                    <input type="date"
                      name="valid_from"
                      id="valid_from"
                      class="form-control"
                      min="{{ date('Y-m-d') }}"
                      value="{{ date('Y-m-d') }}">
                  </div>
                  <div class="col-md-2">
                    <label>Valid Until</label>
                    <input type="date"
                      name="valid_until"
                      id="valid_until"
                      class="form-control"
                      min="{{ date('Y-m-d') }}"
                      value="{{ date('Y-m-d') }}">
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2 mt-3">
                  <h5 class="mb-0">📦 Items</h5>
                </div>
                <div class="table-responsive">
                  <table id="table_sales_order_list" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>SO Number</th>
                        <th>PO Number</th>
                        <th>Part Code</th>
                        <th>Part Name</th>
                        <th>Part Number</th>
                        <th>Business Type</th>
                        <th>Model</th>
                        <th>Quantity</th>
                        <th>OS</th>
                        <th>Valid From</th>
                        <th>Valid Until</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                  </table>
                </div>
                <hr>
                <div class="d-flex justify-content-between align-items-center mb-2 mt-4">
                  <h5 class="mb-0">🛒 Items Selected</h5>
                </div>
                <div class="table-responsive">
                  <table id="table_sales_order_list_selected" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>Delivery Plan Date</th>
                        <th>Destination Code</th>
                        <th>Part Code</th>
                        <th>Part Name</th>
                        <th>Part Number</th>
                        <th>Business Type</th>
                        <th>Model</th>
                        <th>Quantity</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                  </table>
                </div>
                <div class="text-right mt-3">
                  <button class="btn btn-success" id="btnSaveCDS">
                    💾 Save Customer Delivery Schedule
                  </button>
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
                    <label>Customer</label>
                    <select name="customer_delivery_schedule_details" id="customer_delivery_schedule_details" class="form-control">
                      <option value="">-- Select Customer --</option>
                    </select>
                  </div>
                  <div class="col-md-3">
                    <label>Valid From</label>
                    <input type="date"
                      name="valid_from_customer_delivery_schedule_details"
                      id="valid_from_customer_delivery_schedule_details"
                      class="form-control"
                      value="{{ date('Y-m-d') }}">
                  </div>
                  <div class="col-md-3">
                    <label>Valid Until</label>
                    <input type="date"
                      name="valid_until_customer_delivery_schedule_details"
                      id="valid_until_customer_delivery_schedule_details"
                      class="form-control"
                      min="{{ date('Y-m-d') }}"
                      value="{{ date('Y-m-d') }}"
                      disabled>
                  </div>
                  <div class="col-md-3 text-right">
                    <button id="btn_filter_cds" class="btn btn-primary w-100">
                      <i class="fa fa-filter"></i> Apply Filter
                    </button>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table id="table_customer_delivery_schedule" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>CDS Code</th>
                        <th>Date</th>
                        <th>Customer Delivery Number</th>
                        <th>Customer</th>
                        <th>Valid From</th>
                        <th>Valid Until</th>
                        <th>Validation Status</th>
                        <th>CDS Status</th>
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
  </div>
</div>

<!-- Modal Add / Edit Item -->
<div class="modal fade" id="modalItemInput" tabindex="-1">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Entry Customer Delivery Details</h5>
        <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body">
        <input type="hidden" id="modal_sku_id">
        <input type="hidden" id="modal_max_qty">

        <div class="form-group">
          <label>Delivery Plan Date</label>
          <input
            type="date"
            id="modal_delivery_date"
            class="form-control"
            min="{{ date('Y-m-d') }}">
        </div>

        <div class="form-group">
          <label>Quantity</label>
          <input
            type="number"
            id="modal_qty"
            class="form-control"
            min="1">
          <small class="text-muted">
            Max: <span id="modal_qty_max_label"></span>
          </small>
        </div>

        <div class="form-group">
          <label>Destination</label>
          <select id="modal_destination" name="modal_destination" class="form-control">
            <option value="">-- Select Destination --</option>
          </select>
        </div>
      </div>


      <div class="modal-footer">
        <button class="btn btn-primary" id="btnSaveItem">Save</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Detail Customer Delivery Schedule -->
<div class="modal fade" id="modalDetailCDS" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
          Detail Customer Delivery Schedule: <span id="cdsNumberTitle"></span>
        </h5>
        <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body">
        <div class="table-responsive">
          <table id="table_cds_detail" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>Del. Plan Date</th>
                <th>Destination</th>
                <th>Part Code</th>
                <th>Part Name</th>
                <th>Part Number</th>
                <th>Business Type</th>
                <th>Model</th>
                <th>Unit</th>
                <th>Quantity</th>
                <th>Outstanding</th>
                <th>OS</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('extra_javascript')
<script src="{{ asset('assets/js/transaction/Inventory/customer_delivery_schedule/customer_delivery_schedule.js') }}" type="text/javascript"></script>
@endsection