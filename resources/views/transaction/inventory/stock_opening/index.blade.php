<!-- index view for stock_opening -->
@extends('template.main') @section('content') <div class="section__content section__content--p30">
    <div class="container-fluid">
      <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
          <div class="page-header">
            <h2 class="pageheader-title">Stock Opening</h2>
            <div class="page-breadcrumb">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item">
                    <a href="#" class="breadcrumb-link">Inventory</a>
                  </li>
                  </li>
                  <li class="breadcrumb-item active" aria-current="page">Stock Opening</li>
                </ol>
              </nav>
            </div>
          </div>
        </div>
      </div>
    
      <div class="card shadow-sm">
        <div class="card-header bg-light">
          <div class="row">
              <div class="col-lg-1 py-2 px-0">
                  Date :
              </div>
              <div class="col-lg-4 px-0 py-0">
                  <input type="date" id="date" class="form-control form-control-sm">
              </div>
          </div>

          
          <div class="row">
              <div class="col-lg-9 col-sm-12 mb-3 py-2 px-0">
                <div class="row">
                  <div class="col-lg-2 col-sm-12 mb-3 py-2 px-0">
                      Categories :
                  </div>
                
                  <div class="col-lg-1 col-sm-12 mb-3 py-2 px-0">
                      <input type="radio"> Part
                  </div>
                
                  <div class="col-lg-3 col-sm-12 mb-3 py-2 px-0">
                      <input type="radio"> Production Material
                  </div>
                
                  <div class="col-lg-2 col-sm-12 mb-3 py-2 px-0">
                      <input type="radio"> General Item
                  </div>
                
                  <div class="col-lg-3 col-sm-12 mb-3 py-2 px-0">
                      <input type="radio"> Returnable Packaging
                  </div>

                </div>
              </div>
              <div class="col-lg-3 col-sm-12 mb-3 py-2 px-0">
                
                  <div class="mx-0 mb-2 mb-md-0">
                    <input type="text" id="search" class="form-control form-control-sm" placeholder="Search..">
                  </div>
              </div>
          </div>

        </div>

        <div class="card-body">
          <p>Loading Data... (Masih Proses)</p>
        </div>
      </div>


    </div>
  </div>
   @endsection 
   