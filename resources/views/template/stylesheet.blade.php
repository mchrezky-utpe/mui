<!-- Fontfaces CSS-->
<link href="{{asset('assets/css/font-face.css')}}" rel="stylesheet" media="all">
<link href="{{asset('assets/vendor/font-awesome-4.7/css/font-awesome.min.css')}}" rel="stylesheet" media="all">
<link href="{{asset('assets/vendor/font-awesome-5/css/fontawesome-all.min.css')}}" rel="stylesheet" media="all">
<link href="{{asset('assets/vendor/mdi-font/css/material-design-iconic-font.min.css')}}" rel="stylesheet" media="all">

<!-- Bootstrap CSS-->
<link href="{{asset('assets/vendor/bootstrap-4.1/bootstrap.min.css')}}" rel="stylesheet" media="all">

<!-- Vendor CSS-->
<link href="{{asset('assets/vendor/animsition/animsition.min.css')}}" rel="stylesheet" media="all">
<link href="{{asset('assets/vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css')}}" rel="stylesheet" media="all">
<link href="{{asset('assets/vendor/wow/animate.css')}}" rel="stylesheet" media="all">
<link href="{{asset('assets/vendor/css-hamburgers/hamburgers.min.css')}}" rel="stylesheet" media="all">
<link href="{{asset('assets/vendor/slick/slick.css')}}" rel="stylesheet" media="all">
<link href="{{asset('assets/vendor/select2/select2.min.css')}}" rel="stylesheet" media="all">
<link href="{{asset('assets/vendor/perfect-scrollbar/perfect-scrollbar.css')}}" rel="stylesheet" media="all">

<!-- Main CSS-->
<link href="{{asset('assets/css/theme.css')}}" rel="stylesheet" media="all">
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.1/css/dataTables.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.3.0/css/fixedColumns.bootstrap5.min.css">
<style>
.custom-modal-dialog-large {
    max-width: 1700px; /* Lebar modal */
    margin: 0 auto; /* Memastikan modal tetap berada di tengah horizontal */
}
.custom-modal-dialog-medium {
    max-width: 900px; /* Lebar modal */
    margin: 0 auto; /* Memastikan modal tetap berada di tengah horizontal */
}
.custom-modal-dialog-medium2 {
    max-width: 1000px; /* Lebar modal */
    margin: 0 auto; /* Memastikan modal tetap berada di tengah horizontal */
}


.custom-modal-dialog-large .modal-content {
    height: auto; /* Sesuaikan tinggi konten jika diperlukan */
    overflow-y: auto; /* Tambahkan scroll jika konten terlalu panjang */
}
.bordered-cell {
    border-left: 2px solid #ccc !important;
    border-right: 2px solid #ccc !important;
    padding: 8px 12px;
}
.unwrap-column {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

table.dataTable tbody {
    font-size: 11px;
}
table.dataTable thead {
    font-size: 12px;
}
table.dataTable tbody td {
    padding: 2px 2px; /* Atur sesuai kebutuhan */
}
table.dataTable thead th {
    padding: 2px;
}
.row {
    margin-right: 2px;
    margin-left: 2px;
}
body {
    font-weight: 500;
    font-size: 13px;
}
.form-group {
    margin: 0.2rem;
}
.btn {
    margin: 2px;
}
</style>

<style>
    .btn-group {
        margin: 20px;
    }
    
    .dropdown-submenu {
        position: relative;
    }
    
    .dropdown-submenu > .dropdown-menu {
        top: 0;
        left: 100%;
        margin-top: -6px;
        margin-left: -1px;
        border-radius: 0 6px 6px 6px;
        display: none;
    }
    
    .dropdown-submenu:hover > .dropdown-menu {
        display: block;
    }
    
    .dropdown-submenu > .dropdown-item:after {
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        content: "\f054";
        float: right;
        margin-left: 10px;
    }
    
    .dropdown-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 16px;
    }
    
    .dropdown-menu {
        padding: 0;
    }
    
    .dropdown-divider {
        margin: 4px 0;
    }
    
    .submenu-item {
        padding-left: 24px;
        font-size: 0.9em;
    }
    
    .custom-submenu {
        min-width: 150px;
    }
    .btn-group .show {
            position: unset !important;
}

.table-nowrap {
    width: 100%;
    border-collapse: collapse;
}
</style>
