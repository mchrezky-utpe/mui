@extends('template.main')

@section('extra-css')
    @include('transaction.sales.sales_invoice.css')
@endsection

@section('content')
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 px-0">
                    <div class="page-header">
                        <h2 class="pageheader-title mt-2">Sales Invoice</h2>
                        <div class="page-breadcrumb mt-2">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb mb-0">
                                        <li class="breadcrumb-item">
                                            <a href="#" class="breadcrumb-link">Transaction</a>
                                        </li>
                                        <li class="breadcrumb-item">
                                            <a href="#" class="breadcrumb-link">Sales</a>
                                        </li>
                                        <li class="breadcrumb-item active" aria-current="page">
                                            Sales Invoice
                                        </li>
                                    </ol>
                                </nav>

                                <div>
                                    <button type="button" class="btn btn-sm btn-primary" onclick="showCreateModal()">
                                        <i class="fas fa-plus mr-1"></i> Create Sales Invoice
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-light border-bottom-0 pb-0">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="nav-si-list" data-bs-toggle="tab" data-bs-target="#nav-si"
                                type="button" role="tab" aria-controls="nav-si" aria-selected="true">Sales Invoice
                                List</button>
                            <button class="nav-link" id="nav-si-detail-list" data-bs-toggle="tab"
                                data-bs-target="#nav-si-detail" type="button" role="tab" aria-controls="nav-si-detail"
                                aria-selected="false">Sales Invoice Detail List</button>
                        </div>
                    </nav>
                </div>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-si" role="tabpanel" aria-labelledby="nav-si-list">
                        <div class="card-header bg-light mx-0">
                            <div class="row d-flex align-items-end">
                                <div class="col-md-3 col-sm-12">
                                    <div>
                                        <label for="fromDateFilter">From</label>
                                        <input type="date" id="fromDateFilter" class="form-control form-control-sm">
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12 mt-2 mt-md-0">
                                    <div>
                                        <label for="untilDateFilter">Until</label>
                                        <input type="date" id="untilDateFilter" class="form-control form-control-sm">
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12 mt-2 mt-md-0">
                                    <div>
                                        <label for="currencyFilter">Currency</label>
                                        <select id="currencyFilter" class="form-control form-control-sm select2">
                                            <option value="">-- Select Currency</option>
                                            @foreach ($currency as $cur)
                                                <option value="{{ $cur->prefix }}">{{ $cur->prefix }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12 mt-2 mt-md-0">
                                    <button class="btn btn-sm btn-primary w-100" id="applyFilterSI">
                                        <i class="fas fa-filter mr-1"></i> Apply Filter
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="salesInvoiceListTable" class="table table-bordered">
                                <thead class="table-dark">
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-si-detail" role="tabpanel" aria-labelledby="nav-si-detail-list">
                        <div class="card-header bg-light mx-0">
                            <div class="row d-flex align-items-end">
                                <div class="col-md-3 col-sm-12">
                                    <div>
                                        <label for="fromDateFilterDetail">From</label>
                                        <input type="date" id="fromDateFilterDetail"
                                            class="form-control form-control-sm">
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12 mt-2 mt-md-0">
                                    <div>
                                        <label for="untilDateFilterDetail">Until</label>
                                        <input type="date" id="untilDateFilterDetail"
                                            class="form-control form-control-sm">
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12 mt-2 mt-md-0">
                                    <div>
                                        <label for="currencyFilterDetail">Currency</label>
                                        <select id="currencyFilterDetail" class="form-control form-control-sm select2">
                                            <option value="">-- Select Currency</option>
                                            @foreach ($currency as $cur)
                                                <option value="{{ $cur->prefix }}">{{ $cur->prefix }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12 mt-2 mt-md-0">
                                    <button class="btn btn-sm btn-primary w-100" id="applyFilterSIDetail">
                                        <i class="fas fa-filter mr-1"></i> Apply Filter
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="salesInvoiceDetailListTable" class="table table-bordered">
                                <thead class="table-dark">
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="modalCreate">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Sales Invoice</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-4 pl-0">
                            <label for="invoiceTypeSelect">Invoice Type</label>
                            <select id="invoiceTypeSelect" class="form-control select2-create">
                                <option value="">-- Select Invoice Type</option>
                                <option value="Regular">Regular</option>
                                <option value="Partial">Partial</option>
                            </select>
                        </div>
                        <div class="col-4">
                            <label for="invoicePhaseSelect">Invoice Phase</label>
                            <select id="invoicePhaseSelect" class="form-control select2-create">
                                <option value="">-- Select Invoice Phase</option>
                                <option value="Down Payment">Down Payment</option>
                                <option value="2nd Payment">2nd Payment</option>
                                <option value="3rd Payment">3rd Payment</option>
                                <option value="Final Payment">Final Payment</option>
                            </select>
                        </div>
                        <div class="col-4 pr-0">
                            <label for="invoiceDateInput">Invoice Date</label>
                            <input type="date" id="invoiceDateInput" class="form-control form-control-sm"
                                value="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-4 pl-0">
                            <label for="invoiceNumberInput">Invoice Number</label>
                            <input type="text" id="invoiceNumberInput" class="form-control form-control-sm"
                                value="{{ date('y') . '/MUI/' . date('m') }}">
                        </div>
                        <div class="col-4">
                            <label for="taxNumberInput">Tax Number</label>
                            <input type="text" id="taxNumberInput" class="form-control form-control-sm">
                        </div>
                        <div class="col-4 pr-0">
                            <label for="customerSelect">Customer</label>
                            <select id="customerSelect" class="form-control select2-create">
                                <option value="">-- Select Customer</option>
                                @foreach ($customers as $cust)
                                    <option value="{{ $cust->id }}">{{ $cust->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-4 pl-0">
                            <label for="currencySelect">Currency</label>
                            <select id="currencySelect" class="form-control select2-create">
                                <option value="">-- Select Currency</option>
                                @foreach ($currency as $curr)
                                    <option value="{{ $curr->prefix }}">{{ $curr->prefix }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-4 pr-0 mt-2 mt-md-0">
                            <label for="exchangeRateInput">Exchange Rate</label>
                            <input type="text" id="exchangeRateInput"
                                class="form-control form-control-sm decimal-input" disabled>
                        </div>
                        <div class="col-4 pr-0">
                            <label for="kmkDateInput">KMK Date</label>
                            <input type="date" id="kmkDateInput" class="form-control form-control-sm"
                                value="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-6 pl-0">
                            <label for="kmkNumberInput">KMK Number</label>
                            <input type="text" id="kmkNumberInput" class="form-control form-control-sm">
                        </div>
                        <div class="col-6 pr-0">
                            <label for="topInput">TOP</label>
                            <select id="topInput" class="form-control select2-create">
                                <option value="">-- Select TOP</option>
                                <option value="30 Days After Received Invoice">30 Days After Received Invoice</option>
                                <option value="45 Days After Received Invoice">45 Days After Received Invoice</option>
                                <option value="60 Days After Received Invoice">60 Days After Received Invoice</option>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <p>List DO</p>
                    <div class="d-flex justify-content-between mb-2">
                        <div class="d-flex align-items-center">
                            <div class="form-check form-check-inline d-flex align-items-center mr-3">
                                <input class="form-check-input" type="radio" name="searchTypeRadio" id="radioDo"
                                    value="doNumber" checked>
                                <label class="form-check-label mb-0 ml-1" for="radioDo">
                                    DO Number
                                </label>
                            </div>

                            <div class="form-check form-check-inline d-flex align-items-center">
                                <input class="form-check-input" type="radio" name="searchTypeRadio" id="radioPart"
                                    value="part">
                                <label class="form-check-label mb-0 ml-1" for="radioPart">
                                    Part
                                </label>
                            </div>
                        </div>
                        <button class="btn btn-sm btn-outline-primary" id="searchDataButton">Search</button>
                    </div>

                    <table class="table table-bordered" id="listItemTable">
                        <thead class="table-dark"></thead>
                    </table>
                    <hr>
                    <p class="mb-2">List Invoice Items</p>
                    <div class="table-fixed mx-3">
                        <table class="table" id="listInvoiceItems">
                            <thead>
                                <tr>
                                    <th>PO Number</th>
                                    <th>CDS Number</th>
                                    <th>DO Date</th>
                                    <th>DO Number</th>
                                    <th>Item Code</th>
                                    <th style="width:200px;">Item Name</th>
                                    <th>Part Number</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyListInvoiceItems">
                                <tr>
                                    <td colspan="11" class="text-center">No data available</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="container-fluid mt-3">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row align-items-center mb-2">
                                    <div class="col-6">
                                        <div class="d-flex align-items-center flex-nowrap">
                                            <input type="checkbox" class="mr-2" id="ppnCheck">
                                            <label class="mb-0 mr-2" style="width:70px;">PPN</label>
                                            <input type="number"
                                                class="form-control form-control-sm mr-2 bg-white number-default-zero"
                                                style="width:50px;" value="11" id="ppnInput"
                                                onchange="calculatePPN(); calculateGrandTotal();" disabled>
                                            <span>%</span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" class="form-control form-control-sm bg-white"
                                            value="0" id="ppnAmountInput" readonly>
                                    </div>
                                </div>
                                <div class="row align-items-center mb-2">
                                    <div class="col-6">
                                        <div class="d-flex align-items-center flex-nowrap">
                                            <input type="checkbox" class="mr-2" id="discountCheck">
                                            <label class="mb-0 mr-2" style="width:70px;">Discount</label>
                                            <input type="number"
                                                class="form-control form-control-sm mr-2 bg-white number-default-zero"
                                                style="width:50px;" value="0" id="discountInput"
                                                onchange="calculateDiscount(); calculateGrandTotal();" disabled>
                                            <span>%</span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" class="form-control form-control-sm bg-white"
                                            value="0" id="discountAmountInput" readonly>
                                    </div>
                                </div>
                                <div class="row align-items-center mb-2">
                                    <div class="col-6">
                                        <div class="d-flex align-items-center">
                                            <label class="mb-0" style="width:110px;">Total Services</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" class="form-control form-control-sm decimal-input"
                                            id="totalServiceInput" value="0" onchange="calculateGrandTotal();">
                                    </div>
                                </div>
                                <div class="row align-items-center mb-2">
                                    <div class="col-6">
                                        <div class="d-flex align-items-center flex-nowrap">
                                            <input type="checkbox" class="mr-2" id="pphCheck">
                                            <label class="mb-0 mr-2 text-nowrap" style="width:70px;">PPH 23</label>
                                            <input type="number"
                                                class="form-control form-control-sm mr-2 bg-white number-default-zero"
                                                id="pphInput" style="width:50px;" value="2"
                                                onchange="calculatePPH(); calculateGrandTotal();" disabled>
                                            <span>%</span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" class="form-control form-control-sm bg-white"
                                            value="0" id="pphAmountInput" readonly>
                                    </div>
                                </div>
                                <div class="row align-items-center">
                                    <div class="col-6">
                                        <div class="d-flex align-items-center flex-nowrap">
                                            <input type="checkbox" class="mr-2" id="partialPayCheck">
                                            <label class="mb-0 mr-2 text-nowrap" style="width:70px;">Partial Pay.</label>
                                            <input type="number"
                                                class="form-control form-control-sm mr-2 bg-white number-default-zero"
                                                id="partialPayInput" style="width:50px;" value="2"
                                                onchange="calculatePartialPay(); calculateTotalPayment();" disabled>
                                            <span>%</span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" class="form-control form-control-sm bg-white"
                                            value="0" id="partialPayAmountInput" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Sub Total</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control form-control-sm bg-white"
                                            id="subTotalInput" value="0" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Total</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control form-control-sm bg-white"
                                            id="totalInput" value="0" readonly>
                                    </div>
                                </div>
                                <div class="form-group row mb-1">
                                    <label class="col-sm-4 col-form-label">Grand Total</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control form-control-sm bg-white"
                                            id="grandTotalInput" value="0" readonly>
                                    </div>
                                </div>
                                <div class="form-group row mb-1">
                                    <label class="col-sm-4 col-form-label">Total Payment</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control form-control-sm bg-white"
                                            id="totalPaymentInput" value="0" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-sm btn-primary" id="createSubmitBtn">Save</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra_javascript')
    @include('transaction.sales.sales_invoice.script')
@endsection
