@extends('template.main') @section('content') <div class="section__content section__content--p30">
 <meta name="csrf-token" content="{{ csrf_token() }}">
  <div class="container-fluid">
    <div class="row">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-header">
          <h2 class="pageheader-title">Customer</h2>
          <div class="page-breadcrumb">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="#" class="breadcrumb-link">Material Details</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Customer</li>
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
              <!-- <a href="/person-customer/index2"  class="btn btn-warning">list deleted</a> -->
            <button id="add_button"  type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_modal">Add +</button>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table id="table-data" class="tabl table-striped table-bordered first">
                <thead>
                  <tr>
                      <th>Code</th>
                      <th>Name</th>
                      <th>Initials</th>
                      <th>Office Address</th>
                      <th>Phone</th>
                      <th>Fax</th>
                      <th>Email</th>
                      <th>NPWP</th>
                      <th>CP Name</th>
                      <th>CP Phone</th>
                      <th>CP Email</th>
                      <th>Action</th>
                  </tr>
                </thead>
                 <tbody> 
                  {{-- @foreach($data as $key => $value) <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $value->prefix }}</td>
                    <td>{{ $value->manual_id }}</td>
                    <td>{{ $value->description }}</td>
                    <td>
                      <form action="/person-customer/{{ $value->id }}/delete" method="post" onsubmit="return confirm('Yakin ingin menghapus item ini?')"> @csrf 
                        <button data-id="{{ $value->id }}" type="button" class="edit btn btn-success">
                          <span class="fas fa-pencil-alt"></span>
                        </button>
                        <button type="submit" class="btn btn-danger">
                          <span class="fas fa-trash"></span>
                        </button>
                      </form>
                    </td>
                  </tr> @endforeach  --}}
                </tbody> 
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- MODAL --> 
 @include('master.person_customer._add') 
 @include('master.person_customer._edit') 
 @endsection 
 
 @section('extra_javascript') 
 <script src="{{ asset('assets/js/master/person_customer.js') }}" type="text/javascript"></script> 
 @endsection