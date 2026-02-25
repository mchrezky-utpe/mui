<script>
    let packagingInformationTable;

    $(document).ready(function() {
        packagingInformationTable = $('#packagingInformationTable').DataTable({
            destroy: true,
            serverSide: true,
            processing: true,
            scrollX: true,
            autoWidth: false,
            ajax: {
                url: `{{ url('/packaging-information/get-data') }}`,
                method: "GET",
                beforeSend: function() {
                    $('#packagingInformationTable tbody').html(`
                        <tr>
                            <td colspan="100%" class="text-center p-3">
                                <div class="dt-spinner"></div>
                                Loading data...
                            </td>
                        </tr>
                    `);
                },
                dataSrc: function(res) {
                    if (!res.success) {
                        alert(res.message);
                        return [];
                    }
                    res.draw = res.data.draw;
                    res.recordsTotal = res.data.recordsTotal;
                    res.recordsFiltered = res.data.recordsFiltered;
                    return res.data.data;
                }
            },
            columns: [{
                title: "Part Code",
                data: 'sku_id',
                name: 'sku_id'
            }, {
                title: "Part Name",
                data: 'sku_name',
                name: 'sku_name'
            }, {
                title: "PCK Code",
                data: 'pck_code',
                name: 'pck_code'
            }, {
                title: "Packaging Sub Category",
                data: 'sub_category',
                name: 'sub_category'
            }, {
                title: "Type",
                data: 'type',
                name: 'type'
            }, {
                title: "Packaging Name",
                data: 'description',
                name: 'description'
            }, {
                title: "Model",
                data: 'model',
                name: 'model'
            }, {
                title: "Size",
                data: 'category_size',
                name: 'category_size'
            }, {
                title: "Unit",
                data: 'unit',
                name: 'unit'
            }, {
                title: "Partition Sub Category",
                data: 'partition_sub_category',
                name: 'partition_sub_category'
            }, {
                title: "Partition Type",
                data: 'partition_type',
                name: 'partition_type'
            }, {
                title: "Partition Description",
                data: 'partition_description',
                name: 'partition_description'
            }, {
                title: "Partition Size",
                data: 'partition_size',
                name: 'partition_size'
            }, {
                title: "Partition Capacity",
                data: 'partition_capacity',
                name: 'partition_capacity',
                render: function(data, type, row) {
                    data = parseFloat(data);
                    if (isNaN(data)) {
                        return '';
                    } else {
                        return data;
                    }
                }
            }, {
                title: "Partition / Packaging",
                data: 'partition_capacity',
                name: 'partition_capacity',
                render: function(data, type, row) {
                    data = parseFloat(data);
                    if (isNaN(data)) {
                        return '';
                    } else {
                        return data;
                    }
                }
            }, {
                title: "Part / Partition",
                data: 'qty_per_partition',
                name: 'qty_per_partition',
                render: function(data, type, row) {
                    data = parseFloat(data);
                    if (isNaN(data)) {
                        return '';
                    } else {
                        return data;
                    }
                }
            }, {
                title: "Part / Packaging",
                data: 'qty_per_partition',
                name: 'qty_per_partition',
                render: function(data, type, row) {
                    const partitionCapacity = parseFloat(row.partition_capacity);
                    const qtyPerPartition = parseFloat(data);
                    if (isNaN(partitionCapacity) || isNaN(qtyPerPartition) ||
                        partitionCapacity === 0) {
                        return '';
                    } else {
                        const result = qtyPerPartition * partitionCapacity;
                        return isNaN(result) ? '' : result;
                    }
                }
            }, {
                title: "Total Stock",
                data: 'qty_per_partition',
                name: 'qty_per_partition',
                render: function(data, type, row) {
                    data = parseFloat(data);
                    if (isNaN(data)) {
                        return '';
                    } else {
                        return data;
                    }
                }
            }, {
                title: "Action",
                data: null,
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    return `
                        <button class="btn btn-sm btn-warning edit-btn" data-id="${row.id}" data-category-id="${row.sku_packaging_category_id}" data-partition-id="${row.sku_packaging_partition_id}" data-qty-per-partition="${row.qty_per_partition}">
                            Update
                        </button>
                    `;
                }
            }],
            columnDefs: [{
                targets: [14, 15],
                className: 'text-end'
            }]
        });

        $(document).on('click', '.edit-btn', function() {
            const id = $(this).data('id');
            const categoryId = $(this).data('category-id');
            const partitionId = $(this).data('partition-id');
            const qtyPerPartition = $(this).data('qty-per-partition');
            $('#updateId').val(id);
            $('#selectCategory').val(categoryId).trigger('change');
            $('#selectPartition').val(partitionId).trigger('change');
            if (isNaN(parseFloat(qtyPerPartition))) {
                $('#qtyPerPartition').val('');
            } else {
                $('#qtyPerPartition').val(parseFloat(qtyPerPartition));
            }

            $('#modalUpdate').modal('show');
        });

        $('.select2-update').select2({
            dropdownParent: $('#modalUpdate')
        });

        $('#modalUpdate').on('hidden.bs.modal', function() {
            $('#updateId').val('');
            $('#selectCategory').val('').trigger('change');
            $('#selectPartition').val('').trigger('change');
            $('#qtyPerPartition').val('');
        });

        $(document).on('click', '#updateSubmitBtn', function() {
            const id = $('#updateId').val();
            const categoryId = $('#selectCategory').val();
            const partitionId = $('#selectPartition').val();
            const qtyPerPartition = $('#qtyPerPartition').val();

            $.ajax({
                url: `{{ url('/packaging-information/update') }}/${id}`,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    packaging_category_id: categoryId,
                    packaging_partition_id: partitionId,
                    qty_per_partition: qtyPerPartition
                },
                success: function(res) {
                    if (res.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: res.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                        $('#modalUpdate').modal('hide');
                        packagingInformationTable.ajax.reload(null, false);
                    } else {
                        alert(res.message);
                    }
                },
                error: function(xhr) {
                    alert('An error occurred while updating data');
                }
            });
        });
    });
</script>
