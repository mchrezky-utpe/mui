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
                                    Process
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
                            onclick="alert(`Fitur belum tresedia!`)"
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
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table
                                class="table data-table-item table-striped aaaaaa"
                            >
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Code</th>
                                        <th>Category</th>
                                        <th>Name</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                            @if (false)
                            <table
                                class="table data-table data-table-item table-striped table-bordered first"
                            >
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>ID</th>
                                        <th>Manual ID</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $key => $value)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $value->prefix }}</td>
                                        <td>{{ $value->manual_id }}</td>
                                        <td>{{ $value->description }}</td>
                                        <td>
                                            <form
                                                action="/sku-process/{{ $value->id }}/delete"
                                                method="post"
                                            >
                                                @csrf
                                                <button
                                                    data-id="{{ $value->id }}"
                                                    type="button"
                                                    class="edit btn btn-success"
                                                >
                                                    <span
                                                        class="fas fa-pencil-alt"
                                                    ></span>
                                                </button>
                                                <button class="btn btn-danger">
                                                    <span
                                                        class="fas fa-trash"
                                                    ></span>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- MODAL -->
<!-- @include('master.sku_process._add') @include('master.sku_process._edit') -->
@endsection @section('extra_javascript')
<!-- <script
    src="{{ asset('assets/js/master/sku_process.js') }}"
    type="text/javascript"
></script> -->
@endsection
