<script>
    let tableCR;
    let itemTemp = null;
    let itemAdded = [];
    let countRowItem = 1;
    let tableCRList;
    let tableCRDetailList;

    $(function() {
        initDatatableCR(false);
        initDatatableCRList();

        $(document).on('click', '#searchDataBtn', function(e) {
            e.preventDefault();
            initDatatableCR(true);
        });

        $('#itemAddQty').on('input', function(e) {
            e.preventDefault();
            let max = parseFloat($(this).attr('max'));
            let min = 0;
            let val = parseFloat($(this).val());

            itemTemp.qty = val;
            if (val > max) {
                $(this).val(max);
                itemTemp.qty = max;
            }

            if (val < min) {
                $(this).val(min);
                itemTemp.qty = min;
            }

            if (itemTemp.qty > 0) {
                $('#itemBtnAdd').attr('disabled', false);
            } else {
                $('#itemBtnAdd').attr('disabled', true);
            }
        });

        $('#itemAddQty').on('keypress', function(e) {
            if (e.which === 45) {
                e.preventDefault();
            }
        });

        $('#modalAddItem').on('hidden.bs.modal', function() {
            itemTemp = null;
            $('#itemAddQty').val("");
            $('#itemAddQty').attr('max', 0);
            $('#itemBtnAdd').attr('disabled', false);
            $('#tbodyAddItem').empty();
        });

        $(document).on('click', '#itemBtnAdd', function(e) {
            e.preventDefault();
            itemAdded.push({
                row_id: countRowItem,
                ...itemTemp
            });

            if (itemAdded.length == 1) {
                $('#tbodyListAdded').empty();
            }

            $('#tbodyListAdded').append(`
                <tr id="listRow${countRowItem}">
                    <td>${itemTemp.po_number ? itemTemp.po_number : ""}</td>
                    <td>${itemTemp.cds_code ? itemTemp.cds_code : ""}</td>
                    <td>${itemTemp.sku_id? itemTemp.sku_id : ""}</td>
                    <td>${itemTemp.sku_name? itemTemp.sku_name : ""}</td>
                    <td>${itemTemp.sku_specification_code? itemTemp.sku_specification_code : ""}</td>
                    <td>${itemTemp.sku_business_type? itemTemp.sku_business_type : ""}</td>
                    <td>${itemTemp.sku_model? itemTemp.sku_model : ""}</td>
                    <td>${itemTemp.sku_inventory_unit? itemTemp.sku_inventory_unit : ""}</td>
                    <td>${parseFloat(itemTemp.qty)}</td>
                    <td><button type="button" class="btn btn-sm btn-danger" onclick="deleteItem(${countRowItem})"><i class="fas fa-trash"></i></button></td>
                </tr>
            `);

            // Reset
            itemTemp = null;
            countRowItem += 1;

            $('#modalAddItem').modal('hide');
        });

        $(document).on('click', '#btnSaveCR', function(e) {
            e.preventDefault();

            const crDateInput = $('#crDate').val();
            const customerSelect = $('#customerSelect').val();
            const crTypeSelect = $('#crTypeSelect').val();
            const returnDONumberInput = $('#returnDONumberInput').val();

            if (!crDateInput || !customerSelect || !crTypeSelect || !returnDONumberInput) {
                Swal.fire({
                    title: 'Validation Error',
                    text: 'Please fill out all required fields!',
                    icon: 'error',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                });
                return;
            }
            if (itemAdded.length == 0) {
                Swal.fire({
                    title: 'Validation Error',
                    text: 'Please add at least one item.',
                    icon: 'error',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                });
            }

            $('#btnSaveCR').html(`<i class="fas fa-spinner fa-spin mr-1"></i> Please wait...`).attr(
                'disabled', true);

            $.ajax({
                url: `{{ url('/transaction/inventory/customer_return/create-cr') }}`,
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    crDate: crDateInput,
                    crType: crTypeSelect,
                    customer: customerSelect,
                    returnDONumber: returnDONumberInput,
                    listItem: itemAdded
                },
                success: function(res) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Customer return created successfully',
                        icon: 'success',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });

                    window.location.href =
                        `{{ url('transaction/inventory/customer_return') }}`;
                },
                complete: function() {
                    $('#btnSaveCR').html('Save').attr('disabled', false);
                }
            });
        });

        $('#customerReturnTable tbody').on('click', 'td.dt-control', function() {
            var tr = $(this).closest('tr');
            var row = tableCRList.row(tr);

            if (row.child.isShown()) {
                row.child.hide();
                tr.removeClass('shown');
            } else {
                row.child(formatDetail(row.data())).show();
                tr.addClass('shown');
            }
        });

        $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function(event) {
            let tabId = $(event.target).attr('data-bs-target');

            if (tabId === '#nav-cr') {
                initDatatableCRList();
            } else {
                initDatatableCRDetailList();
            }
        });

        $(document).on('click', '#applyFilterCR', function(e) {
            e.preventDefault();
            initDatatableCRList();
        });

        $(document).on('click', '#applyFilterCRDetail', function(e) {
            e.preventDefault();
            initDatatableCRDetailList();
        });
    });

    const initDatatableCRList = () => {
        tableCRList = $('#customerReturnTable').DataTable({
            destroy: true,
            processing: true,
            serverSide: true,
            scrollX: true,
            scrollCollapse: true,
            autoWidth: false,
            ajax: {
                url: `{{ url('/transaction/inventory/customer_return/get-all') }}`,
                method: "GET",
                data: {
                    customerFilter: $('#customerFilter').val(),
                    fromDateFilter: $('#fromDateFilter').val(),
                    untilDateFilter: $('#untilDateFilter').val()
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
                className: 'dt-control',
                orderable: false,
                data: null,
                defaultContent: '',
            }, {
                title: 'No',
                data: null,
                orderable: false,
                searchable: false,
                className: 'text-center',
                render: function(data, type, row, meta) {
                    return meta.settings._iDisplayStart + meta.row + 1 + '.';
                }
            }, {
                title: "CR Code",
                data: "cr_code",
            }, {
                title: "CR Date",
                data: "cr_date",
            }, {
                title: "CR Type",
                data: "cr_type",
            }, {
                title: "Customer",
                data: "customer_name",
            }, {
                title: "Return DO Number",
                data: "return_do_number",
            }, {
                title: "CR Status",
                data: null,
                className: "text-center",
                render: function(data, type, row, meta) {
                    const isOutstandingExist = row.details.some(item => item.outstanding_qty >
                        0);
                    const bgColor = isOutstandingExist ? 'bg-danger' : 'bg-success';
                    return `<div class="${bgColor}" style="min-width: 20px; min-height: 20px; display: inline-block; border-radius: 4px;">&nbsp;</div>`
                }
            }]
        });
    }

    const formatDetail = (d) => {
        let element = ``;
        if (d.details.length > 0) {
            d.details.forEach(dRow => {
                const bgColor = parseFloat(dRow.outstanding_qty) > 0 ? "bg-danger" : "bg-success";
                element += `<tr>
                    <td>${dRow.po_number || ""}</td>
                    <td>${dRow.cds_code || ""}</td>
                    <td>${dRow.do_number || ""}</td>
                    <td>${dRow.sku_id || ""}</td>
                    <td>${dRow.sku_name || ""}</td>
                    <td>${dRow.sku_specification_code || ""}</td>
                    <td>${dRow.sku_model || ""}</td>
                    <td>${dRow.sku_inventory_unit || ""}</td>
                    <td class="text-right">${parseFloat(dRow.return_qty)}</td>
                    <td class="text-right">${parseFloat(dRow.outstanding_qty)}</td>
                    <td class="text-center"><div class="${bgColor}" style="min-width: 20px; min-height: 20px; display: inline-block; border-radius: 4px;">&nbsp;</div></td>
                </tr>`
            })
        } else {
            element += `<tr><td colspan="10">No data available.</td></tr>`
        }

        return `<table class="table table-bordered">
            <thead class="table-secondary">
                <tr>
                    <th>PO Number</th>
                    <th>CDS Code</th>
                    <th>DO Number</th>
                    <th>Part Code</th>
                    <th>Part Name</th>
                    <th>Part Number</th>
                    <th>Model</th>
                    <th>Unit</th>
                    <th>Quantity</th>
                    <th>Outstanding</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>${element}</tbody>
        </table>`;
    }

    const initDatatableCRDetailList = () => {
        tableCRDetailList = $('#customerReturnDetailTable').DataTable({
            destroy: true,
            processing: true,
            serverSide: true,
            scrollX: true,
            scrollCollapse: true,
            autoWidth: false,
            ajax: {
                url: `{{ url('/transaction/inventory/customer_return/get-all-detail') }}`,
                method: "GET",
                data: {
                    customerFilterDetail: $('#customerFilterDetail').val(),
                    fromDateFilterDetail: $('#fromDateFilterDetail').val(),
                    untilDateFilterDetail: $('#untilDateFilterDetail').val()
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
                title: 'No',
                data: null,
                orderable: false,
                searchable: false,
                className: 'text-center',
                render: function(data, type, row, meta) {
                    return meta.settings._iDisplayStart + meta.row + 1 + '.';
                }
            }, {
                title: "Part Code",
                data: "sku_id",
            }, {
                title: "Part Name",
                data: "sku_name",
            }, {
                title: "Part Number",
                data: "sku_specification_code",
            }, {
                title: "CR Code",
                data: "cr_code",
            }, {
                title: "PO Number",
                data: "po_number",
            }, {
                title: "CDS Code",
                data: "cds_code",
            }, {
                title: "DO Number",
                data: "do_number",
            }, {
                title: "Return DO Number",
                data: "return_do_number",
            }, {
                title: "Model",
                data: "sku_model",
            }, {
                title: "Unit",
                data: "sku_inventory_unit",
            }, {
                title: "Quantity",
                data: "return_qty",
                render: function(data, type, row, meta) {
                    return parseFloat(row.return_qty);
                }
            }, {
                title: "OS",
                data: "outstanding_qty",
                render: function(data, type, row, meta) {
                    return parseFloat(row.outstanding_qty);
                }
            }, {
                title: "OS QC",
                data: "outstanding_qc_qty",
                render: function(data, type, row, meta) {
                    return parseFloat(row.outstanding_qc_qty);
                }
            }, {
                title: "Status",
                data: null,
                className: "text-center",
                render: function(data, type, row, meta) {
                    const isOutstandingExist = parseFloat(row.outstanding_qty) > 0;
                    const bgColor = isOutstandingExist ? 'bg-danger' : 'bg-success';
                    return `<div class="${bgColor}" style="min-width: 20px; min-height: 20px; display: inline-block; border-radius: 4px;">&nbsp;</div>`
                }
            }]
        });
    }

    const initDatatableCR = (isShow) => {
        if ($.fn.DataTable.isDataTable('#customerReturnCreateTable')) {
            $('#customerReturnCreateTable').DataTable().destroy();
            $('#customerReturnCreateTable').empty();
        }

        if ($('#customerReturnCreateTable thead').length === 0) {
            $('#customerReturnCreateTable').append('<thead class="table-dark"></thead>');
        }

        tableCR = $('#customerReturnCreateTable').DataTable({
            destroy: true,
            processing: true,
            serverSide: true,
            scrollX: true,
            scrollY: "350px",
            scrollCollapse: true,
            autoWidth: false,
            ajax: {
                url: `{{ url('/transaction/inventory/customer_return/get-source') }}`,
                method: "GET",
                data: {
                    isShow
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
                title: 'No',
                data: null,
                orderable: false,
                searchable: false,
                className: 'text-center',
                render: function(data, type, row, meta) {
                    return meta.settings._iDisplayStart + meta.row + 1 + '.';
                }
            }, {
                title: "DO Date",
                data: "do_date",
            }, {
                title: "PO Number",
                data: "po_number"
            }, {
                title: "CDS Code",
                data: "cds_code"
            }, {
                title: "DO Number",
                data: "do_number"
            }, {
                title: "Part Code",
                data: "sku_id"
            }, {
                title: "Part Name",
                data: "sku_name"
            }, {
                title: "Part Number",
                data: "sku_specification_code"
            }, {
                title: "Business Type",
                data: "sku_business_type"
            }, {
                title: "Model",
                data: "sku_model"
            }, {
                title: "Quantity",
                data: "qty",
                className: "text-right",
                render: function(data, type, row, meta) {
                    return parseFloat(data);
                }
            }, {
                title: "Action",
                data: "id",
                render: function(data, typeCol, row, meta) {
                    return `<button class="btn btn-sm btn-success" onclick="showAddItem(${data})">+</button>`
                }
            }]
        })
    }

    const showAddItem = (itemId) => {
        let isExist = itemAdded.some(item => item.id === itemId);
        if (isExist) {
            Swal.fire({
                title: 'Already Added',
                text: 'This item is already in your list.',
                icon: 'warning',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
            return;
        }

        $.ajax({
            url: `{{ url('/transaction/inventory/customer_return/get-source-detail') }}`,
            method: "GET",
            data: {
                id: itemId
            },
            success: function(res) {
                $('#tbodyAddItem').append(`
                    <tr>
                        <td>${res.data.do_number}</td>
                        <td>${res.data.sku_id}</td>
                        <td>${res.data.sku_name}</td>
                        <td>${parseFloat(res.data.qty)}</td>
                    </tr>
                `);

                $('#itemAddQty').val(parseFloat(res.data.qty));
                $('#itemAddQty').attr('max', parseFloat(res.data.qty));
                itemTemp = res.data;
                $('#modalAddItem').modal("show");
            }
        });
    }

    const deleteItem = (rowId) => {
        $(`#listRow${rowId}`).remove();
        itemAdded = itemAdded.filter(item => item.row_id !== rowId);

        if (itemAdded.length == 0) {
            $('#tbodyListAdded').append(`<tr>
                                            <td colspan="10">No data available in table</td>
                                        </tr>`);
        }
    }
</script>
