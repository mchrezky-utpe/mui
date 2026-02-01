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
                                        <li class="breadcrumb-item active" aria-current="page">
                                            Delivery Order
                                        </li>
                                    </ol>
                                </nav>

                                <div>
                                    <a href="{{ url('/transaction/inventory/delivery_order/create') }}"
                                        class="btn btn-sm btn-primary">
                                        <i class="fas fa-plus mr-1"></i> Create Customer DO
                                    </a>
                                    <a href="{{ url('/transaction/inventory/delivery_order') }}"
                                        class="btn btn-sm btn-primary">
                                        <i class="fas fa-plus mr-1"></i> Create Supplier DO
                                    </a>
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
                            <button class="nav-link active" id="nav-do-list" data-bs-toggle="tab" data-bs-target="#nav-do"
                                type="button" role="tab" aria-controls="nav-do" aria-selected="true">Delivery Order
                                List</button>
                            <button class="nav-link" id="nav-do-detail-list" data-bs-toggle="tab"
                                data-bs-target="#nav-do-detail" type="button" role="tab" aria-controls="nav-do-detail"
                                aria-selected="false">Delivery
                                Order Detail List</button>
                        </div>
                    </nav>
                </div>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-do" role="tabpanel" aria-labelledby="nav-do-list">
                        <div class="card-header bg-light mx-0">
                            <div class="row">
                                <div class="col-md-3 col-sm-12">
                                    <div>
                                        <label for="filterDOType" class="form-label">DO Type</label>
                                        <select name="" id="filterDOType" class="form-control form-control-sm">
                                            <option value="">-- Select DO Type</option>
                                            <option value="Regular">Regular</option>
                                            <option value="Replacement">Replacement</option>
                                            <option value="Sample Part">Sample Part</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12">
                                    <div>
                                        <label for="customerFilter">Customer</label>
                                        <select id="customerFilter" class="form-control form-control-sm">
                                            <option value="">-- Select Customer</option>
                                            @foreach ($customers as $cust)
                                                <option value="{{ $cust->id }}">{{ $cust->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12 mt-2 mt-md-0">
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
                            </div>
                            <div class="row mt-2 justify-content-end">
                                <div class="col-md-2 col-sm-12 d-flex align-items-end mt-2 mt-md-0">
                                    <button class="btn btn-sm btn-primary w-100" id="applyFilterDO">
                                        <i class="fas fa-filter mr-1"></i> Apply Filter
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="deliveryOrderTable" class="table table-bordered">
                                <thead class="table-dark">
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-do-detail" role="tabpanel" aria-labelledby="nav-do-detail-list">
                        <div class="card-header bg-light mx-0">
                            <div class="row">
                                <div class="col-md-3 col-sm-12">
                                    <div>
                                        <label for="filterDOTypeDetail" class="form-label">DO Type</label>
                                        <select name="" id="filterDOTypeDetail" class="form-control form-control-sm">
                                            <option value="">-- Select DO Type</option>
                                            <option value="Regular">Regular</option>
                                            <option value="Replacement">Replacement</option>
                                            <option value="Sample Part">Sample Part</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12">
                                    <div>
                                        <label for="customerFilterDetail">Customer</label>
                                        <select id="customerFilterDetail"class="form-control form-control-sm">
                                            <option value="">-- Select Customer</option>
                                            @foreach ($customers as $cust)
                                                <option value="{{ $cust->id }}">{{ $cust->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12 mt-2 mt-md-0">
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
                            </div>
                            <div class="row mt-2 justify-content-end">
                                <div class="col-md-2 col-sm-12 d-flex align-items-end mt-2 mt-md-0">
                                    <button class="btn btn-sm btn-primary w-100" id="applyFilterDODetail">
                                        <i class="fas fa-filter mr-1"></i> Apply Filter
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="deliveryOrderDetailTable" class="table table-bordered">
                                <thead class="table-dark">
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
