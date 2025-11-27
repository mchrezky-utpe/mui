<meta name="csrf-token" content="{{ csrf_token() }}">
@extends('template.main') 
@section('content')
<style>
    * {
        box-sizing: border-box;
    }
    
    body {
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
        padding: 15px;
        margin: 0;
        font-size: 12px;
    }
    
    .section__content {
        padding: 0;
    }
    
    .container-fluid {
        padding: 0 8px;
    }
    
    .card {
        margin-bottom: 5px;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    
    .card-body {
        padding: 4px;
    }
    
    .card-header {
        padding: 8px 7px;
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
        font-size: 14px;
        font-weight: bold;
    }
    
    /* Form Styles */
    .form-row {
        display: flex;
        flex-wrap: wrap;
        margin-bottom: 8px;
        gap: 8px;
    }
    
    .form-col {
        flex: 1;
        min-width: 120px;
    }
    
    .form-group {
        margin-bottom: 0;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 3px;
        font-size: 11px;
        font-weight: bold;
        color: #555;
    }
    
    .form-control {
        width: 100%;
        padding: 4px 6px;
        font-size: 11px;
        border: 1px solid #ccc;
        border-radius: 3px;
        height: 26px;
    }
    
    .form-control:focus {
        outline: none;
        border-color: #4a90e2;
        box-shadow: 0 0 3px rgba(74, 144, 226, 0.3);
    }
    
    select.form-control {
        height: 26px;
    }
    
    /* Main Layout */
    .main-content-wrapper {
        display: flex;
        gap: 12px;
        margin-bottom: 12px;
    }
    
    .form-section {
        flex: 1;
        min-width: 300px;
    }
    
    .wip-section {
        flex: 0;
        min-width: 400px;
    }
    
    /* Table Styles */
    .table-responsive {
        overflow-x: auto;    
        max-height: 200px;
        overflow-y: auto;
        max-width: 620px;
    }
    
    .table {
        width: 100%;
        border-collapse: collapse;
        font-size: 9px;
    
    }
    
    .table th,
    .table td {
        padding: 6px 8px;
        border: 1px solid #dee2e6;
        text-align: left;
    }
    
    .table th {
        background-color: #f8f9fa;
        font-weight: bold;
    }
    
    .table-striped tbody tr:nth-child(odd) {
        background-color: rgba(0,0,0,.02);
    }
    
    /* Compact Table Styles */
    .compact-table-container {
        background-color: white;
        border-radius: 3px;
    }
    
    .compact-table-container h2 {
        margin: 8px 0 6px 0;
        font-size: 12px;
        font-weight: bold;
        color: #333;
        text-align: center;
    }
    
    .compact-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 10px;
        table-layout: fixed;
        margin-bottom: 8px;
    }
    
    .compact-table td {
        padding: 2px 4px;
        border: 1px solid #ddd;
        text-align: center;
        height: 22px;
    }
    
    .compact-table input {
        width: 100%;
        padding: 1px 3px;
        border: 1px solid #ccc;
        border-radius: 2px;
        font-size: 10px;
        height: 18px;
    }
    
    .compact-table input:focus {
        outline: none;
        border-color: #4a90e2;
        box-shadow: 0 0 2px rgba(74, 144, 226, 0.5);
    }
    
    .compact-table tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    
    .compact-table tr:hover {
        background-color: #f0f0f0;
    }
    
    .compact-table td:first-child {
        font-weight: bold;
        width: 15%;
        background-color: #f5f5f5;
    }
    
    /* Responsive */
    @media (max-width: 1200px) {
        .main-content-wrapper {
            flex-direction: column;
        }
        
        .form-section,
        .wip-section {
            min-width: 100%;
        }
    }
    
    @media (max-width: 768px) {
        .form-col {
            min-width: 100%;
        }
        
        body {
            padding: 8px;
        }
        
        .container-fluid {
            padding: 0 4px;
        }
    }

    
        .menu-item {
            padding: 8px 15px;
            border-radius: 4px;
            margin-bottom: 5px;
            cursor: pointer;
            transition: all 0.2s;
        }
        .menu-item:hover, .menu-item.active {
            background-color: #e9ecef;
        }
        .loading-indicator {
            display: none;
            text-align: center;
            padding: 20px;
        }
        .table-clickable tbody tr {
            cursor: pointer;
            transition: all 0.2s;
        }
        .table-clickable tbody tr:hover {
            background-color: #e3f2fd !important;
        }
        .table-clickable tbody tr.selected {
            background-color: #bbdefb !important;
            border-left: 4px solid #2196f3;
        }

        #table-qc-check td {
            white-space: nowrap;
        }
</style>

