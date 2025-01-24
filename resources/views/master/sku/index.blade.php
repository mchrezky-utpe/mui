@extends('template.main') @section('content') <div class="section__content section__content--p30">
  <div class="container-fluid">
    <div class="row">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-header">
          <h2 class="pageheader-title">SKU</h2>
          <div class="page-breadcrumb">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="#" class="breadcrumb-link">Master</a>
                </li>
                <li class="breadcrumb-item">
                  <a href="#" class="breadcrumb-link">SKU</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Main</li>
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
            <button id="add_button" type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_modal">Add +</button>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table data-table table-striped table-bordered first">
                <thead>
                  <tr> 
                    <th>No</th>
                    <th>ID</th>
                    <th>Manual ID</th>
                    <th>Description</th>
                    <th>Detail</th>
                    <th>Type</th>
                    <th>Unit</th>
                    <th>Model</th>
                    <th>Packaging</th>
                    <th>Process</th>
                    <th>Business</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody> @foreach($data as $key => $value) <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $value->prefix }}</td>
                    <td>{{ $value->manual_id }}</td>
                    <td>{{ $value->description }}</td>
                    <td>{{ $value->detail?->description }}</td>
                    <td>{{ $value->type?->description }}</td>
                    <td>{{ $value->unit?->description }}</td>
                    <td>{{ $value->model?->description }}</td>
                    <td>{{ $value->packaging?->description }}</td>
                    <td>{{ $value->process?->description }}</td>
                    <td>{{ $value->business?->description }}</td>
                    <td>
                      <form action="/sku/{{ $value->id }}/delete" method="post"> @csrf 
                        <button data-id="{{ $value->id }}" type="button" class="edit btn btn-success">
                          <span class="fas fa-pencil-alt"></span>
                        </button>
                        <button class="btn btn-danger">
                          <span class="fas fa-trash"></span>
                        </button>
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
 @include('master.sku._add') 
 @include('master.sku._edit') 
 @endsection 
 
 @section('extra_javascript') 
 <script src="{{ asset('assets/js/master/sku.js') }}" type="text/javascript"></script> 
 @endsection