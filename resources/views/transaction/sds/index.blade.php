<meta name="csrf-token" content="{{ csrf_token() }}">
@extends('template.main') @section('content') 
<style>
  .table-container {
        max-height: 400px; 
        overflow-y: auto;
        border: 1px solid #ccc;
        overflow-x: auto;
    }

    .table-container table {
      max-width: 150%;
        width: 150%;
        border-collapse: collapse;
    }
</style>

<div class="section__content section__content--p30">
  <div class="container-fluid">
    <div class="row">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-header">
          <h2 class="pageheader-title">Suplier Delivery Schedule</h2>
          <div class="page-breadcrumb">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="#" class="breadcrumb-link">Transaction</a>
                </li>
                <li class="breadcrumb-item">
                  <a href="#" class="breadcrumb-link">Sds</a>
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
            <h5 class="mb-0">List</h5>
            <button id="add_button"  type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_modal">Add +</button>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              
<div class="table-container">
              <table id="table_sds" class="table table-striped table-bordered first">
                <thead>
                  <tr>
                    <th></th>
                    <th>SDS Date</th>
                    <th>SDS Number</th>
                    <th>Department</th>
                    <th>Supplier</th>
                    <th>SDS</th>
                    <th>Rev</th>
                    <th>EDI</th>
                    <th>Delivery</th>
                    <th>Shipment</th>
                    <th>Reschedule</th>
                    <th>Date Reschdule</th>
                    <th>Date Revision</th>
                  </tr>
                </thead>
                <tbody> @foreach($data as $key => $value) <tr data-id="{{ $value->id }}">
                    <td>
                       <div class="btn-group" role="group">
                        <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Action
                        </button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                       
                        @if ( $value->is_sent_to_edi  == 0 && $value->flag_status == 1)
                        <form action="/sds/send-to-edi?id={{$value->id}}" method="post"> 
                        @csrf 
                              <button class="dropdown-item .send_to_edit" href="#">Send To EDI</button>
                          </form>
                          @else 
                          <button disabled class="dropdown-item send_to_edi" href="#">Send To EDI</button>
                          @endif
                            
                        @if ($value->flag_status === 1 && $value->is_sent_to_edi  == 0)
                          <form action="/sds/pull-back?id={{$value->id}}" method="post"> 
                            @csrf 
                              <button class="dropdown-item btn_pullback" href="#">Pull Back</button>
                          </form>
                          @else 
                          <button disabled class="dropdown-item" href="#">Pull Back</button>
                        @endif
                    
                          @if ($value->flag_status == 3)
                          <form action="/sds/reschedule?id={{$value->id}}" method="post"> 
                            @csrf 
                              <button type="button" data-id="{{$value->id}}" class="dropdown-item btn_reschedule" href="#">Reschedule</button>
                          </form>
                          @else 
                          <button disabled class="dropdown-item" href="#">Reschedule</button>
                        @endif
                        </div>
                      </div>
                    </td>
                    <td>{{ $value->trans_date }}</td>
                    <td>{{ $value->doc_num }}</td>
                    <td>{{ $value->department }}</td>
                    <td>{{ $value->supplier }}</td>
                    <td>{{ $value->sds_status }}</td>
                    <td>{{ $value->rev_counter }}</td>
                    <td>{{ $value->status_sent_to_edi }}</td>
                    <td>{{ $value->sds_delivery }}</td>
                    <td>{{ $value->sds_shipment }}</td>
                    <td>{{ $value->status_reschedule }}</td>
                    <td>{{ $value->rev_date }}</td>
                    <td>{{ $value->date_reschedule }}</td>
                  </tr> @endforeach </tbody>
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
 @include('transaction.sds._add') 
 @include('transaction.sds._edit') 
 @include('transaction.sds._qty_sds') 
 @include('transaction.sds._reschedule') 
 @endsection 
 
 @section('extra_javascript') 
 <script  type="module" src="{{ asset('assets/js/transaction/sds/sds_main.js') }}" type="text/javascript"></script> 
 @endsection