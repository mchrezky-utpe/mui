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
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">List</h5>
            <button id="add_button"  type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_modal">Receiving +</button>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              
<div class="table-container">
              <table class="table data-table-nowarps table-striped table-bordered first">
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
                <tbody> @foreach($data as $key => $value) 
                  <tr>
                    <td>{{ $value->do_doc_num }}</td>
                    <td>{{ $value->trans_date }}</td>
                    <td>{{ $value->department }}</td>
                    <td>{{ $value->supplier }}</td>
                    <td>{{ $value->po_doc_num }}</td>
                    <td>{{ $value->sds_doc_num }}</td>
                    <td>{{ $value->description }}</td>
                    <td>{{ $value->sku_description }}</td>
                    <td>{{ $value->sku_prefix }}</td>
                    <td>{{ $value->sku_specification_code }}</td>
                    <td>{{ $value->sku_type }}</td>
                    <td>{{ $value->qty }}</td>
                    <td>{{ $value->qty_outstanding }}</td>
                  </tr> 
                  @endforeach 
                </tbody>
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