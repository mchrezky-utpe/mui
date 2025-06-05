@extends('template.main') @section('content') <div class="section__content section__content--p30">
  <div class="container-fluid">
    <div class="row"> 
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-header">
          <h2 class="pageheader-title">Production Process Information</h2>
          <div class="page-breadcrumb">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="#" class="breadcrumb-link">Transaction</a>
                </li>
                <li class="breadcrumb-item">
                  <a href="#" class="breadcrumb-link">Production</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Production Process Information</li>
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
            <div>
            <h5 class="mb-0">List</h5>
            </div>
            <div>
              <!-- <a href="/person-supplier/index2"  class="btn btn-warning">list deleted</a> -->
            {{-- <button id="add_button"  type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_modal">Add +</button> --}}
            {{-- <a href="{{ route('employee.export.pdf') }}" class="btn btn-danger">Export PDF</a> --}}
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table data-table table-striped table-bordered first">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Item Code</th>
                    <th>Item Name</th>
                    <th>Item Type</th>
                    <th>Process Type</th>
                    <th>Process Classification</th>
                    <th>Checking Input</th>
                    <th>Item Size</th>
                    <th>Line Part Code</th>
                    <th>SA</th>
                    <th>Weight</th>
                    <th>Qty. Standard</th>
                    <th>Qty. Target</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody> @foreach($data as $key => $value) <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $value->sku_id }}</td>
                    <td>{{ $value->sku_name }}</td>
                    <td>{{ $value->sku_material_type }}</td>
                    <td>{{ $value->process_type }}</td>
                    <td>{{ $value->flag_process_classification == 1 ? 'Regular' : 'Satin' }}</td>
                    <td>{{ $value->flag_checking_input_method == 1 ? 'Normal' : 'Hourly' }}</td>
                    <td>{{ $value->flag_item_size_category == 1 ? 'Small' : 'Big' }}</td>
                    <td>{{ $value->line_part_code }}</td>
                    <td>{{ $value->surface_area }}</td>
                    <td>{{ $value->weight}}</td>
                    <td>{{ $value->qty_standard}}</td>
                   <td>{{ $value->qty_target}}</td>
                    @if ($value->flag_status === 1)
                        <td class="btn-success" align="center"> Aktif
                    @elseif ($value->flag_status === 2)
                        <td class="btn-danger"> Gagal
                    @else
                        <td>
                    @endif
                    <td>
                      <form action="/production_process/{{ $value->id }}/delete" method="post" onsubmit="return confirm('Yakin ingin menghapus item ini?')"> @csrf 
                        <button data-id="{{ $value->id }}" type="button" class="edit btn btn-success">
                          <span class="fas fa-pencil-alt"></span>
                        </button>
                        {{-- <button type="submit" class="btn btn-danger">
                          <span class="fas fa-trash"></span>
                        </button> --}}
                      </form>
                    </td>
                  </tr> @endforeach</tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- MODAL --> 
 @include('transaction.production_process._add') 
 @include('transaction.production_process._edit') 
 @endsection 
 
 @section('extra_javascript') 
 <script src="{{ asset('assets/js/transaction/production_process/production_process.js') }}" type="text/javascript"></script> 
 @endsection