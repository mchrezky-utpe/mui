@extends('template.main') @section('content') <div class="section__content section__content--p30">
  <div class="container-fluid">
    <div class="row">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-header">
          <h2 class="pageheader-title">SKU General Information</h2>
          <div class="page-breadcrumb">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="#" class="breadcrumb-link">Master</a>
                </li>
                <li class="breadcrumb-item">
                  <a href="#" class="breadcrumb-link">SKU</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">General Item</li>
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
              <button id="add_button" type="button" class="btn btn-primary btn_general_item" data-toggle="modal" data-target="#add_modal">+ General Item</button>
              <a href="{{ route('sku.export_general_item') }}" class="mr-2 btn btn-success">
                <i class="fas fa-file-excel"></i> Export Excel
              </a>
              </div>
           </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table data-table-item table-striped">
                <thead>
                  <tr> 
                    <th>No</th>
                    <th>Image</th>
                    <th>Item Code</th>
                    <th>Item Name</th>
                    <th>Spec code</th>
                    <th>Spec Description</th>
                    <th>Item Sub Category</th>
                    <th>Item Type</th>
                    <th>Procurement Type</th>
                    <th>Inventory Unit</th>
                    <th>Procurement Unit</th>
                    <th>Conversion value</th>
                    <th>Inv. Reg</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody> @foreach($data as $key => $value) <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>
                      @if($value->blob_image)
                      <img src="data:image/png;base64,{{ $value->blob_image }}" width="80">

                      @else
                        <span class="text-muted">No image</span>
                      @endif
                    </td>
                    <td>{{ $value->sku_id }}</td>
                    <td>{{ $value->sku_name }}</td>
                    <td>{{ $value->sku_specification_code }}</td>
                    <td>{{ $value->sku_specification_detail }}</td>
                    <td>{{ $value->sku_sub_category}}</td>
                    <td>{{ $value->sku_material_type }}</td>
                    <td>{{ $value->sku_procurement_type }}</td>
                    <td>{{ $value->sku_inventory_unit }}</td>
                    <td>{{ $value->sku_procurement_unit }}</td>
                    <td>{{ $value->val_conversion }}</td>
                    <td>{{ $value->flag_inventory_register == "1" ? 'YES' : 'NO' }}</td>
                    <td>
                      <form action="/sku-general-item/{{ $value->id }}/delete" method="post"> @csrf 
                      <div class="d-flex">
                        <button data-id="{{ $value->id }}" type="button" class="edit btn btn-success">
                          <span class="fas fa-pencil-alt"></span>
                        </button>
                        <button class="btn btn-danger">
                          <span class="fas fa-trash"></span>
                        </button>
                      </div>
                      </form>
                    </td>
                  </tr> @endforeach </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- MODAL --> 
 @include('master.sku_general_item._set_code') 
 @include('master.sku_general_item._add') 
 @include('master.sku_general_item._edit') 
 @endsection 
 
 @section('extra_javascript') 
 <script src="{{ asset('assets/js/master/sku_general_item.js') }}" type="text/javascript"></script> 
 @endsection