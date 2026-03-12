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
                        <h2 class="pageheader-title mt-2">Stock view</h2>
                        <div class="page-breadcrumb mt-2">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="#" class="breadcrumb-link">Transaction</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="#" class="breadcrumb-link">Inventory</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Stock view</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <div class="d-flex align-items-center">
                        <div class="col-5">
                            <div class="d-flex align-items-center gap-3">
                                <label for="dateFilter" class="mb-0 mr-2">Date</label>
                                <input type="date" id="dateFilter" class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="d-flex align-items-center gap-3">
                                <label for="itemTypeFilter" class="text-nowrap mb-0 mr-2">Item Type</label>
                                <select id="itemTypeFilter" class="form-control form-control-sm">
                                    <option value="Part">Part</option>
                                    <option value="Production Material">Production Material</option>
                                    <option value="General Item">General Item</option>
                                    <option value="Returnable Packaging">Returnable Packaging</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-2">
                            <button class="btn btn-success" id="btnExport"><i class="fas fa-file-excel"></i>
                                Export</button>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table id="stockViewTable" class="table table-bordered">
                        <thead class="table-dark">
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
