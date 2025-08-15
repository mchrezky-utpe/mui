{{-- <meta name="csrf-token" content="{{ csrf_token() }}">
@extends('template.main') @section('content') --}}

<x-modals.modal id="edit_modal" title="Edit Production">
  <form id="form_modal" autocomplete="off" class="form-horizontal" method="post" action="/person-employee/edit">
      @csrf
      <input type="hidden" name="id" />       
      <div class="form-group">
        <label for="dataName">Name</label>
        <input class="form-control" id="dataName" type="text" placeholder="Name">
      </div>
      <div class="form-group">
        <label for="dataValue">Desc</label>
        <input class="form-control"  id="dataValue" type="text" placeholder="Desc">
      </div>
      <div class="form-group" id="levelGroup">
        <label for="level">Gender</label>
        <select required name="level" class="form-control" id="level">
          <option value="1">Level 1</option>
        </select>
      </div>
      <div class="form-group" id="parentGroup">
        <label for="parent">Parent</label>
        <select required name="parent" class="form-control" id="parent">
        </select>
      </div>
    </form>   
  </x-modals.modal>

{{-- <div id="edit_modal" class="section__content section__content--p30">
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
        <div class="form-group">
            <label for="dataName">Name:</label>
            <input type="text" id="dataName" placeholder="Enter Name">
        </div>
        
        <div class="form-group">
            <label for="dataValue">Desc:</label>
            <input type="text" id="dataValue" placeholder="Enter Desc">
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
        
        <button class="btn btn-success" id="addBtn">Add Data</button>
        <button class="btn btn-primary" id="saveBtn">Save Data</button>
        
        <div class="tree-container">
            <h2>Result</h2>
            <div id="treeView">
                <p></p>
            </div>
        </div>
    </div>
    </div>
  </div>
</div> --}}
<!-- MODAL -->
 {{-- @include('transaction.bom._edit')
 @include('transaction.bom._add')
 @include('transaction.bom._edit') --}}
 {{-- @endsection

 @section('extra_javascript')
 <script  type="module" src="{{ asset('assets/js/transaction/bom/edit.js') }}" type="text/javascript"></script>
 @endsection --}}
