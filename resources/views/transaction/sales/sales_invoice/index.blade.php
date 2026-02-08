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
                            <label for="InvoicePhaseSelect">Invoice Phase</label>
                            <select id="InvoicePhaseSelect" class="form-control select2-create">
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
                                value="Auto Generate" readonly>
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
                                    <option value="{{ $curr->id }}">{{ $curr->prefix }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-4 pr-0 mt-2 mt-md-0">
                            <label for="exchangeRateInput">Exchange Rate</label>
                            <input type="text" id="exchangeRateInput" class="form-control form-control-sm" readonly>
                        </div>
                        <div class="col-4 pr-0">
                            <label for="kmkDateInput">KMK Date</label>
                            <input type="date" id="kmkDateInput" class="form-control form-control-sm"
                                value="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-6 pl-0">
                            <label for="kmkNumber">KMK Number</label>
                            <input type="text" id="kmkNumber" class="form-control form-control-sm">
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
