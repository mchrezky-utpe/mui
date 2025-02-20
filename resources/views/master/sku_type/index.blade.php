@extends('template.main') @section('content') <div class="section__content section__content--p30">
  <div class="container-fluid">
    <div class="row">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-header">
          <h2 class="pageheader-title">SKU  Type</h2>
          <div class="page-breadcrumb">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="#" class="breadcrumb-link">Master</a>
                </li>
                <li class="breadcrumb-item">
                  <a href="#" class="breadcrumb-link">SKU</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Type</li>
              </ol>
            </nav>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">List</h5>
            <button id="add_button"  type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_modal">Add +</button>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table data-table table-striped table-bordered first">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Code</th>
                    <th>Group Number</th>
                    <th>Category</th>
                    <th>Sub Category</th>
                    <th>Name</th>
                    <th>Extension</th>
                    <th>Classification</th>
                    <th>Trading</th>
                    <th>Primary</th>
                    <th>CS</th>
                    <th>CRS</th>
                    <th>Bom</th>
                    <th>Allowance</th>
                    <th>Allowance Value</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody> @foreach($data as $key => $value) <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $value->manual_id }}</td>
                    <td>{{ $value->group_tag }}</td>
                    <td>{{ $value->sku_category }}</td>
                    <td>{{ $value->sku_sub_category }}</td>
                    <td>{{ $value->description }}</td>
                    <td>{{ $value->prefix }}</td>
                    <td>{{ $value->sku_classification }}</td>
                    <td>{{ $value->trans_type }}</td>
                    <td>{{ $value->is_primary }}</td>
                    <td>{{ $value->is_checking }}</td>
                    <td>{{ $value->checking_result }}</td>
                    <td>{{ $value->is_bom }}</td>
                    <td>{{ $value->is_allowance }}</td>
                    <td>{{ $value->val_allowance }}</td>
                    <td>
                      <form action="/sku-type/{{ $value->id }}/delete" method="post"> @csrf 
                      <div class="d-flex">
                        <button data-id="{{ $value->id }}" type="button" class="edit btn btn-success">
                          <span class="fas fa-pencil-alt"></span>
                        </button>
                        <button class="btn btn-danger">
                          <span class="fas fa-trash"></span>
                        </button>
                    </div>
                      </form>
                    </td>
                  </tr> @endforeach </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- MODAL --> 
 @include('master.sku_type._add') 
 @include('master.sku_type._edit') 
 @endsection 
 
 @section('extra_javascript') 
 <script src="{{ asset('assets/js/master/sku_type.js') }}" type="text/javascript"></script> 
 @endsection