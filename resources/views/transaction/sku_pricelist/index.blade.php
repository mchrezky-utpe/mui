<meta name="csrf-token" content="{{ csrf_token() }}">
@extends('template.main') @section('content') <div class="section__content section__content--p30">
  <div class="container-fluid">
    <div class="row">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-header">
          <h2 class="pageheader-title">SKU Pricelist</h2>
          <div class="page-breadcrumb">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="#" class="breadcrumb-link">Transaction</a>
                </li>
                <li class="breadcrumb-item">
                  <a href="#" class="breadcrumb-link">SKU</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Pricelist</li>
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
            <div class="d-flex">
            <button id="add_button"  type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_modal">+ Production Material Prices</button>
            <button id="add_general_item_button" type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_general_item_modal">+ General Item Prices</button>
          </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table  id="table-pagination" class="table table-striped table-bordered first">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Item Code</th>
                    <th>Item Name</th>
                    <th>Item Type</th>
                    <th>Procurement Unit</th>
                    <th>Currency</th>
                    <th>Price</th>
                    <th>Retail Price</th>
                    <th>Status</th>
                    <th>Valid From</th>
                    <th>Valid Until</th>
                    <th>Valid Status</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody> 
                  {{-- @foreach($data as $key => $value) <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $value->sku_id }}</td>
                    <td>{{ $value->sku_name }}</td>
                    <td>{{ $value->sku_type }}</td>
                    <td>{{ $value->sku_procurement_unit }}</td>
                    <td>{{ $value->currency }}</td>
                    <td>{{ $value->price }}</td>
                    <td>{{ $value->price_retail }}</td>
                    <td>{{ $value->pricelist_status }}</td>
                    <td>{{ $value->valid_date_from }}</td>
                    <td>{{ $value->valid_date_to }}</td>
                    <td>{{ $value->valid_date_status}}</td>
                    <td>
                    <div class="d-flex">
                      <form action="/sku-pricelist/{{ $value->id }}/delete" method="post"> @csrf 
                      <div class="d-flex">
                        <button data-prs_supplier_id="{{ $value->prs_supplier_id}}"  data-item_id="{{ $value->item_id }}"  type="button" class="history btn btn-secondary">
                          <span class="fas fa-list"></span>
                      </button>
                        <button data-id="{{ $value->id }}" type="button" class="edit btn btn-success">
                          <span class="fas fa-pencil-alt"></span>
                        </button>
                        <button class="btn btn-danger">
                          <span class="fas fa-trash"></span>
                        </button>
                      </form>
                    </td>
                  </tr> @endforeach  --}}
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
{{-- <form id="form_modal" autocomplete="off" class="form-horizontal" method="post" action="/sku-pricelist">
 </form>   --}}
  
<!-- MODAL --> 
 @include('transaction.sku_pricelist._history') 
 @include('transaction.sku_pricelist._add_general_item') 
 @include('transaction.sku_pricelist._add') 
 @include('transaction.sku_pricelist._edit') 
 @endsection 
 
 @section('extra_javascript') 
 <script src="{{ asset('assets/js/transaction/sku_pricelist.js') }}" type="text/javascript"></script> 
 @endsection