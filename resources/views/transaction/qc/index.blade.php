<meta name="csrf-token" content="{{ csrf_token() }}"> @extends('template.main') @section('content') <style>
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
          <h3 class="pageheader-title">Quality Control List</h3>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="card-body">
        <div class="mb-3 row">
          <div class="col-md-3">
            <div class="form-group">
              <label for="start_date">From</label>
              <input type="date" class="form-control" id="start_date" name="start_date">
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="end_date">Until</label>
              <input type="date" class="form-control" id="end_date" name="end_date">
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="end_date">Checcking Type</label>
              <select type="date" class="form-control" id="flag_checking_type" name="flag_checking_type">
                  <option value>-</option> 
                <option value="0">IQC</option>
                <option value="1">QQC</option>
                <option value="2">CS</option>
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
            <h5 class="mb-0">List</h5>
            <div class="d-flex">
              <a href="/qc/add" class="mr-2 btn btn-primary">
                <i class=""></i> Check
              </a>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table id="table-qc" class="table table-striped table-bordered first">
                <thead>
                  <tr>
                    <th  colspan="6">Item Information</th>
                    <th  colspan="8">Quantity</th>
                    <th  colspan="25">Wip Defects</th>
                    <th  colspan="9">Process Defects</th>
                    <th  colspan="13">Chemical Defects</th>
                    <th  colspan="12">Adhesive Tape and Painting Defects</th>
                    <th  colspan="2">Other Defects</th>
                    <th  colspan="2">Sampling Level</th>
                    <th  colspan="4">Judgement</th>
                    <th  colspan="2">Inspector</th>
                    <th  colspan="3">Goods Transfer</th>
                </tr>
                  <tr>
                    <th>Checking Date</th>
                    <th>Checking Type</th>
                    <th>Item Code</th>
                    <th>Item Name</th>
                    <th>Item Type</th>
                    <th>Supplier</th>
                    <th>Receiving</th>
                    <th>Check</th>
                    <th>OS</th>
                    <th>Good</th>
                    <th>Not Good</th>
                    <th>Rework</th>
                    <th>%</th>
                    <th>PPM</th>
                    <th>WL</th>
                    <th>SV</th>
                    <th>CR</th>
                    <th>SM</th>
                    <th>CV</th>
                    <th>FM</th>
                    <th>SINK</th>
                    <th>BOOT</th>
                    <th>FL</th>
                    <th>OIL</th>
                    <th>WM</th>
                    <th>FK</th>
                    <th>GM</th>
                    <th>BNR</th>
                    <th>ST</th>
                    <th>NSP</th>
                    <th>STP</th>
                    <th>EM</th>
                    <th>D/S</th>
                    <th>DY</th>
                    <th>MX</th>
                    <th>OC</th>
                    <th>BND</th>
                    <th>DIM</th>
                    <th>GC</th>
                    <th>D/S</th>
                    <th>DY</th>
                    <th>MX</th>
                    <th>OC</th>
                    <th>BND</th>
                    <th>DIM</th>
                    <th>BK</th>
                    <th>WR</th>
                    <th>GC</th>
                    <th>WW</th>
                    <th>PO</th>
                    <th>BR</th>
                    <th>YL</th>
                    <th>US</th>
                    <th>Skip</th>
                    <th>BB</th>
                    <th>RD</th>
                    <th>CM</th>
                    <th>OS</th>
                    <th>B. Cr</th>
                    <th>DOT</th>
                    <th>PT</th>
                    <th>NIP</th>
                    <th>DMG</th>
                    <th>FO</th>
                    <th>OTP</th>
                    <th>UTP</th>
                    <th>DSY</th>
                    <th>OSP</th>
                    <th>USP</th>
                    <th>UNS</th>
                    <th>GS</th>
                    <th>PM</th>
                    <th>OP</th>
                    <th>Other</th>
                    <th>Remark</th>
                    <th>Normal</th>
                    <th>Tighten</th>
                    <th>Sampling</th>
                    <th>Sorting</th>
                    <th>Rework</th>
                    <th>Return</th>
                    <th>Inspector</th>
                    <th>Shift</th>
                    <th>Check</th>
                    <th>Status</th>
                    <th>Date</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
<!-- MODAL --> 
@section('extra_javascript') 
<script type="module" src="{{ asset('assets/js/transaction/qc/qc_index.js') }}" type="text/javascript"></script>
@endsection