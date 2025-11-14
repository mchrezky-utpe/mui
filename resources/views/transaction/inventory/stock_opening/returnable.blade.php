<table class="table table-sm table-bordered align-middle">
    <thead class="bg-light text-center">
        <tr>
            <th>PCC Code</th>
            <th>Sub Category</th>
            <th>Category Type</th>
            <th>Category Name</th>
            <th>Model</th>
            <th>Size</th>
            <th>Unit</th>
            <th>Total Stock</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($data as $row)
        <tr>
            <td>{{ $row->pcc_code }}</td>
            <td>{{ $row->sub_category }}</td>
            <td>{{ $row->category_type }}</td>
            <td>{{ $row->category_name }}</td>
            <td>{{ $row->model }}</td>
            <td>{{ $row->size }}</td>
            <td>{{ $row->unit }}</td>
            <td class="text-end">{{ number_format($row->total_stock, 0) }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="8" class="text-center text-muted">No data available</td>
        </tr>
        @endforelse
    </tbody>
</table>
