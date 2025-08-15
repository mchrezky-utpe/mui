@extends('template.main') @section('content') <div class="section__content section__content--p30">
  <div class="container-fluid">
    <div class="row">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-header">
          <h2 class="pageheader-title">SKU</h2>
          <div class="page-breadcrumb">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="#" class="breadcrumb-link">Master</a>
                </li>
                <li class="breadcrumb-item">
                  <a href="#" class="breadcrumb-link">SKU</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Part Information</li>
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
              <button id="add_button" type="button" class="btn btn-primary btn_part_information" data-toggle="modal" data-target="#add_modal">+ Part Information</button>
              <a href="{{ route('sku.export') }}" class="mr-2 btn btn-success">
                <i class="fas fa-file-excel"></i> Export Excel
              </a>
              </div>
           </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table data-table table-striped table-bordered first">
                <thead>
                  <tr> 
                    <th>No</th>
                    <th>Image</th>
                    <th>Item Code</th>
                    <th>Type</th>
                    <th>Item Name</th>
                    <th>Item Type</th>
                    <th>Business Type</th>
                    <th>Sales Category</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody> @foreach($data as $key => $value) <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>
                      @if($value->blob_image)
                      <img src="{{ asset($value->blob_image) }}" width="80">

                      @else
                        <span class="text-muted">No image</span>
                      @endif
                    </td>
                    <td>{{ $value->sku_id }}</td>
                    <td>
                    @if($value->flag_sku_type  == 1)         
                          Finished Goods
                    @elseif($value->flag_sku_type  == 2)  
                          Production material   
                    @else
                          General Item        
                    @endif  

                    </td>
                    <td>{{ $value->sku_name }}</td>
                    <td>{{ $value->sku_material_type }}</td>
                    <td>{{ $value->sku_business_type }}</td>
                    <td>{{ $value->sku_sales_category }}</td>
                    <td>
                      {{-- <form action="/sku-part-information/{{ $value->id }}/delete" method="post">
                        @csrf
                        @method('DELETE')
                        <div class="d-flex">
                            <button data-id="{{ $value->id }}" type="button" class="edit btn btn-success">
                                <span class="fas fa-pencil-alt"></span>
                            </button>
                            <button type="submit" class="btn btn-danger">
                                <span class="fas fa-trash"></span>
                            </button>
                        </div>
                    </form> --}}
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
 @include('master.sku_part_information._set_code') 
 @include('master.sku_part_information._add') 
 @include('master.sku_part_information._edit') 
 @endsection 
 
 @section('extra_javascript') 
 <script src="{{ asset('assets/js/master/sku.js') }}" type="text/javascript"></script> 
 @endsection