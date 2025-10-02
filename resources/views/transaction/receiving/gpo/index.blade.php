<meta name="csrf-token" content="{{ csrf_token() }}">
@extends('template.main') @section('content') 
<style>
  .table-container {
        max-height: 400px; 
        overflow-y: auto;
        border: 1px solid #ccc;
        overflow-x: auto;
    }

    /* .table-container table {
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
          <h2 class="pageheader-title">General Purchase Order</h2>
          <div class="page-breadcrumb">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="#" class="breadcrumb-link">Transaction</a>
                </li>
                <li class="breadcrumb-item">
                  <a href="#" class="breadcrumb-link">Receiving</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">GPO</li>
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
              <a href="{{ route('general_purchase_order.export') }}" class="mr-2 btn btn-success">
                <i class="fas fa-file-excel"></i> Export Excel
              </a>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              
<div class="table-container">
              <table id="table-gpo" class="table table-striped table-bordered first">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Receiving Date</th>
                    <th>DO Number</th>
                    <th>GPO Type</th>
                    <th>PO Number</th>
                    <th>Item Code</th>
                    <th>Item Name</th>
                    <th>Spesification Code</th>
                    <th>Item Type</th>
                    <th>Unit</th>
                    <th>Qty Order</th>
                    <th>Outstanding</th>
                    <th></th>
                  </tr>
                </thead>
                {{-- <tbody> @foreach($data as $key => $value) 
                  <tr>
                    <td>{{ $value->trans_date }}</td>
                    <td>{{ $value->doc_num }}</td>
                    <td>{{ $value->supplier }}</td>
                    <td>
                      <button data-id="{{ $value->id }}" type="button" class="btn_detail btn btn-info">
                        <span class="fas fa-eye"></span>
                      </button>
                    </td>
                  </tr> @endforeach 
                </tbody> --}}
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
 @include('transaction.receiving.gpo._detail') 
 @include('transaction.receiving.gpo._add') 
 @include('transaction.receiving.gpo._edit') 
 @include('transaction.receiving.gpo._qty_sds') 
 @endsection 
 
 @section('extra_javascript') 
 <script  type="module" src="{{ asset('assets/js/transaction/receiving/gpo/gpo_main.js') }}" type="text/javascript"></script> 
 @endsection