<meta name="csrf-token" content="{{ csrf_token() }}">
@extends('template.main') @section('content') 
<style>
  .table-container {
    max-height: 400px;
    overflow-y: auto;
    border: 1px solid #ccc;
    overflow-x: auto;
  }

  .table-container table {
    max-width: 150%;
    width: 150%;
    border-collapse: collapse;
  }
</style>

<div class="section__content section__content--p30">
  <div class="container-fluid">
    <div class="row">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-header">
          <h2 class="pageheader-title">Suplier Delivery Schedule</h2>
          <div class="page-breadcrumb">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="#" class="breadcrumb-link">Transaction</a>
                </li>
                <li class="breadcrumb-item">
                  <a href="#" class="breadcrumb-link">Sds</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Main</li>
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
            <div class="form-group">
              <label for="end_date">Status</label>
              <select type="date" class="form-control" id="status" name="flag_status">
                  <option value>=== Status ===</option> 
                  <option value="1">Open</option> 
                  <option value="2">Close</option> 
                  <option value="3">Pulled Back</option> 
                  <option value="4">Rescheduled</option> 
              </select>
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
            <button id="add_button"  type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_modal">Add +</button>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              
          <div class="table-container">
              <table id="table_sds" class="table  table-striped table-bordered first">
                <thead>
                  <tr>
                    <th></th>
                    <th>SDS Number</th>
                    <th>SDS Date</th>
                    <th>Department</th>
                    <th>Supplier</th>
                    <th>SDS</th>
                    <th>Rev</th>
                    <th>EDI</th>
                    <th>Delivery</th>
                    <th>Shipment</th>
                    <th>Reschedule</th>
                    <th>Date Reschdule</th>
                    <th>Date Revision</th>
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
 @include('transaction.sds._add') 
 @include('transaction.sds._edit') 
 @include('transaction.sds._qty_sds') 
 @include('transaction.sds._reschedule') 
 @include('transaction.sds.sds_item') 
 @endsection 
 
 @section('extra_javascript') 
 <script  type="module" src="{{ asset('assets/js/transaction/sds/sds_main.js') }}" type="text/javascript"></script> 
 @endsection