@extends('template.main') @section('content') 
<style>
    /* Tambahkan gaya untuk membuat scroll */
  .table-container {
        max-height: 400px; /* Sesuaikan tinggi maksimum sesuai kebutuhan */
        overflow-y: auto;
        border: 1px solid #ccc;
        overflow-y: auto;
    }

    .table-container table {
        width: 100%;
        border-collapse: collapse;
    }
</style>

<div class="section__content section__content--p30">
  <div class="container-fluid">
    <div class="row">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-header">
          <h2 class="pageheader-title">Purchase Order</h2>
          <div class="page-breadcrumb">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="#" class="breadcrumb-link">Transaction</a>
                </li>
                <li class="breadcrumb-item">
                  <a href="#" class="breadcrumb-link">Purchase</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Purchase Order(PO)</li>
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
              <table class="table data-table table-striped table-bordered first">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>ID</th>
                    <th>Manual ID</th>
                    <th>Doc Number</th>
                    <th>Type</th>
                    <th>Supplier</th>
                    <th>Description</th>
                    <th>Total</th>
                    <th>Action</th>
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
<!-- MODAL --> 
 @include('transaction.po._add') 
 @include('transaction.po._edit') 
 @include('transaction.po._other_cost') 
 @endsection 
 
 @section('extra_javascript') 
 <script src="{{ asset('assets/js/transaction/po.js') }}" type="text/javascript"></script> 
 @endsection