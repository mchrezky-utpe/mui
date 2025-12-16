@extends('template.main') @section('content')
<div class="section__content section__content--p30">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h2 class="pageheader-title">SKU Process</h2>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="#" class="breadcrumb-link"
                                        >Master</a
                                    >
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="#" class="breadcrumb-link">SKU</a>
                                </li>
                                <li
                                    class="breadcrumb-item active"
                                    aria-current="page"
                                >
                                    Process Classification
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div
                        class="card-header d-flex justify-content-between align-items-center"
                    >
                        <h5 class="mb-0">List</h5>
                        <button
                            id="add_button"
                            type="button"
                            class="btn btn-primary"
                        >
                            Add +
                        </button>
                        <!-- <button
                            id="add_button"
                            type="button"
                            class="btn btn-primary"
                            data-toggle="modal"
                            data-target="#add_modal"
                        >
                            Add +
                        </button> -->

                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="">
                            <div
                                class="container-fluid"
                                style="overflow-x: auto"
                            >
                                <table
                                    class="table data-table-item table-striped"
                                >
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Code</th>
                                            <th>Process Type</th>
                                            <th>Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div hidden>
        <form id="form-remove" action="" method="POST">@csrf</form>
    </div>
</div>
<!-- MODAL -->
@include('master.sku_process_classification._add')
<!-- @include('master.sku_process._add') @include('master.sku_process._edit') -->
@endsection @section('extra_javascript')
<script
    src="{{ asset('assets/js/master/sku_process_classification.js') }}"
    type="text/javascript"
></script>
@endsection
