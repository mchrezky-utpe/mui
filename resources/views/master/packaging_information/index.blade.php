@extends('template.main')

@section('extra-css')
    @include('master.packaging_information.css')
@endsection

@section('content')
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row mb-3">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 px-0">
                    <div class="page-header">
                        <h2 class="pageheader-title mt-2">Packaging Information</h2>
                        <div class="page-breadcrumb mt-2">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item">
                                        <a href="#" class="breadcrumb-link">Master</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Packaging Information
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <table id="packagingInformationTable" class="table table-bordered">
                        <thead class="table-dark">
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="modalUpdate">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Packaging Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="updateId">
                    <div>
                        <label for="selectCategory" class="required">Packaging Category</label>
                        <select id="selectCategory" class="select2-update">
                            <option value="">Select Packaging Category</option>
                            @foreach ($packagingCategory as $category)
                                <option value="{{ $category->id }}">{{ $category->description }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mt-2">
                        <label for="selectPartition" class="required">Packaging Partition</label>
                        <select id="selectPartition" class="select2-update">
                            <option value="">Select Packaging Partition</option>
                            @foreach ($packagingPartition as $partition)
                                <option value="{{ $partition->id }}">{{ $partition->description }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mt-2">
                        <label for="qtyPerPartition" class="required">Qty Per Partition</label>
                        <input type="number" id="qtyPerPartition" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-sm btn-primary" id="updateSubmitBtn">Save</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra_javascript')
    @include('master.packaging_information.script')
@endsection
