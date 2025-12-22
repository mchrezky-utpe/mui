@extends('template.main') @section('content') <div class="section__content section__content--p30">
 <meta name="csrf-token" content="{{ csrf_token() }}">
  <div class="container-fluid">
    <div class="row">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-header">
          <h2 class="pageheader-title">Customer Delivery Destination</h2>
          <div class="page-breadcrumb">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="#" class="breadcrumb-link">Material Details</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Customer Delivery Destintation</li>
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
             <a href="/customer"  class="btn btn-warning">Back</a>
            <button id="add_button"  type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_modal">Add +</button>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table  class="data-table-nowarps table-striped table-bordered first">
                <thead>
                  <tr>
                      <th>DD Code</th>
                      <th>Customer Name</th>
                      <th>Customer Code</th>
                      <th>Destination Code</th>
                      <th>Destination Name</th>
                      <th>Destination Address</th>
                      <th>Destination Type</th>
                      <th>Destination Status</th>
                  </tr>
                </thead>
                 <tbody> 
                  @foreach($data as $key => $value) <tr>
                    <td>{{ $value->prefix }}</td>
                    <td>{{ $value->customer_code }}</td>
                    <td>{{ $value->customer_name }}</td>
                    <td>{{ $value->destination_code }}</td>
                    <td>{{ $value->destination_name }}</td>
                    <td>{{ $value->destination_address }}</td>
                    <td>{{ $value->destination_type }}</td>
                    <td>{{ $value->destination_status }}</td>
                    </td>
                  </tr> @endforeach 
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
 @include('master.person_customer._add_delivery') 
 @endsection 
 
 @section('extra_javascript') 
 {{-- <script src="{{ asset('assets/js/master/person_customer.js') }}" type="text/javascript"></script>  --}}
 @endsection