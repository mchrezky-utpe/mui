<meta name="csrf-token" content="{{ csrf_token() }}">
@extends('template.main') @section('content') <div class="section__content section__content--p30">
  <div class="container-fluid">
    <div class="row">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-header">
          <h2 class="pageheader-title">Packaging Information</h2>
          <div class="page-breadcrumb">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="#" class="breadcrumb-link">Master</a>
                </li>
                <li class="breadcrumb-item">
                  <a href="#" class="breadcrumb-link">Packaging Information</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Partition</li>
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
              <table id="table-data" class="table table-striped table-bordered first">
                <thead>
                  <tr>
                    <th>PCP Code</th>
                    <th>Sub Category</th>
                    <th>Partition Type</th>
                    <th>Partition Name</th>
                    <th>Partition Size</th>
                    <th>Partition Capacity</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody> 
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
 @include('master.packaging_information_partition._add') 
 @include('master.packaging_information_partition._edit') 
 @endsection 
 
 @section('extra_javascript') 
 <script src="{{ asset('assets/js/master/packaging_information_partition.js') }}" type="text/javascript"></script> 
 @endsection