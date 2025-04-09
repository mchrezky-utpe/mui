@extends('template.main') @section('content') <div class="section__content section__content--p30">
  <div class="container-fluid">
    <div class="row">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-header">
          <h2 class="pageheader-title">PERSON Employee</h2>
          <div class="page-breadcrumb">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="#" class="breadcrumb-link">Master</a>
                </li>
                <li class="breadcrumb-item">
                  <a href="#" class="breadcrumb-link">Person</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Employee</li>
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
            <button id="add_button"  type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_modal">Add +</button>
            <a href="{{ route('employee.export.pdf') }}" class="btn btn-danger">Export PDF</a>


            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table data-table table-striped table-bordered first">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>First Name</th>
                    <th>Middle Name</th>
                    <th>Last Name</th>
                    <th>Full Name</th>
                    <th>Jenis Kelamin</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody> @foreach($data as $key => $value) <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $value->firstname }}</td>
                    <td>{{ $value->middlename }}</td>
                    <td>{{ $value->lastname }}</td>
                    <td>{{ $value->fullname }}</td>
                    <td>{{ $value->flag_gender == 1 ? 'Laki-laki' : 'Perempuan' }}</td>
                    <td>
                      <form action="/person-employee/{{ $value->id }}/delete" method="post" onsubmit="return confirm('Yakin ingin menghapus item ini?')"> @csrf 
                        <button data-id="{{ $value->id }}" type="button" class="edit btn btn-success">
                          <span class="fas fa-pencil-alt"></span>
                        </button>
                        <button type="submit" class="btn btn-danger">
                          <span class="fas fa-trash"></span>
                        </button>
                      </form>
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
 @include('master.person_employee._add') 
 @include('master.person_employee._edit') 
 @endsection 
 
 @section('extra_javascript') 
 <script src="{{ asset('assets/js/master/person_employee.js') }}" type="text/javascript"></script> 
 @endsection