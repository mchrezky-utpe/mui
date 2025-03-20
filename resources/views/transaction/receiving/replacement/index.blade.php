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
          <h2 class="pageheader-title">Replacement</h2>
          <div class="page-breadcrumb">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="#" class="breadcrumb-link">Transaction</a>
                </li>
                <li class="breadcrumb-item">
                  <a href="#" class="breadcrumb-link">Receiving</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Replacement</li>
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
              <table id="table_sds" class="table table-striped table-bordered first">
                <thead>
                  <tr>
                    <th>Receiving Date</th>
                    <th>DO Number</th>
                    <th>Supplier</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody> @foreach($data as $key => $value) 
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
 @include('transaction.receiving.replacement._add') 
 @include('transaction.receiving.replacement._edit') 
 @include('transaction.receiving.replacement._qty_sds') 
 @include('transaction.receiving.replacement._reschedule') 
 @endsection 
 
 @section('extra_javascript') 
 <script  type="module" src="{{ asset('assets/js/transaction/receiving/replacement/replacement_main.js') }}" type="text/javascript"></script> 
 @endsection