<!-- script for delivery_order -->
<script>
    let itemTemp = null;
    let itemAdded = [];
    let tableDO;
    let tableDODetail;

    $(function() {
        initDatatableDOList();
        initDatatable();

        $(document).on('click', '#searchDataBtn', function(e) {
            e.preventDefault();
            const type = $('#doTypeSelect').val();
            const subType = $('#subDoTypeSelect').val();
            console.log(type, subType);
            initDatatable(type, subType);
        });

        $(document).on('change', '#customerInput', function(e) {
            e.preventDefault();
            const val = $(this).val();
            $('#doDestinationSelect').val(null).trigger('change');
            $('#destinationCode').val(null);
            $('#destinationAddress').val(null);

            $.ajax({
                url: "{{ url('/transaction/inventory/delivery_order/get-destination') }}",
                method: "GET",
                data: {
                    type: "select",
                    customerId: val,
                },
                success: function(result) {
                    $('#doDestinationSelect').empty();
                    $('#doDestinationSelect').append(
                        '<option value="">-- Select Destination</option>'
                    )
                    result.data.forEach((item) => {
                        $('#doDestinationSelect').append(
                            `<option value="${item.id}">${item.destination_name}</option>`
                        )
                    })
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        });

        $(document).on('change', '#doDestinationSelect', function() {
            const val = $(this).val();
            if (!val) return;

            $.ajax({
                url: "{{ url('/transaction/inventory/delivery_order/get-destination') }}",
                method: "GET",
                data: {
                    id: val
                },
                success: function(result) {
                    $('#destinationCode').val(result.data.destination_code);
                    $('#destinationAddress').val(result.data.destination_address);
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        });

        $('#itemAddQty').on('input', function(e) {
            e.preventDefault();
            let max = parseFloat($(this).attr('max'));
            let val = parseFloat($(this).val());

            itemTemp.qty = val;
            if (val > max) {
                $(this).val(max);
                itemTemp.qty = max;
            }

            let qtyPerPkg = parseFloat($('#itemAddQtyPerPackage').val()) || 0;

            let newTotalPackage = 0;
            if (qtyPerPkg > 0 && val > 0) {
                newTotalPackage = Math.ceil(val / qtyPerPkg);
            }
            itemTemp.totalPackaging = newTotalPackage;

            if (newTotalPackage > 0) {
                $('#itemBtnAdd').attr('disabled', false);
            } else {
                $('#itemBtnAdd').attr('disabled', true);
            }

            $('#itemAddQtyTotalPackage').val(newTotalPackage);
        });

        $('#modalAddItem').on('hidden.bs.modal', function() {
            itemTemp = null;
            $('#tbodyAddItem').empty();
            $('#itemAddId').val("");
            $('#itemAddType').val("");
            $('#itemAddQty').val("");
            $('#itemAddQty').attr('max', 0);
            $('#itemAddQtyPerPackage').val("");
            $('#itemAddQtyStockPackage').val("");
            $('#itemAddQtyTotalPackage').val("");
            $('#itemBtnAdd').attr('disabled', true);
        });

        $(document).on('click', '#itemBtnAdd', function(e) {
            e.preventDefault();
            itemAdded.push(itemTemp);

            if (itemAdded.length == 1) {
                $('#tbodyListAdded').empty();
            }

            $('#tbodyListAdded').append(`
                <tr>
                    <td>${itemTemp.poNumber ? itemTemp.poNumber : ""}</td>
                    <td>${itemTemp.cdsCode ? itemTemp.cdsCode : ""}</td>
                    <td>${itemTemp.itemCode? itemTemp.itemCode : ""}</td>
                    <td>${itemTemp.itemName? itemTemp.itemName : ""}</td>
                    <td>${itemTemp.partNumber? itemTemp.partNumber : ""}</td>
                    <td>${itemTemp.businessType? itemTemp.businessType : ""}</td>
                    <td>${itemTemp.model? itemTemp.model : ""}</td>
                    <td>${itemTemp.qty}</td>
                </tr>
            `);

            // Reset
            itemTemp = null;

            $('#modalAddItem').modal('hide');
        });

        $(document).on('click', '#btnSaveDO', function(e) {
            e.preventDefault();

            const doDate = $('#doDateInput').val();
            const customer = $('#customerInput').val();
            const doType = $('#doTypeSelect').val();
            const doDestination = $('#doDestinationSelect').val();
            const vehicle = $('#vrpSelect').val();
            const subDoType = $('#subDoTypeSelect').val();
            const driver = $('#driverSelect').val();
            const deliveryNote = $('#noteInput').val();

            if (!doDate || !customer || !doType || !doDestination || !vehicle || !subDoType || !
                driver) {
                alert("Please fill out required fields!");
                return;
            }

            $('#btnSaveDO').html(`<i class="fas fa-spinner fa-spin mr-1"></i> Please wait...`).attr(
                'disabled', true);

            $.ajax({
                url: `{{ url('/transaction/inventory/delivery_order/create-do') }}`,
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    doDestinationType: "Customer",
                    doDate: doDate,
                    customer: customer,
                    doType: doType,
                    doDestination: doDestination,
                    vehicle: vehicle,
                    subDoType: subDoType,
                    driver: driver,
                    deliveryNote: deliveryNote,
                    listItem: itemAdded
                },
                success: function(res) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Delivery order created successfully',
                        icon: 'success',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });

                    window.location.href =
                        `{{ url('transaction/inventory/delivery_order') }}`;
                },
                complete: function() {
                    $('#btnSaveDO').html('Save').attr('disabled', false);
                }
            });
        });

        $('#deliveryOrderTable tbody').on('click', 'td.dt-control', function() {
            var tr = $(this).closest('tr');
            var row = tableDO.row(tr);

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

            if (tabId === '#nav-do') {
                initDatatableDOList();
            } else {
                initDatatableDODetailList();
            }
        });
    });

    const initDatatableDOList = () => {
        tableDO = $('#deliveryOrderTable').DataTable({
            destroy: true,
            serverSide: true,
            processing: true,
            scrollX: true,
            autoWidth: false,
            ajax: {
                url: `{{ url('/transaction/inventory/delivery_order/get-all') }}`,
                method: "GET",
                data: {
                    doType: "tes"
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
                title: "DO Number",
                data: 'do_number',
            }, {
                title: "DO Date",
                data: 'do_date',
            }, {
                title: "DO Type",
                data: 'do_type',
            }, {
                title: "Sub DO Type",
                data: 'do_sub_type',
            }, {
                title: "Customer / Supplier",
                data: null,
                render: function(data, type, row, meta) {
                    return row.do_destination_type == 'Customer' ? row.customer_name : row
                        .supplier_name;
                }
            }, {
                title: "Delivery Note",
                data: 'do_note',
            }, {
                title: "Officer",
                data: 'do_officer_name',
            }, {
                title: "Print Status",
                data: 'status',
            }, {
                title: "Return Date",
                data: 'return_date',
            }, {
                title: "Check Return",
                data: null,
                render: function(data, type, row, meta) {
                    return `<input type="checkbox" class="form-control form-control-sm mr-1"/>`;
                }
            }, {
                title: "Action",
                data: null,
                render: function(data, type, row, meta) {
                    return `<button class="btn btn-sm btn-secondary"><i class="fas fa-print"></i></button>`;
                }
            }]
        });
    }

    const formatDetail = (d) => {
        let element = ``;
        if (d.details.length > 0) {
            d.details.forEach(dRow => {
                let element2 = ``;
                if (dRow.source_type == 'SKU') {
                    element2 = `<td class="text-right">${dRow.val_conversion}</td>`;
                } else if (dRow.source_type == 'CDS') {
                    element2 = `<td class="text-right">${dRow.outstanding}</td>`;
                }

                element += `<tr>
                    <td>${dRow.po_number || ""}</td>
                    <td>${dRow.customer_delivery_number || ""}</td>
                    <td>${dRow.sku_id || ""}</td>
                    <td>${dRow.sku_name || ""}</td>
                    <td>${dRow.sku_specification_code || ""}</td>
                    <td>${dRow.sku_business_type || ""}</td>
                    <td>${dRow.sku_model || ""}</td>
                    <td>${dRow.sku_inventory_unit || ""}</td>
                    <td class="text-right">${parseFloat(dRow.qty)}</td>
                    ${element2}
                </tr>`
            })
        } else {
            element += `<tr><td colspan="10">No data available.</td></tr>`
        }

        return `<table class="table table-bordered">
            <thead class="table-secondary">
                <tr>
                    <th>PO Number</th>
                    <th>Cust. Delivery Number</th>
                    <th>Item Code</th>
                    <th>Item Name</th>
                    <th>Part Number</th>
                    <th>Business Type</th>
                    <th>Model</th>
                    <th>Unit</th>
                    <th>Quantity</th>
                    <th>Outstanding</th>
                </tr>
            </thead>
            <tbody>${element}</tbody>
        </table>`;
    }

    const initDatatableDODetailList = () => {
        tableDODetail = $('#deliveryOrderDetailTable').DataTable({
            destroy: true,
            serverSide: true,
            processing: true,
            scrollX: true,
            autoWidth: false,
            ajax: {
                url: `{{ url('/transaction/inventory/delivery_order/get-all-detail') }}`,
                method: "GET",
                data: {
                    doType: "tes"
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
                data: 'do_date',
            }, {
                title: "DO Number",
                data: 'do_number',
            }, {
                title: "PO Number",
                data: 'po_number',
            }, {
                title: "Cust. Delivery Number",
                data: 'customer_delivery_number',
            }, {
                title: "Customer / Supplier",
                data: null,
                render: function(data, type, row, meta) {
                    return row.do_destination_type == 'Customer' ? row.customer_name : row
                        .supplier_name;
                }
            }, {
                title: "Item Code",
                data: "sku_id",
            }, {
                title: "Item Name",
                data: "sku_name",
            }, {
                title: "Part Number",
                data: "sku_specification_code",
            }, {
                title: "Item Type",
                data: "sku_type",
            }, {
                title: "Unit",
                data: "sku_inventory_unit",
            }, {
                title: "Quantity",
                data: "qty",
                className: "text-right",
                render: function(data, type, row, meta) {
                    return parseFloat(row.qty);
                }
            }, {
                title: "OS",
                data: null,
                className: "text-right",
                render: function(data, type, row, meta) {
                    if (row.source_type == "SKU") {
                        return row.val_conversion;
                    } else if (row.source_type == "CDS") {
                        return row.outstanding;
                    } else {
                        return 0;
                    }
                }
            }]
        });
    }

    const initDatatable = (type = null, subType) => {
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

        if (type === 'Replacement') {
            columns.push({
                data: 'supplier_name'
            }, {
                data: 'warehouse'
            });
        }

        if (type === 'Sample Part' || type === 'Regular') {
            columns.push({
                title: "Delivery Date",
                data: "delivery_date",
            }, {
                title: "PO Number",
                data: "po_number",
            }, {
                title: "CDS Code",
                data: "cds_code",
            }, {
                title: "CD Number",
                data: "cd_number",
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
                title: "Business Type",
                data: "sku_business_type",
            }, {
                title: "Model",
                data: 'sku_model',
            });
        }

        if (type === 'Sample Part') {
            columns.push({
                title: "Quantity",
                data: 'val_conversion',
            }, {
                title: "OS",
                data: 'val_conversion',
            });
        } else if (type === 'Regular') {
            columns.push({
                title: "Quantity",
                data: 'quantity_cds',
            }, {
                title: "OS",
                data: 'outstanding',
            });
        }

        columns.push({
            title: "Action",
            data: "id",
            render: function(data, typeCol, row, meta) {
                let sourceType = null;
                if (type == 'Sample Part') {
                    sourceType = 'SKU';
                } else if (type == 'Regular') {
                    sourceType = 'CDS';
                } else if (type == 'Replacement') {
                    sourceType = 'CR';
                }
                return `<button class="btn btn-sm btn-success" onclick="showAddItem('${sourceType}', ${row.id})">+</button>`
            }
        })

        if ($.fn.DataTable.isDataTable('#deliveryOrderCreateTable')) {
            $('#deliveryOrderCreateTable').DataTable().destroy();
            $('#deliveryOrderCreateTable').empty();
        }

        if ($('#deliveryOrderCreateTable thead').length === 0) {
            $('#deliveryOrderCreateTable').append('<thead class="table-dark"></thead>');
        }

        if (!type) {
            $('#deliveryOrderCreateTable').DataTable({
                destroy: true,
                autoWidth: false,
                columns: [{
                    title: "No",
                    data: null
                }, {
                    title: "Delivery Date",
                    data: null
                }, {
                    title: "PO Number",
                    data: null
                }, {
                    title: "CDS Code",
                    data: null
                }, {
                    title: "CD Number",
                    data: null
                }, {
                    title: "Part Code",
                    data: null
                }, {
                    title: "Part Name",
                    data: null
                }, {
                    title: "Part Number",
                    data: null
                }, {
                    title: "Business Type",
                    data: null
                }, {
                    title: "Model",
                    data: null
                }, {
                    title: "Quantity",
                    data: null
                }, {
                    title: "OS",
                    data: null
                }, {
                    title: "Action",
                    data: null
                }]
            });
        } else {
            $('#deliveryOrderCreateTable').DataTable({
                destroy: true,
                processing: true,
                scrollX: true,
                scrollY: "400px",
                scrollCollapse: true,
                autoWidth: false,
                ajax: {
                    url: `{{ url('/transaction/inventory/delivery_order/get-delivery-source') }}`,
                    method: "GET",
                    data: {
                        doType: type,
                        subDoType: subType
                    },
                    dataSrc: function(res) {
                        if (!res.success) {
                            alert(res.message);
                            return [];
                        }
                        return res.data;
                    }
                },
                columns: columns
            });
        }
    }

    const showAddItem = (itemType, itemId) => {
        $.ajax({
            url: `{{ url('/transaction/inventory/delivery_order/item-detail') }}`,
            method: "GET",
            data: {
                itemType: itemType,
                itemId: itemId
            },
            success: function(res) {
                const bgColor = res.data.sku.val_conversion > 0 ? 'bg-success' : 'bg-danger';
                const qtyTotalPackage = res.data.qtyPerPackaging > 0 ? Math.ceil(res.data.sku
                    .val_conversion / res.data.qtyPerPackaging) : 0

                $('#tbodyAddItem').append(`
                    <tr>
                        <td>${res.data.sku.sku_id}</td>
                        <td>${res.data.sku.sku_name}</td>
                        <td>${res.data.sku.val_conversion}</td>
                        <td class="text-center"><div class="${bgColor}" style="min-width: 20px; min-height: 20px; display: inline-block; border-radius: 4px;">&nbsp;</div></td>
                    </tr>
                `);
                $('#itemAddId').val(itemId);
                $('#itemAddType').val(itemType);
                $('#itemAddQty').val(res.data.sku.val_conversion);
                $('#itemAddQty').attr('max', res.data.sku.val_conversion);
                $('#itemAddQtyPerPackage').val(res.data.qtyPerPackaging);
                $('#itemAddQtyStockPackage').val(res.data.qtyPackaging);
                $('#itemAddQtyTotalPackage').val(qtyTotalPackage);

                if (qtyTotalPackage > 0) {
                    $('#itemBtnAdd').attr('disabled', false);
                }

                itemTemp = {
                    id: itemId,
                    skuId: res.data.sku.id,
                    type: itemType,
                    poNumber: res.data.sku.po_number,
                    cdsCode: res.data.sku.cds_code,
                    itemCode: res.data.sku.sku_id,
                    itemName: res.data.sku.sku_name,
                    partNumber: res.data.sku.sku_specification_code,
                    businessType: res.data.sku.sku_business_type,
                    model: res.data.sku.sku_model,
                    qty: res.data.sku.val_conversion,
                    packagingCategoryId: res.data.packagingCategory?.id || null,
                    totalPackaging: qtyTotalPackage
                };

                $('#modalAddItem').modal('show');
            }
        });
    }
</script>
