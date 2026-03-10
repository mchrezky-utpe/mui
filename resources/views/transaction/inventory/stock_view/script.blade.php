<script>
    $(function() {
        initDatatable('Part');

        $(document).on('change', '#itemTypeFilter', function() {
            const val = $(this).val();
            initDatatable(val);
        });

        $(document).on('click', '#btnExport', function() {
            const type = $('#itemTypeFilter').val();
            window.location.href = `/transaction/inventory/stock_view/export?type=${type}`;
        });
    });

    const initDatatable = (type) => {
        let columns = [{
            title: 'No',
            data: null,
            orderable: false,
            searchable: false,
            className: 'text-center',
            render: function(data, type, row, meta) {
                return meta.settings._iDisplayStart + meta.row + 1;
            }
        }];

        if ($.fn.DataTable.isDataTable('#stockViewTable')) {
            $('#stockViewTable').DataTable().destroy();
            $('#stockViewTable').empty();
        }

        if ($('#stockViewTable thead').length === 0) {
            $('#stockViewTable').append('<thead class="table-dark"></thead>');
        }

        if (type !== 'Returnable Packaging') {
            columns.push({
                title: "Item Code",
                data: "sku_id",
            }, {
                title: "Item Name",
                data: "sku_name",
            }, {
                title: "Specification Code",
                data: "sku_specification_code",
            }, {
                title: "Item Type",
                data: "sku_material_type",
            }, {
                title: "Item Classification",
                data: "sku_classification",
            }, {
                title: "Sales Category",
                data: "sku_sales_category",
            }, {
                title: "Unit",
                data: "sku_inventory_unit"
            }, {
                title: "Warehouse",
                data: "val_conversion"
            }, {
                title: "Supplier",
                data: "total_outstanding",
                render: function(data, type, row, meta) {
                    return row.total_outstanding != null ? row.total_outstanding : 0;
                }
            }, {
                title: "Min",
                data: "min_qty",
                render: function(data, type, row, meta) {
                    return row.min_qty != null ? parseFloat(row.min_qty) : 0;
                }
            }, {
                title: "Max",
                data: null,
                render: function() {
                    return 0;
                }
            }, {
                title: "MSR",
                data: null,
                render: function() {
                    return 0;
                }
            }, {
                title: 'Status',
                data: null,
                className: 'text-center',
                render: function(data, type, row) {
                    const bgColor = row.val_conversion > 0 ? 'bg-success' : 'bg-danger';

                    return `<div class="${bgColor}" style="min-width: 40px; min-height: 20px; display: inline-block; border-radius: 4px;">&nbsp;</div>`;
                }
            });
        } else {
            columns.push({
                title: "Packaging Type",
                data: "type",
            }, {
                title: "Packaging Name",
                data: "description",
            }, {
                title: "Model",
                data: "model",
            }, {
                title: "Packaging Unit",
                data: "unit",
            }, {
                title: "Category Size",
                data: "category_size",
            }, {
                title: "Warehouse",
                data: "total_stock",
            }, {
                title: "Outside",
                data: null,
                defaultContent: 0,
            }, {
                title: "Warehouse",
                data: "total_stock",
            }, {
                title: 'Status',
                data: 'category_size',
                className: 'text-center',
                render: function(data, type, row) {
                    const bgColor = data ? 'bg-success' : 'bg-danger';

                    return `<div class="${bgColor}" style="min-width: 40px; min-height: 20px; display: inline-block; border-radius: 4px;">&nbsp;</div>`;
                }
            });
        }

        $('#stockViewTable').DataTable({
            destroy: true,
            serverSide: true,
            processing: true,
            scrollX: true,
            autoWidth: false,
            ajax: {
                url: '/transaction/inventory/stock_view/all',
                method: "GET",
                data: {
                    type
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
            columns: columns
        });
    }
</script>
