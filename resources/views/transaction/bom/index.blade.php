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
          <h2 class="pageheader-title">Bill Of Material</h2>
          <div class="page-breadcrumb">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="#" class="breadcrumb-link">Transaction</a>
                </li>
                <li class="breadcrumb-item">
                  <a href="#" class="breadcrumb-link">Item</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Bill Of Material</li>
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
            <a href="/bom/add" class="btn btn-primary">Add +</a>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table id="table-bom" class="table table-striped table-bordered first">
                <thead>
                  <tr>
                    <th colspan="5" style="text-align:center">Part Information</th>
                    <th colspan="3" style="text-align:center">BOM Status</th>
                    <th></th>
                  </tr>
                  <tr>
                    <th>BOM Number</th>
                    <th>Part Code</th>
                    <th>Part Name</th>
                    <th>Model</th>
                    <th>Remark</th>
                    <th>Verification</th>
                    <th>Status</th>
                    <th>Main Priority</th>
                    <th></th>
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

 @include('transaction.bom._add')
 {{-- @include('transaction.bom._edit')
 @include('transaction.bom._add')
 @include('transaction.bom._edit') --}}
 @endsection

 @section('extra_javascript')
 <script  type="module" src="{{ asset('assets/js/master/bom.js') }}" type="text/javascript"></script>
 @endsection
