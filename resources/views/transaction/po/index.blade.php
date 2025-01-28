<meta name="csrf-token" content="{{ csrf_token() }}">
@extends('template.main') @section('content') 
<style>
  .table-container {
        max-height: 400px; 
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
              <table id="table-po" class="table table-striped table-bordered first">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Manual ID</th>
                    <th>Doc Number</th>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Supplier</th>
                    <th>Description</th>
                    <!-- <th>Total</th> -->
                    <th>Action</th>
                  </tr>
                </thead>
                <!-- <tbody> @foreach($data as $key => $value) <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $value->manual_id }}</td>
                    <td>{{ $value->doc_num }}</td>
                    <td>{{ $value->flag_type == 1 ? 'Produciton Project Material' : 'General Item' }}</td>
                    <td>{{ $value->supplier->description ?? 0 }}</td>
                    <td>{{ $value->description  }}</td>
                    <td>{{ 0 }}</td>
                    <td>
                      <form action="/po/{{ $value->id }}/delete" method="post" onsubmit="return confirm('Yakin ingin menghapus item ini?')"> @csrf 
                        <button data-id="{{ $value->id }}" type="button" class="edit btn btn-success">
                          <span class="fas fa-pencil-alt"></span>
                        </button>
                        <button type="submit" class="btn btn-danger">
                          <span class="fas fa-trash"></span>
                        </button>
                      </form>
                    </td>
                  </tr> @endforeach 
                </tbody> -->
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
 @endsection 
 
 @section('extra_javascript') 
 <script  type="module" src="{{ asset('assets/js/transaction/purchase_order/po_main.js') }}" type="text/javascript"></script> 
 @endsection