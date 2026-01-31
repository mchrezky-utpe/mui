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
          <h2 class="pageheader-title">Sales Order</h2>
          <div class="page-breadcrumb">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="#" class="breadcrumb-link">Transaction</a>
                </li>
                <li class="breadcrumb-item">
                  <a href="#" class="breadcrumb-link">Sales</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Sales Order</li>
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
                📦 Sales Order
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link"
                id="tab-second"
                data-toggle="tab"
                href="#tab-second-content"
                role="tab">
                🏭 Sales Order List
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link"
                id="tab-third"
                data-toggle="tab"
                href="#tab-third-content"
                role="tab">
                🏭 Sales Order Details List
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
                    <label>SO Date</label>
                    <input type="date" class="form-control"
                      value="{{ date('Y-m-d') }}" disabled>
                  </div>
                  <div class="col-md-2">
                    <label>PO Number</label>
                    <input type="text" name="po_number"
                      class="form-control"
                      placeholder="PO Number">
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
                <div class="row w-100">
                  <div class="col-md-2">
                    <label>Currency</label>
                    <select name="currency"
                      id="currency"
                      class="form-control">
                      <option value="">-- Select Currency --</option>
                    </select>
                  </div>
                  <div class="col-md-2">
                    <label>Exchange Rate</label>
                    <input type="text"
                      name="exchange_rate"
                      id="exchange_rate"
                      class="form-control"
                      value="1"
                      readonly>
                  </div>
                  <div class="col-md-2">
                    <label>Ref. Number</label>
                    <input type="text"
                      class="form-control"
                      value="-"
                      disabled>
                  </div>
                  <div class="col-md-2">
                    <label>Type</label>
                    <select name="type_item"
                      id="type_item"
                      class="form-control">
                      <option value="">-- Select Type --</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2 mt-3">
                  <h5 class="mb-0">📦 Items</h5>
                </div>
                <table id="table_product_pricelist" class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>Part Code</th>
                      <th>Part Name</th>
                      <th>Part Number</th>
                      <th>Business Type</th>
                      <th>Model</th>
                      <th>Unit</th>
                      <th>Currency</th>
                      <th class="text-right">Price</th>
                      <th>Valid From</th>
                      <th>Valid Until</th>
                      <th>Act. Status</th>
                    </tr>
                  </thead>
                </table>
                <hr>
                <div class="d-flex justify-content-between align-items-center mb-2 mt-4">
                  <h5 class="mb-0">🛒 Items Selected</h5>
                </div>

                <table id="table_product_pricelist_selected" class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>Part Code</th>
                      <th>Part Name</th>
                      <th>Part Number</th>
                      <th>Business Type</th>
                      <th>Model</th>
                      <th>Unit</th>
                      <th>Quantity</th>
                      <th>Outstanding</th>
                      <th>TOP</th>
                      <th>Currency</th>
                      <th class="text-right">Price</th>
                      <th class="text-right">Amount</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                </table>

                <div class="text-right mt-3">
                  <button class="btn btn-success" id="btnSaveSO">
                    💾 Save Sales Order
                  </button>
                </div>
              </div>
            </div>
            <!-- TAB 2 -->
            <div class="tab-pane fade"
              id="tab-second-content"
              role="tabpanel">

              <div>kosong</div>
            </div>
            <!-- TAB 2 -->
            <div class="tab-pane fade"
              id="tab-third-content"
              role="tabpanel">

              <div>kosong</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Add / Edit Item -->
<div class="modal fade" id="modalItemInput" tabindex="-1">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Item</h5>
        <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body">
        <input type="hidden" id="modal_sku_id">

        <div class="form-group">
          <label>Quantity</label>
          <input type="number" id="modal_qty" class="form-control" min="1">
        </div>

        <div class="form-group">
          <label>Term Of Payment (%)</label>
          <input type="number" id="modal_top" class="form-control" min="1" max="100" value="100">
        </div>
      </div>

      <div class="modal-footer">
        <button class="btn btn-primary" id="btnSaveItem">Save</button>
      </div>
    </div>
  </div>
</div>

@endsection

@section('extra_javascript')
<script src="{{ asset('assets/js/transaction/Sales/sales_order/sales_order.js') }}" type="text/javascript"></script>
@endsection