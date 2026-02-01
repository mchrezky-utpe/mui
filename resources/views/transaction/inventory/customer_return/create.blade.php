@extends('template.main')

@section('extra-css')
    @include('transaction.inventory.customer_return.css')
@endsection

@section('content')
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 px-0">
                    <div class="page-header">
                        <h2 class="pageheader-title mt-2">Customer Return</h2>
                        <div class="page-breadcrumb mt-2">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb mb-0">
                                        <li class="breadcrumb-item">
                                            <a href="#" class="breadcrumb-link">Transaction</a>
                                        </li>
                                        <li class="breadcrumb-item">
                                            <a href="#" class="breadcrumb-link">Inventory</a>
                                        </li>
                                        <li class="breadcrumb-item active" aria-current="page">Customer Return</li>
                                    </ol>
                                </nav>
                                <a href="{{ url('/transaction/inventory/customer_return') }}"
                                    class="btn btn-sm btn-primary">
                                    <i class="fas fa-chevron-left mr-1"></i> Back
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-light mx-0">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div>
                                <label for="crDate" class="required">CR Date</label>
                                <input type="date" class="form-control form-control-sm" id="crDate">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 mt-2 mt-md-0 pl-0">
                            <div>
                                <label for="customerSelect" class="required">Customer</label>
                                <select id="customerSelect" class="form-control form-control-sm">
                                    <option value="">-- Select Customer</option>
                                    @foreach ($customers as $cust)
                                        <option value="{{ $cust->id }}">{{ $cust->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6 col-sm-12 mt-2 mt-md-0">
                            <div>
                                <label for="crTypeSelect" class="required">CR Type</label>
                                <select id="crTypeSelect" class="form-control form-control-sm">
                                    <option value="">-- Select CR Type</option>
                                    <option value="Replacement">Replacement</option>
                                    <option value="Replacement">Debit Note</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 mt-2 mt-md-0 pl-0">
                            <div>
                                <label for="returnDONumberInput" class="required">Return DO Number</label>
                                <input type="text" id="returnDONumberInput" class="form-control form-control-sm">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-end pr-3 mb-2">
                        <button class="btn btn-sm btn-outline-primary" id="searchDataBtn"><i class="fas fa-search mr-1"></i>
                            Search Data</button>
                    </div>
                    <table id="customerReturnCreateTable" class="table table-bordered">
                        <thead class="table-dark"></thead>
                    </table>
                    <hr>
                    <div class="mx-3">
                        <p class="text-bold fs-3 mb-2">List Item Added</p>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>PO Number</th>
                                    <th>CDS Code</th>
                                    <th>Part Code</th>
                                    <th>Part Name</th>
                                    <th>Part Number</th>
                                    <th>Business Type</th>
                                    <th>Model</th>
                                    <th>Unit</th>
                                    <th>Quantity</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyListAdded">
                                <tr>
                                    <td colspan="10">No data available in table</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4 d-flex justify-content-end mx-3">
                        <button type="button" id="btnSaveCR" class="btn btn-sm btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="modalAddItem">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Customer Return Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>DO Number</th>
                                <th>Item Code</th>
                                <th>Item Name</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody id="tbodyAddItem"></tbody>
                    </table>
                    <hr>
                    <div>
                        <label for="">Qty</label>
                        <input type="number" id="itemAddQty" step="any" class="form-control form-control-sm"
                            placeholder="0.00">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-sm btn-primary" id="itemBtnAdd">Add</button>
                </div>
            </div>
        </div>
    </div>
@endsection
