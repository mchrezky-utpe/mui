<!-- data view for stock_opening -->
<!-- Part Code = manual_id
Part Name = description
Spesification Code = specification_code -->

<table class="table table-sm table-bordered">
    <thead>
        <tr>
            <th style="width:19%;">Manual ID</th>
            <th>Part Name</th>
            <th style="width:20%;" >Specification Code</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($data as $item)
            <tr>
                <td>{{ $item->manual_id }}</td>
                <td>{{ $item->description }}</td>
                <td>{{ $item->specification_code }}</td>
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
