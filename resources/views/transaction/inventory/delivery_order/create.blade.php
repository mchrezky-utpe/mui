@extends('template.main')

@section('extra-css')
    @include('transaction.inventory.delivery_order.css')
@endsection

@section('content')
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 px-0">
                    <div class="page-header">
                        <h2 class="pageheader-title mt-2">Delivery Order</h2>
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
                                        <li class="breadcrumb-item">
                                            <a href="#" class="breadcrumb-link">Delivery Order</a>
                                        </li>
                                        <li class="breadcrumb-item active" aria-current="page">
                                            Create
                                        </li>
                                    </ol>
                                </nav>

                                <a href="{{ url('/transaction/inventory/delivery_order') }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-chevron-left mr-1"></i> Back
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <div class="row">
                    <div class="col-9">
                        <div class="row">
                            <div class="col-md-4 col-sm-6 pl-0">
                                <label for="doDateInput" class="required">DO Date</label>
                                <input type="date" id="doDateInput" class="form-control form-control-sm">
                            </div>
                            <div class="col-md-4 col-sm-6 mt-2 mt-md-0 pl-0">
                                <label for="customerInput" class="required">Customer Name</label>
                                <select id="customerInput" class="form-control form-control-sm">
                                    <option value="">-- Select Customer</option>
                                    @foreach ($customer as $cust)
                                        <option value="{{ $cust->id }}">{{ $cust->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 col-sm-6 mt-2 mt-md-0 pl-0">
                                <label for="doOfficerInput" class="required">DO Officer</label>
                                <input type="text" id="doOfficerInput" class="form-control form-control-sm"
                                    value="ANDRIYANI" readonly>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4 col-sm-6 pl-0">
                                <label for="doTypeSelect" class="required">DO Type</label>
                                <select id="doTypeSelect" class="form-control form-control-sm">
                                    <option value="">-- Select DO Type</option>
                                    <option value="Regular">Regular</option>
                                    <option value="Replacement">Replacement</option>
                                    <option value="Sample Part">Sample Part</option>
                                </select>
                            </div>
                            <div class="col-md-4 col-sm-6 mt-2 mt-md-0 pl-0">
                                <label for="doDestinationSelect" class="required">Destination</label>
                                <div class="d-flex">
                                    <select id="doDestinationSelect" class="form-control form-control-sm col-9 mr-2">
                                        <option value="">-- Select Destination</option>
                                    </select>
                                    <input type="text" id="destinationCode" class="col-3" readonly>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 mt-2 mt-md-0 pl-0">
                                <label for="vrpSelect" class="required">VRP</label>
                                <select id="vrpSelect" class="form-control form-control-sm">
                                    <option value="">-- Select VRP</option>
                                    @foreach ($vehicles as $vehicle)
                                        <option value="{{ $vehicle->id }}">{{ $vehicle->license_plate }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4 col-sm-6 mt-2 mt-md-0 pl-0">
                                <label for="subDoTypeSelect" class="required">Sub DO Type</label>
                                <select id="subDoTypeSelect" class="form-control form-control-sm">
                                    <option value="">-- Select DO Sub Type</option>
                                    <option value="Part">Part</option>
                                    <option value="Production Material">Production Material</option>
                                    <option value="General Item">General Item</option>
                                </select>
                            </div>
                            <div class="col-md-4 col-sm-6 mt-2 mt-md-0 pl-0">
                                <label for="destinationAddress" class="required">Address</label>
                                <input type="text" id="destinationAddress" class="form-control form-control-sm" readonly>
                            </div>
                            <div class="col-md-4 col-sm-6 mt-2 mt-md-0 pl-0">
                                <label for="driverSelect" class="required">Driver Name</label>
                                <select id="driverSelect" class="form-control form-control-sm">
                                    <option value="">-- Select Driver</option>
                                    @foreach ($drivers as $driver)
                                        <option value="{{ $driver->id }}">{{ $driver->driver_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-3 pl-0">
                        <label for="noteInput">Delivery Note</label>
                        <textarea id="noteInput" class="form-control form-control-sm" cols="30" rows="7"></textarea>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="d-flex justify-content-end pr-3 mb-2">
                    <button class="btn btn-sm btn-outline-primary" id="searchDataBtn"><i class="fas fa-search mr-1"></i>
                        Search Data</button>
                </div>
                <table id="deliveryOrderCreateTable" class="table table-bordered">
                    <thead class="table-dark"></thead>
                    <tbody></tbody>
                </table>
                <hr>
                <div class="mx-3">
                    <p class="text-bold fs-3 mb-2">List Item Added</p>
                    <table id="deliveryOrderListAdded" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>PO Number</th>
                                <th>CDS Code</th>
                                <th>Item Code</th>
                                <th>Item Name</th>
                                <th>Part Number</th>
                                <th>Business Type</th>
                                <th>Model</th>
                                <th>Quantity</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="tbodyListAdded">
                            <tr>
                                <td colspan="9">No data available in table</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 d-flex justify-content-end mx-3">
                    <button type="button" id="btnSaveDO" class="btn btn-sm btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="modalAddItem">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Delivery Order Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Item Code</th>
                                <th>Item Name</th>
                                <th>Quantity</th>
                                <th>SA</th>
                            </tr>
                        </thead>
                        <tbody id="tbodyAddItem"></tbody>
                    </table>
                    <hr>
                    <input type="hidden" id="itemAddId">
                    <input type="hidden" id="itemAddType">
                    <div>
                        <label for="">Qty</label>
                        <input type="number" id="itemAddQty" step="any" class="form-control form-control-sm"
                            placeholder="0.00">
                    </div>
                    <div class="d-flex g-2 mt-2">
                        <div class="col-4 pl-0">
                            <label for="">Quantity / Package</label>
                            <input type="text" id="itemAddQtyPerPackage" class="form-control form-control-sm"
                                readonly>
                        </div>
                        <div class="col-4">
                            <label for="">Total Packaging</label>
                            <input type="text" id="itemAddQtyTotalPackage" class="form-control form-control-sm"
                                readonly>
                        </div>
                        <div class="col-4 pr-0">
                            <label for="">Stock Packaging</label>
                            <input type="text" id="itemAddQtyStockPackage" class="form-control form-control-sm"
                                readonly>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-sm btn-primary" id="itemBtnAdd" disabled>Add</button>
                </div>
            </div>
        </div>
    </div>
@endsection
