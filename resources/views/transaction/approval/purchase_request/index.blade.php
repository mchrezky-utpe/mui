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
              <table class="table data-table table-striped table-bordered first">
                <thead>
                  <tr>
                    <th></th>
                    <th>No</th>
                    <th>ID</th>
                    <th>Doc Number</th>
                    <th>Supplier</th>
                    <th>Date</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody> @foreach($data as $key => $value) <tr>
                    <td>
                      @if ($value->flag_status === 1)
                      <input type="checkbox" name="id" value="{{ $value->trans_pr_id }}"/>
                      @endif
                    </td>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $value->prefix }}</td>
                    <td>{{ $value->doc_num }}</td>
                    <td>{{ $value->supplier }}</td>
                    <td>{{ $value->trans_date }}</td>
                    <td>{{ $value->description }}</td>
                    @if ($value->flag_status === 2)
                      <td class="btn-success">
                    @elseif ($value->flag_status === 3)
                      <td  class="btn-danger">
                    @elseif ($value->flag_status === 4)
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
 @include('transaction.approval.purchase_request._approval') 
 @include('transaction.approval.purchase_request._approval_item') 
 @endsection 
 
 @section('extra_javascript') 
 <script src="{{ asset('assets/js/transaction/approval/purchase_request.js') }}" type="text/javascript"></script> 
 @endsection