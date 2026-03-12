<style>
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

    .dropdown-menu form {
        margin: 0;
    }

    .dropdown-item {
        display: block;
        width: 100%;
        padding: 0.25rem 1.5rem;
        clear: both;
        font-weight: 400;
        color: #212529;
        text-align: inherit;
        white-space: nowrap;
        background-color: transparent;
        border: 0;
        cursor: pointer;
    }

    .dropdown-item:hover {
        background-color: #f8f9fa;
    }

    .text-danger {
        color: #dc3545 !important;
    }

    .text-success {
        color: #28a745 !important;
    }
</style>
