@extends('template.main') @section('content')
<div class="section__content section__content--p30">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h2 class="pageheader-title">SKU Production Material</h2>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="#" class="breadcrumb-link"
                                        >Master</a
                                    >
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="#" class="breadcrumb-link">SKU</a>
                                </li>
                                <li
                                    class="breadcrumb-item active"
                                    aria-current="page"
                                >
                                    Production Material
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
                    <div
                        class="card-header d-flex justify-content-between align-items-center"
                    >
                        <h5 class="mb-0">List</h5>
                        <div class="d-flex">
                            <button
                                id="add_button"
                                type="button"
                                class="btn btn-primary"
                                data-toggle="modal"
                                data-target="#add_modal"
                            >
                                + Production Material
                            </button>
                            <a
                                href="{{
                                    route('sku.export_production_material')
                                }}"
                                class="mr-2 btn btn-success"
                            >
                                <i class="fas fa-file-excel"></i> Export Excel
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="">
                            <div
                                class="container-fluid"
                                style="overflow-x: auto"
                            >
                                <table
                                    class="table data-table-item table-striped"
                                >
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Image</th>
                                            <th>Material Code</th>
                                            <th>Material Description</th>
                                            <th>Spec code</th>
                                            <th>Spec Description</th>
                                            <th>Sales Category</th>
                                            <th>Set Code</th>
                                            <th>Item Sub Category</th>
                                            <th>Item Type</th>
                                            <th>Procurement Type</th>
                                            <th>Inventory Unit</th>
                                            <th>Procurement Unit</th>
                                            <th>Conversion value</th>
                                            <th>Inv. Reg</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data as $key => $value)
                                        <tr>
                                            <td>
                                                {{ $startNumber + $loop->iteration }}
                                            </td>
                                            <td>
                                                @if($value->blob_image)
                                                <img
                                                    src="data:image/png;base64,{{ $value->blob_image }}"
                                                    width="80"
                                                />

                                                @else
                                                <span class="text-muted"
                                                    >No image</span
                                                >
                                                @endif
                                            </td>
                                            <td>{{ $value->sku_id }}</td>
                                            <td>{{ $value->sku_name }}</td>
                                            <td>
                                                {{ $value->sku_specification_code }}
                                            </td>
                                            <td>
                                                {{ $value->sku_specification_detail }}
                                            </td>
                                            <td>
                                                {{ $value->sku_sales_category }}
                                            </td>
                                            <td>{{ $value->set_code }}</td>
                                            <td>
                                                {{ $value->sku_sub_category}}
                                            </td>
                                            <td>
                                                {{ $value->sku_material_type }}
                                            </td>
                                            <td>
                                                {{ $value->sku_procurement_type }}
                                            </td>
                                            <td>
                                                {{ $value->sku_inventory_unit }}
                                            </td>
                                            <td>
                                                {{ $value->sku_procurement_unit }}
                                            </td>
                                            <td>
                                                {{ $value->val_conversion }}
                                            </td>
                                            <td>
                                                {{ $value->flag_inventory_register == "1" ? 'YES' : 'NO' }}
                                            </td>
                                            <td>
                                                <form
                                                    action="/sku-production-material/{{ $value->id }}/delete"
                                                    method="post"
                                                >
                                                    @csrf
                                                    <div class="d-flex">
                                                        <button
                                                            data-id="{{ $value->id }}"
                                                            type="button"
                                                            class="edit btn btn-success"
                                                        >
                                                            <span
                                                                class="fas fa-pencil-alt"
                                                            ></span>
                                                        </button>
                                                        <button
                                                            class="btn btn-danger"
                                                        >
                                                            <span
                                                                class="fas fa-trash"
                                                            ></span>
                                                        </button>
                                                    </div>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div style="margin-block-start: 1rem">
                                {{ $data->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- MODAL -->
@include('master.sku_production_material._set_code')
@include('master.sku_production_material._add')
@include('master.sku_production_material._edit') @endsection
@section('extra_javascript')
<script
    src="{{ asset('assets/js/master/sku_production_material.js') }}"
    type="text/javascript"
></script>
@endsection
