<style>
    .select2-container .select2-selection--single {
        height: 32px !important;
    }

    .table-fixed {
        max-height: 300px;
        overflow-y: auto;
        border: 1px solid #dee2e6;
    }

    .table-fixed table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .table-fixed thead th {
        position: sticky;
        top: 0;
        background: #fff;
        z-index: 2;
        border-bottom: 2px solid #dee2e6;
    }

    .table-fixed thead th:not(:last-child) {
        border-right: 1px solid #dee2e6;
    }


    .dt-spinner {
        display: inline-block;
        width: 16px;
        height: 16px;
        border: 2px solid #007bff;
        border-top: 2px solid transparent;
        border-radius: 50%;
        animation: dt-spin 0.6s linear infinite;
        margin-right: 6px;
        vertical-align: middle;
    }

    @keyframes dt-spin {
        to {
            transform: rotate(360deg);
        }
    }


    .dataTables_wrapper .dataTables_length select {
        height: 32px;
        padding: 2px 6px;
        font-size: 0.875rem;
    }

    .required::after {
        content: " *";
        color: red;
        font-weight: bold;
    }

    .dataTables_wrapper .dataTables_length {
        float: left;
    }

    .dataTables_wrapper .dataTables_filter {
        float: right;
    }

    .dataTables_wrapper .dataTables_filter label {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 0;
        font-weight: 500;
    }

    .dataTables_wrapper select,
    .dataTables_wrapper input {
        height: 32px;
        padding: 4px 8px;
        font-size: 0.875rem;
    }

    .dataTables_wrapper::after {
        content: "";
        display: block;
        clear: both;
    }


    .dataTables_wrapper .dataTables_info {
        float: left;
        margin-top: 10px;
    }

    .dataTables_wrapper .dataTables_paginate {
        float: right;
        margin-top: 10px;
    }

    @media (max-width: 768px) {

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            float: none;
            width: 100%;
            text-align: left;
        }

        .dataTables_wrapper .dataTables_filter {
            margin-top: 8px;
        }

        .dataTables_wrapper .dataTables_paginate {
            margin-top: 12px;
        }
    }
</style>
