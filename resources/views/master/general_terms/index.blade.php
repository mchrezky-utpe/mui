@extends('template.main') @section('content') <div class="section__content section__content--p30">
<style>
  .table-container {
        max-height: 350px; 
        overflow-y: auto;
        border: 1px solid #ccc;
        overflow-y: auto;
    }

    .table-container table {
        width: 100%;
        border-collapse: collapse;
    }
</style>  
<div class="container-fluid">
    <div class="row">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-header">
          <h2 class="pageheader-title">General Terms</h2>
          <div class="page-breadcrumb">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="#" class="breadcrumb-link">Master</a>
                </li>
                <li class="breadcrumb-item">
                  <a href="#" class="breadcrumb-link">General</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Terms</li>
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
              <!-- <a href="/general-terms/index2"  class="btn btn-warning">list deleted</a> -->
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
                    <th>Term Code</th>
                    <th>Description</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody> @foreach($data as $key => $value) <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $value->prefix }}</td>
                    <td>{{ $value->manual_id }}</td>
                    <td>{{ $value->description }}</td>
                    <td>
                      <form action="/general-terms/{{ $value->id }}/delete" method="post" onsubmit="return confirm('Yakin ingin menghapus item ini?')"> @csrf 
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
 @include('master.general_terms._add') 
 @include('master.general_terms._edit') 
 @endsection 
 
 @section('extra_javascript') 
 <script src="{{ asset('assets/js/master/general_terms.js') }}" type="text/javascript"></script> 
 @endsection