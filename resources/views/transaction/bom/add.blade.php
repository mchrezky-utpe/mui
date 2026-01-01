<meta name="csrf-token" content="{{ csrf_token() }}"> @extends('template.main') @section('content') <style>
  .table-container {
    max-height: 300px;
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
  
    .table-hover tbody tr:hover {
        background-color: rgba(13, 110, 253, 0.1);
        cursor: pointer;
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

  input[type="text"],
  select {
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
      <div class="col-md-6">
        <div class="form-group">
          <label for="dataName">Part Name:</label>
          <select required name="sku_id" id="sku_id" class="form-control"></select>
        </div>
        <div class="form-group">
          <label for="dataName">Part Code:</label>
          <input disabled type="text" id="part_code" name="part_code">
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="dataName">Model:</label>
          <input disabled type="text" id="model" name="model">
        </div>
        <div class="form-group">
          <label for="dataName">Remark:</label>
          <input type="text" id="description">
        </div>
        <div class="form-group">
          <button type="button" id="applyBtn" class="btn btn-primary">Apply</button>
          <button type="button" class="btn btn-danger" id="resetBtn">Reset</button>
        </div>
      </div>
    </div>

    <div class="row">
      <!-- Table Section -->
      <div class="col-md-12">
          <h5>MATERIAL : </h5>
          <div class="table-container">
              <table id="table-item" class="table table-striped table-hover">
                  <thead class="sticky-top bg-light">
                      <tr>
                          <th>Material Code</th>
                          <th>Material Name</th>
                          <th>Spec Code</th>
                          <th>Item Type</th>
                          <th>Unit</th>
                          <th>Supplier</th>
                          <th>Proc. Type</th>
                          <th>Curr</th>
                          <th>Price</th>
                          <th>Retail Price</th>
                          <th>Valid. Status</th>
                      </tr>
                  </thead>
                  <tbody>
                      <!-- Data akan diisi melalui JavaScript -->
                  </tbody>
              </table>
          </div>
      </div>
      
      <div class="tree-container">
        <h2>Result</h2>
        <div id="treeView">
          <p></p>
        </div>
      </div>
    </div>

    {{-- <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="dataName">Part Name:</label>
          <select required name="sku_id" id="sku_id" class="form-control"></select>
        </div>
        <div class="form-group">
          <label for="dataName">Part Code:</label>
          <input disabled type="text" id="part_code" name="part_code">
        </div>
        <div class="form-group">
          <label for="dataName">Model:</label>
          <input disabled type="text" id="model" name="model">
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="dataName">Qty each unit:</label>
          <input type="text" id="qty_each_unit">
        </div>
        <div class="form-group">
          <label for="dataName">Remark:</label>
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
        <div class="form-group">
          <button class="btn btn-success" id="addBtn">Add</button>
          <button class="btn btn-primary" id="saveBtn">Save</button>
        </div>
      </div>
      <div class="tree-container">
        <h2>Result</h2>
        <div id="treeView">
          <p></p>
        </div>
      </div>
    </div> --}}

  </div>
</div>
<!-- MODAL -->
@include('transaction.bom._add_item')
{{-- @include('transaction.bom._edit')
 @include('transaction.bom._edit') --}} 
 @endsection @section('extra_javascript') 
 <script type="module" src="{{ asset('assets/js/transaction/bom/add.js') }}" type="text/javascript"></script> 
 {{-- <script type="module" src="{{ asset('assets/js/transaction/bom/edit.js') }}" type="text/javascript"></script>  --}}
 @endsection