@extends('template.main') @section('content') <div class="section__content section__content--p30">
<meta name="csrf-token" content="{{ csrf_token() }}"> 
<div class="container-fluid">
    <div class="row">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-header">
          <h2 class="pageheader-title">Purchase Request Approval</h2>
          <div class="page-breadcrumb">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="#" class="breadcrumb-link">Approval</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Purchase Request</li>
                </li>
              </ol>
            </nav>
          </div>
        </div>
      </div>
    </div>
    <div class="row">

      
      
      <div class="card-body">
        <div class="row mb-3">
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
            <div class="form-group">
              <label for="end_date">Status</label>
              <select type="date" class="form-control" id="flag_status" name="flag_status">
                  <option value>=== Status ===</option> 
                  <option value="1">Unchecked</option> 
                  <option value="2">Approved</option> 
                  <option value="3">Canceled</option> 
                  <option value="4">Suspended</option> 
              </select>
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
            <div>
            <h5 class="mb-0">List</h5>
            </div>
            <div>
              <button type="button" class="btn btn-success btn_action_approval" data-type="approve">Approve</button>
              <button type="button" class="btn btn-danger btn_action_approval" data-type="deny">Deny</button>
              <button type="button" class="btn btn-warning btn_action_approval"  data-type="hold">Hold</button>
            </div>
          </div>

          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped table-bordered first" id="table-pr">
                <thead>
                  <tr>
                    <th></th>
                    <th>No</th>
                    <th>PR Number</th>
                    <th>Supplier</th>
                    <th>Date</th>
                    <th>Description</th>
                    <th>Purpose</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                {{-- <tbody>
                   @foreach($data as $key => $value) <tr>
                    <td>
                      @if ($value->flag_status == 1)
                      <input type="checkbox" name="id" value="{{ $value->trans_pr_id }}"/>
                      @endif
                    </td>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $value->prefix }}</td>
                    <td>{{ $value->doc_num }}</td>
                    <td>{{ $value->supplier }}</td>
                    <td>{{ $value->trans_date }}</td>
                    <td>{{ $value->description }}</td>
                    <td>{{ $value->transaction_purpose }}</td>
                  @if ($value->flag_status == 2)
                    <td class="btn-success">
                  @elseif ($value->flag_status == 3)
                    <td  class="btn-danger">
                  @elseif ($value->flag_status == 4)
                    <td  class="btn-warning">
                    @else
                      <td>
                    @endif
                        {{ $value->transaction_status }}
                    </td>
                    <td>
                       <button data-id="{{ $value->trans_pr_id }}" type="button" class="btn_detail btn btn-info">
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
<!-- MODAL --> 
 @include('transaction.approval.purchase_request._approval') 
 @include('transaction.approval.purchase_request._approval_item') 
 @endsection 
 
 @section('extra_javascript') 
 <script src="{{ asset('assets/js/transaction/approval/purchase_request.js') }}" type="text/javascript"></script> 
 @endsection