<script>
    let listItemTable;

    $(function() {
        initListItemDatatable('doNumber');

        $('.select2-create').select2({
            dropdownParent: $('#modalCreate')
        });
    });

    const showCreateModal = () => {
        $('#modalCreate').modal('show');
        initListItemDatatable('doNumber');
    }

    const initListItemDatatable = (searchType) => {
        let columns = [{
            title: 'No',
            data: null,
            orderable: false,
            searchable: false,
            className: 'text-center',
            render: function(data, type, row, meta) {
                return meta.row + 1;
            }
        }];

        if (searchType == 'doNumber') {
            columns.push({
                title: "DO Date",
                data: "do_date",
            }, {
                title: "DO Number",
                data: "do_number"
            }, {
                title: "PO Number",
                data: "po_number"
            }, {
                title: "CDS Code",
                data: "cds_code"
            });
        }

        if ($.fn.DataTable.isDataTable('#listItemTable')) {
            $('#listItemTable').DataTable().destroy();
            $('#listItemTable').empty();
        }

        if ($('#listItemTable thead').length === 0) {
            $('#listItemTable').append('<thead class="table-dark"></thead>');
        }

        $('#listItemTable').DataTable({
            destroy: true,
            serverSide: true,
            processing: true,
            scrollX: true,
            scrollY: "350px",
            scrollCollapse: true,
            autoWidth: false,
            ajax: {
                url: `{{ url('/transaction/sales/sales_invoice/source') }}`,
                method: "GET",
                data: {
                    searchType: 'doNumber'
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