<div class="section__content section__content--p30">
    <div class="container-fluid">
        <div class="row">
            <!-- Main Content Wrapper - Form dan WIP Detection berdampingan -->
            <div class="main-content-wrapper">
                <!-- Form Section -->
                <div class="form-section">
                    <!-- Filter Card -->
                    <div class="card">
                        <div class="card-header">
                            Filter Data
                        </div>
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-col">
                                    <div class="form-group">
                                        <label for="checking_date">Checking Date</label>
                                        <input value="<?php echo date('Y-m-d') ?>" type="date" class="form-control" id="checking_date" name="checking_date">
                                    </div>
                                </div>
                                <div class="form-col">
                                    <div class="form-group">
                                        <label>Checking Type</label>
                                        <select class="form-control" name="checking_type">
                                            <option value="">-</option>
                                            <option value="IQC">IQC</option>
                                            <option value="QQC">QQC</option>
                                            <option value="CS">CS</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-col">
                                    <div class="form-group">
                                        <label>Shift</label>
                                        <select class="form-control" name="shift">
                                            <option>-</option>
                                            <option value="shift_1">SHIFT 1</option>
                                            <option value="shift_2">SHIFT 2</option>
                                            <option value="shift_3">SHIFT 3</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-col">
                                    <div class="form-group">
                                        <label>From</label>
                                        <input type="date" class="form-control" id="start_date" name="start_date">
                                    </div>
                                </div>
                                <div class="form-col">
                                    <div class="form-group">
                                        <label>Until</label>
                                        <input type="date" class="form-control" id="end_date" name="end_date">
                                    </div>
                                </div>
                                <div class="form-col">
                                    <div class="form-group">
                                        <label>Search</label>
                                        <input name="search" class="form-control" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Production Data Card -->
                    <div class="card">
                        <div class="card-header">
                            Production Data
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="table-qc-check" class="table table-striped table-bordered first table-clickable">
                                    <thead>
                                        <tr>
                                            <th>Rcv. Date</th>
                                            <th>PO Number</th>
                                            <th>DO Number</th>
                                            <th>Item Code</th>
                                            <th>Item Name</th>
                                            <th>Item Type</th>
                                            <th>Unit</th>
                                            <th>Quantity</th>
                                            <th>OS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <div class="table-responsive">
                                <br>
                                <table id="table-qc-check-process" class="table table-striped table-bordered first">
                                    <thead>
                                        <tr>
                                            <th>Item Code</th>
                                            <th>Item Name</th>
                                            <th>Item Type</th>
                                            <th>Unit</th>
                                            <th>Qty Check</th>
                                            <th>Good</th>
                                            <th>Not Good</th>
                                            <th>Rework</th>
                                            <th>%</th>
                                            <th>PPM</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- WIP Detection Section -->
                <div class="wip-section">
                    <!-- WIP Detection Card -->
                    <div class="card">
                        <div class="card-header">
                            WIP Detection
                        </div>
                        <div class="card-body">
                            <div class="compact-table-container">
                                <table class="compact-table">
                                    <tbody>
                                        <tr>
                                            <td>WL</td>
                                            <td><input class="ng" /></td>
                                            <td>SV</td>
                                            <td><input class="ng" /></td>
                                            <td>CR</td>
                                            <td><input class="ng" /></td>
                                            <td>SM</td>
                                            <td><input class="ng" /></td>
                                        </tr>
                                        <tr>
                                            <td>CV</td>
                                            <td><input class="ng" /></td>
                                            <td>SV</td>
                                            <td><input class="ng" /></td>
                                            <td>SINK</td>
                                            <td><input class="ng" /></td>
                                            <td>BOOT</td>
                                            <td><input class="ng" /></td>
                                        </tr>
                                        <tr>
                                            <td>FL</td>
                                            <td><input class="ng" /></td>
                                            <td>OBL</td>
                                            <td><input class="ng" /></td>
                                            <td>WM</td>
                                            <td><input class="ng" /></td>
                                            <td>FK</td>
                                            <td><input class="ng" /></td>
                                        </tr>
                                        <tr>
                                            <td>GM</td>
                                            <td><input class="ng" /></td>
                                            <td>BNR</td>
                                            <td><input class="ng" /></td>
                                            <td>ST</td>
                                            <td><input class="ng" /></td>
                                            <td>NSP</td>
                                            <td><input class="ng" /></td>
                                        </tr>
                                        <tr>
                                            <td>STP</td>
                                            <td><input class="ng" /></td>
                                            <td>EM</td>
                                            <td><input class="ng" /></td>
                                            <td>D/S</td>
                                            <td><input class="ng" /></td>
                                            <td>DY</td>
                                            <td><input class="ng" /></td>
                                        </tr>
                                        <tr>
                                            <td>MX</td>
                                            <td><input class="ng" /></td>
                                            <td>OC</td>
                                            <td><input class="ng" /></td>
                                            <td>BND</td>
                                            <td><input class="ng" /></td>
                                            <td>GC</td>
                                            <td><input class="ng" /></td>
                                        </tr>
                                        <tr>
                                            <td>GC</td>
                                            <td><input class="ng" /></td>
                                            <td colspan="6"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Process Defects Card -->
                    <div class="card">
                        <div class="card-header">
                            Process Defects
                        </div>
                        <div class="card-body">
                            <div class="compact-table-container">
                                <table class="compact-table">
                                    <tbody>
                                        <tr>
                                            <td>D/S</td>
                                            <td><input class="ng" /></td>
                                            <td>DY</td>
                                            <td><input class="ng" /></td>
                                            <td>MS</td>
                                            <td><input class="ng" /></td>
                                            <td>OC</td>
                                            <td><input class="ng" /></td>
                                        </tr>
                                        <tr>
                                            <td>BND</td>
                                            <td><input class="ng" /></td>
                                            <td>DIM</td>
                                            <td><input class="ng" /></td>
                                            <td>BK</td>
                                            <td><input class="ng" /></td>
                                            <td>WR</td>
                                            <td><input class="ng" /></td>
                                        </tr>
                                        <tr>
                                            <td>GC</td>
                                            <td><input class="ng" /></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Chemical Defects Card -->
                    <div class="card">
                        <div class="card-header">
                            Chemical Defects
                        </div>
                        <div class="card-body">
                            <div class="compact-table-container">
                                <table class="compact-table">
                                    <tbody>
                                        <tr>
                                            <td>WW</td>
                                            <td><input class="ng" /></td>
                                            <td>PO</td>
                                            <td><input class="ng" /></td>
                                            <td>BR</td>
                                            <td><input class="ng" /></td>
                                            <td>YL</td>
                                            <td><input class="ng" /></td>
                                        </tr>
                                        <tr>
                                            <td>US</td>
                                            <td><input class="ng" /></td>
                                            <td>Skip</td>
                                            <td><input class="ng" /></td>
                                            <td>BB</td>
                                            <td><input class="ng" /></td>
                                            <td>RD</td>
                                            <td><input class="ng" /></td>
                                        </tr>
                                        <tr>
                                            <td>CM</td>
                                            <td><input class="ng" /></td>
                                            <td>OS</td>
                                            <td><input class="ng" /></td>
                                            <td>B. Cr</td>
                                            <td><input class="ng" /></td>
                                            <td>DOT</td>
                                            <td><input class="ng" /></td>
                                        </tr>
                                        <tr>
                                            <td>PT</td>
                                            <td><input class="ng" /></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Adhesive Tape and Painting Defects Card -->
                    <div class="card">
                        <div class="card-header">
                            Adhesive Tape and Painting Defects
                        </div>
                        <div class="card-body">
                            <div class="compact-table-container">
                                <table class="compact-table">
                                    <tbody>
                                        <tr>
                                            <td>NIP</td>
                                            <td><input class="ng" /></td>
                                            <td>DMG</td>
                                            <td><input class="ng" /></td>
                                            <td>FO</td>
                                            <td><input class="ng" /></td>
                                            <td>OTP</td>
                                            <td><input class="ng" /></td>
                                        </tr>
                                        <tr>
                                            <td>UTP</td>
                                            <td><input class="ng" /></td>
                                            <td>DSY</td>
                                            <td><input class="ng" /></td>
                                            <td>OSP</td>
                                            <td><input class="ng" /></td>
                                            <td>USP</td>
                                            <td><input class="ng" /></td>
                                        </tr>
                                        <tr>
                                            <td>UNS</td>
                                            <td><input class="ng" /></td>
                                            <td>GS</td>
                                            <td><input class="ng" /></td>
                                            <td>PM</td>
                                            <td><input class="ng" /></td>
                                            <td>OP</td>
                                            <td><input class="ng" /></td>
                                        </tr>
                                        <tr>
                                            <td>PT</td>
                                            <td><input class="ng" /></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Other and Remark Card -->
                    <div class="card">
                        <div class="card-header">
                            Additional Information
                        </div>
                        <div class="card-body">
                            <div class="compact-table-container">
                                <table class="compact-table">
                                    <tbody>
                                        <tr>
                                            <td>Other</td>
                                            <td><input class="ng" /></td>
                                            <td>Remark</td>
                                            <td><input class="ng" /></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('transaction.qc._entry_qcc')
<!-- MODAL -->
@endsection

@section('extra_javascript')
<script type="module" src="{{ asset('assets/js/transaction/qc/qc_main.js') }}" type="text/javascript"></script>
@endsection