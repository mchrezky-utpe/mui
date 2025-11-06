<meta name="csrf-token" content="{{ csrf_token() }}"> @extends('template.main') @section('content')
<style>
    body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }
        .navbar-brand {
            font-weight: 600;
        }
        .tab-content {
            background-color: white;
            border-radius: 0 0 8px 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            min-height: 70vh;
        }
        .nav-tabs .nav-link {
            border: none;
            border-bottom: 3px solid transparent;
            font-weight: 500;
            color: #6c757d;
            padding: 12px 20px;
        }
        .nav-tabs .nav-link.active {
            border-bottom: 3px solid #0d6efd;
            color: #0d6efd;
            background-color: transparent;
        }
        .section-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 15px;
            color: #495057;
            border-bottom: 1px solid #e9ecef;
            padding-bottom: 8px;
        }
        .data-list {
            max-height: 300px;
            overflow-y: auto;
        }
        .data-item {
            padding: 10px 15px;
            border-bottom: 1px solid #f1f1f1;
            transition: background-color 0.2s;
        }
        .data-item:hover {
            background-color: #f8f9fa;
        }
        .chart-container {
            position: relative;
            height: 250px;
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
</style>


<div class="section__content section__content--p30">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h2 class="pageheader-title">Purchase Analysis - Price Trends</h2>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="#" class="breadcrumb-link">Transaction</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="#" class="breadcrumb-link">Purchase</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Price Trends</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab Content -->
        <div class="tab-content p-4" id="dashboardTabsContent">
            <!-- Tab 1 Content -->
                <div class="loading-indicator" id="loadingTab1">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Memuat data...</p>
                </div>
                <div id="tab1Content">
                    @include('transaction.pa._purchase_price')
                </div>
        </div>
    </div>
</div>
</div>

</div>
<!-- MODAL -->
@endsection @section('extra_javascript')
<script type="module" src="{{ asset('assets/js/transaction/purchase_analysis/pa_price_main.js') }}" type="text/javascript"></script>
@endsection