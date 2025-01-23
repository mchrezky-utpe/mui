@extends('template.main') @section('content') <div class="section__content section__content--p30">
  <div class="container-fluid">
    <div class="row">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-header">
          <h2 class="pageheader-title">General Deductor</h2>
          <div class="page-breadcrumb">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="#" class="breadcrumb-link">Master</a>
                </li>
                <li class="breadcrumb-item">
                  <a href="#" class="breadcrumb-link">General</a>
                </li>
                <li class="breadcrumb-item">
                  <a href="/general-terms" class="breadcrumb-link">Terms</a>
                </li>
                <li class="breadcrumb-item">
                  <a href="/general-department" class="breadcrumb-link">Department</a>
                </li>
                <li class="breadcrumb-item">
                  <a href="/general-currency" class="breadcrumb-link">Currency</a>
                </li>
                <li class="breadcrumb-item">
                  <a href="/general-tax" class="breadcrumb-link">Tax</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Deductor</li>
                <li class="breadcrumb-item">
                  <a href="/general-other-cost" class="breadcrumb-link">Other Cost</a>
                  <li class="breadcrumb-item">
                    <a href="/general-exchange-rates" class="breadcrumb-link">Exchange Rates</a>
                  </li>
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

          <div class="card-header d-flex justify-content-between align-items-center">
            <div>
            <h5 class="mb-0">List</h5>
            </div>
            <div>
              {{-- <a href="/general-deductor/index2"  class="btn btn-warning">list deleted</a> --}}
            <button id="add_button"  type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_modal">Add +</button>
            </div>
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
                    <th>App Module Id</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody> @foreach($data as $key => $value) <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $value->prefix }}</td>
                    <td>{{ $value->manual_id }}</td>
                    <td>{{ $value->description }}</td>
                    <td>{{ $value->app_module_id }}</td>
                    <td>
                      <form action="/general-deductor/{{ $value->id }}/delete" method="post" onsubmit="return confirm('Yakin ingin menghapus item ini?')"> @csrf 
                        <button data-id="{{ $value->id }}" type="button" class="edit btn btn-success">
                          <span class="fas fa-pencil-alt"></span>
                        </button>
                        <button type="submit" class="btn btn-danger">
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
 @include('master.general_deductor._add') 
 @include('master.general_deductor._edit') 
 @endsection 
 
 @section('extra_javascript') 
 <script src="{{ asset('assets/js/master/general_deductor.js') }}" type="text/javascript"></script> 
 @endsection