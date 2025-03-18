@extends('template.main') @section('content') <div class="section__content section__content--p30">
  <meta name="csrf-token" content="{{ csrf_token() }}"> 
  <style>
    .table-responsive {
          max-height: 400px; 
          overflow-y: auto;
          border: 1px solid #ccc;
          overflow-x: auto;
      }
       .table-responsive table {
          max-width: 150%;
          width: 80%;
          overflow-x: auto;
          border-collapse: collapse;
      } 
  </style>
  <div class="container-fluid">
    <div class="row">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-header">
          <h2 class="pageheader-title">Stock View</h2>
          <div class="page-breadcrumb">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="#" class="breadcrumb-link">Transaction</a>
                </li>
                <li class="breadcrumb-item">
                  <a href="#" class="breadcrumb-link">Stock View</a>
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
            
           <div class="col-md-3">
              <div class="form-group">
                {{-- <button id="add_button"  type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_modal">Sync</button> --}}
                <br>      
                <label>Date:</label>
                <input name="date" type="date" class="form-control"value="<?php print(date("Y-m-d")); ?>" />
              </div>
            </div>
            <div class="col-md-3">
            <div class="form-group">
              <label>Item Type:</label>
              <input type="text" class="form-control" />
            </div>
          </div>
        
        </div>
          <div class="card-body">
            <div class="table-responsive">
              <table id="table_stock_view" class="table table-striped table-bordered first">
                <thead>
                  <tr>
                    <th>Date</th>
                    <th>Item Code</th>
                    <th>Group Code</th>
                    <th>Item Name</th>
                    <th>Spesification Code</th>
                    <th>Item Type</th>
                    <th>Item Classication</th>
                    <th>Sales Category</th>
                    <th>Unit</th>
                    <th>Warehouse</th>
                    <th>Suppliers</th>
                    <th>Min</th>
                    <th>Max</th>
                    <th>MSR</th>
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
 @endsection 
 
 @section('extra_javascript') 
 <script src="{{ asset('assets/js/transaction/stock_view.js') }}" type="text/javascript"></script> 
 @endsection