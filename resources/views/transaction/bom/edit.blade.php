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


<style>
  body {
      font-family: Arial, sans-serif;
      margin: 20px;
      line-height: 1.6;
  }
  .container {
      max-width: 800px;
      margin: 0 auto;
  }
  .form-group {
      margin-bottom: 15px;
  }
  label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
  }
  input[type="text"], select {
      width: 100%;
      padding: 8px;
      border: 1px solid #ddd;
      border-radius: 4px;
      box-sizing: border-box;
  }
  .tree-container {
      margin-top: 30px;
      border: 1px solid #ddd;
      padding: 15px;
      border-radius: 4px;
  }
  .tree-node {
      margin-left: 20px;
      padding: 5px 0;
      border-left: 2px solid #ddd;
      padding-left: 10px;
      margin-bottom: 5px;
  }
  .tree-node .node-label {
      font-weight: bold;
  }
  .tree-node .node-value {
      color: #555;
  }
  .node-actions {
      margin-left: 10px;
  }
  .save-section {
      margin-top: 20px;
      padding: 15px;
      background-color: #f5f5f5;
      border-radius: 4px;
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
                <li class="breadcrumb-item active" aria-current="page">Bill Of Material(Bom)</li>
              </ol>
            </nav>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="container">
          <h2>BOM : </h2>
        
          <input name="data_saved" value="{{ json_encode($data->details) }}" type="hidden" s/>

          <h4>{{ $data->header->sku_id }} - {{ $data->header->sku_name }}</h4>
            <input type="hidden" id="bom_id" value="{{ $data->header->id }}">
        <div class="form-group">
        </div>
        <div class="form-group">
            <label for="dataName">Part Name:</label>
          <select  required name="sku_id" id="sku_id" class="form-control">
          </select >
        </div>

        <div class="form-group">
            <label for="dataName">Qty capacity:</label>
            <input type="text" id="qty_capacity">
        </div>

        <div class="form-group">
            <label for="dataName">Qty each unit:</label>
            <input type="text" id="qty_each_unit">
        </div>

        <div class="form-group">
            <label for="dataName">Description:</label>
            <input type="text" id="description">
        </div>
        
        <div class="form-group" id="levelGroup">
            <label for="level">Level:</label>
            <select id="level">
                <option value="1">Level 1</option>
            </select>
        </div>
        
        <div class="form-group" id="parentGroup" style="display: none;">
            <label for="parent">Parent:</label>
            <select id="parent"></select>
        </div>
        
        <button class="btn btn-success" id="addBtn">Add</button>
        <button class="btn btn-primary" id="saveBtn">Save</button>
        
        <div class="tree-container">
            <h2>Result</h2>
            <div id="treeView">
                <p></p>
            </div>
        </div>
    </div>
    </div>
  </div>
</div>
<!-- MODAL -->
 {{-- @include('transaction.bom._edit')
 @include('transaction.bom._add')
 @include('transaction.bom._edit') --}}
 @endsection

 @section('extra_javascript')
 <script  type="module" src="{{ asset('assets/js/transaction/bom/edit.js') }}" type="text/javascript"></script>
 @endsection
