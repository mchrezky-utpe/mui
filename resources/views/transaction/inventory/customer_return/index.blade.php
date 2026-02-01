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
                                <a href="{{ url('/transaction/inventory/customer_return/create') }}"
                                    class="btn btn-sm btn-primary">
                                    <i class="fas fa-plus mr-1"></i> Create Customer Return
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-light border-bottom-0 pb-0">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="nav-cr-list" data-bs-toggle="tab" data-bs-target="#nav-cr"
                                type="button" role="tab" aria-controls="nav-cr" aria-selected="true">Customer Return
                                List</button>
                            <button class="nav-link" id="nav-cr-detail-list" data-bs-toggle="tab"
                                data-bs-target="#nav-cr-detail" type="button" role="tab" aria-controls="nav-cr-detail"
                                aria-selected="false">Customer Return Detail List</button>
                        </div>
                    </nav>
                </div>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-cr" role="tabpanel" aria-labelledby="nav-cr-list">
                        <div class="card-header bg-light mx-0">
                            <div class="row">
                                <div class="col-md-3 col-sm-12 pl-0">
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
                                <div class="col-md-3 col-sm-12 mt-2 mt-md-0 pl-0">
                                    <div>
                                        <label for="fromDateFilter">From</label>
                                        <input type="date" id="fromDateFilter" class="form-control form-control-sm">
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12 mt-2 mt-md-0 pl-0">
                                    <div>
                                        <label for="untilDateFilter">Until</label>
                                        <input type="date" id="untilDateFilter" class="form-control form-control-sm">
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12 mt-2 mt-md-0 pl-0 d-flex align-items-end">
                                    <button class="btn btn-sm btn-primary w-100" id="applyFilterCR">
                                        <i class="fas fa-filter mr-1"></i> Apply Filter
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="customerReturnTable" class="table table-bordered">
                                <thead class="table-dark">
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-cr-detail" role="tabpanel" aria-labelledby="nav-cr-detail">
                        <div class="card-header bg-light mx-0">
                            <div class="row">
                                <div class="col-md-3 col-sm-12 pl-0">
                                    <div>
                                        <label for="customerFilterDetail">Customer</label>
                                        <select id="customerFilterDetail" class="form-control form-control-sm">
                                            <option value="">-- Select Customer</option>
                                            @foreach ($customers as $cust)
                                                <option value="{{ $cust->id }}">{{ $cust->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12 mt-2 mt-md-0 pl-0">
                                    <div>
                                        <label for="fromDateFilterDetail">From</label>
                                        <input type="date" id="fromDateFilterDetail"
                                            class="form-control form-control-sm">
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12 mt-2 mt-md-0 pl-0">
                                    <div>
                                        <label for="untilDateFilterDetail">Until</label>
                                        <input type="date" id="untilDateFilterDetail"
                                            class="form-control form-control-sm">
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12 mt-2 mt-md-0 pl-0 d-flex align-items-end">
                                    <button class="btn btn-sm btn-primary w-100" id="applyFilterCRDetail">
                                        <i class="fas fa-filter mr-1"></i> Apply Filter
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="customerReturnDetailTable" class="table table-bordered">
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
