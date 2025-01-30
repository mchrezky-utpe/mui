@extends('template.main') @section('content') <div class="section__content section__content--p30">
    <div class="container-fluid">
      <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
          <div class="page-header">
            <h2 class="pageheader-title">General Factory Warehouse</h2>
            <div class="page-breadcrumb">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item">
                    <a href="#" class="breadcrumb-link">Master</a>
                  </li>
                  <li class="breadcrumb-item">
                    <a href="#" class="breadcrumb-link">Factory</a>
                  </li>
                  <li class="breadcrumb-item active" aria-current="page">Warehouse</li>
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
                <a href="/factory-warehouse"  class="btn btn-primary">list active</a>
              </div>
            </div>
  
            <div class="card-body">
              <div class="table-responsive">
                <table class="table data-table table-striped table-bordered first">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>ID</th>
                      <th>Manual ID</th>
                      <th>Description</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody> @foreach($data as $key => $value) <tr>
                      <td>{{ $loop->index + 1 }}</td>
                      <td>{{ $value->prefix }}</td>
                      <td>{{ $value->manual_id }}</td>
                      <td>{{ $value->description }}</td>
                      <td>
                        <div class="inline d-flex">
                          <form action="/factory-warehouse/{{ $value->id }}/restore" method="post" onsubmit="return confirm('Yakin ingin mengembalikan item ini?')">
                            @csrf
                            <!-- Tombol Hapus -->
                            <button type="submit" class="btn btn-warning mr-3">
                                Restore
                            </button>
                        </form>
                          <form action="/factory-warehouse/{{ $value->id }}/hapus" method="post" onsubmit="return confirm('Yakin ingin menghapus item ini?')">
                            @csrf
                            <!-- Tombol Hapus -->
                            <button type="submit" class="btn btn-danger">
                                <span class="fas fa-trash"></span>
                            </button>
                        </form>
                          </div>
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
   @endsection 
   
   @section('extra_javascript') 
   <script src="{{ asset('assets/js/master/factory_warehouse.js') }}" type="text/javascript"></script> 
   @endsection