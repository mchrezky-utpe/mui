@extends('template.main')

@section('content')
<div class="section__content section__content--p30">
    <div class="container-fluid">

        {{-- HEADER --}}
        <div class="page-header">
            <h2 class="pageheader-title">Stock Opening</h2>
            <div class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Inventory</a></li>
                    <li class="breadcrumb-item active">Stock Opening</li>
                </ol>
            </div>
        </div>

        {{-- CARD --}}
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <div class="row align-items-center mb-2">
                    <div class="col-lg-1">Date:</div>
                    <div class="col-lg-4"><input type="date" id="date" class="form-control form-control-sm"></div>
                </div>

                <div class="row align-items-center mb-2">
                    <div class="col-lg-2">Categories:</div>
                    <div class="col-lg-8">
                        <label class="mx-3"><input type="radio" name="type" value="1" checked > Part</label>
                        <label class="mx-3"><input type="radio" name="type" value="2" > Production Material</label>
                        <label class="mx-3"><input type="radio" name="type" value="3"> General Item</label>
                        <label><input type="radio" name="type" value="4"> Returnable Packaging</label>
                    </div>
                    <div class="col-lg-2">
                        <input type="text" id="search" class="form-control form-control-sm" placeholder="Search..">
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div id="data"></div>
            </div>
        </div>
    </div>
</div>
@endsection
