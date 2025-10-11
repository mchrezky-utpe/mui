<meta name="csrf-token" content="{{ csrf_token() }}">
@extends('template.main') @section('content') 
<style>
  .table-container {
        max-height: 400px; 
        overflow-y: auto;
        border: 1px solid #ccc;
        overflow-x: auto;
    }
/* 
    .table-container table {
      max-width: 150%;
        width: 150%;
        border-collapse: collapse;
    } */
</style>

<div class="section__content section__content--p30">
  <div class="container-fluid">
    <div class="row">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-header">
          <h2 class="pageheader-title">Suplier Delivery Order</h2>
          <div class="page-breadcrumb">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="#" class="breadcrumb-link">Transaction</a>
                </li>
                <li class="breadcrumb-item">
                  <a href="#" class="breadcrumb-link">Receiving</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">SDO</li>
              </ol>
            </nav>
          </div>
        </div>
      </div>
    </div>
    <div class="row"> 
       
      <div class="card-body">
        <div class="mb-3 row">
          <div class="col-md-3">
            <div class="form-group">
              <label for="start_date">Start Date</label>
              <input type="date" class="form-control" id="start_date" name="start_date">
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="end_date">End Date</label>
              <input type="date" class="form-control" id="end_date" name="end_date">
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group" style="margin-top: 32px;">
              <button type="button" id="btn-filter" class="btn btn-primary">
                <i class="fas fa-search"></i> Filter </button>
              <button type="button" id="btn-reset" class="btn btn-secondary">
                <i class="fas fa-sync"></i> Reset </button>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">List</h5>
              <div class="d-flex">
              <button id="add_button"  type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_modal">Receiving +</button>
              <a href="{{ route('sdo.export') }}" class="mr-2 btn btn-success">
                <i class="fas fa-file-excel"></i> Export Excel
              </a>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              
<div class="table-container">
              <table id="table_sdo" class="table table-striped table-bordered first">
                <thead>
                  <tr>
                    <th>Do Number</th>
                    <th>Do Date</th>
                    <th>Department</th>
                    <th>Supplier</th>
                    <th>Po Number</th>
                    <th>SDS Number</th>
                    <th>Description</th>
                    <th>Item Name</th>
                    <th>Item Code</th>
                    <th>Spec Code</th>
                    <th>Item Type</th>
                    <th>Qty</th>
                    <th>OS Qty</th>
                  </tr>
                </thead>
                </table>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- MODAL -->
 @include('transaction.sdo._detail') 
 @include('transaction.sdo._add') 
 @include('transaction.sdo._qty_sds') 
 @include('transaction.sdo._reschedule') 
 @endsection 
 
 @section('extra_javascript') 
 <script  type="module" src="{{ asset('assets/js/transaction/sdo/sdo_main.js') }}" type="text/javascript"></script> 
 @endsection