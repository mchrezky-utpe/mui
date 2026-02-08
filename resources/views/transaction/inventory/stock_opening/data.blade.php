<!-- data view for stock_opening -->
<!-- Part Code = manual_id
Part Name = description
Spesification Code = specification_code -->

<table class="table table-sm table-bordered">
    <thead>
        <tr>
            <th style="width:19%;">Part Code</th>
            <th>Part Name</th>
            <th style="width:20%;">Specification Code</th>
            <th>Part Type</th>
            <th>Part Model</th>
            <th>Part Unit</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($data as $item)
        <tr>
            <td>{{ $item->sku_id }}</td>
            <td>{{ $item->sku_name }}</td>
            <td>{{ $item->sku_specification_code }}</td>
            <td>{{ $item->sku_material_type }}</td>
            <td>{{ $item->sku_model }}</td>
            <td>{{ $item->sku_inventory_unit }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="3" class="text-center">Tidak ada data ditemukan</td>
        </tr>
        @endforelse
    </tbody>
</table>

<div class="d-flex justify-content-end mt-3">
    {!! $data->links('vendor.pagination.custome') !!}
</div>