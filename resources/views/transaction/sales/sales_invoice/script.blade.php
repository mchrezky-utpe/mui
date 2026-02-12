<script>
    let listItemTable;
    let salesInvoiceListTable;
    let salesInvoiceDetailListTable;
    let itemTempCount = 0;
    let listItemTemp = [];

    $(function() {
        $('.select2-create').select2({
            dropdownParent: $('#modalCreate')
        });

        $('#currencyFilter').select2();

        salesInvoiceListTable = $('#salesInvoiceListTable').DataTable({
            destroy: true,
            serverSide: true,
            processing: true,
            scrollX: true,
            scrollY: "500px",
            scrollCollapse: true,
            autoWidth: false,
            ajax: {
                url: `{{ url('/transaction/sales/sales_invoice/all') }}`,
                method: "GET",
                data: function(d) {
                    d.startDate = $('#fromDateFilter').val();
                    d.endDate = $('#untilDateFilter').val();
                    d.currency = $('#currencyFilter').val();
                },
                beforeSend: function() {
                    $('#salesInvoiceListTable tbody').html(`
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
                title: 'No',
                data: null,
                orderable: false,
                searchable: false,
                className: 'text-center',
                render: function(data, type, row, meta) {
                    return meta.row + 1 + '.';
                }
            }, {
                title: "Date",
                data: "invoice_date"
            }, {
                title: "Tax Date",
                data: "tax_date"
            }, {
                title: "Invoice Number",
                data: "invoice_number"
            }, {
                title: "Tax Number",
                data: "tax_number"
            }, {
                title: "Customer",
                data: "customer_name"
            }, {
                title: "Phase",
                data: "invoice_phase"
            }, {
                title: "Currency",
                data: "currency"
            }, {
                title: "Exchange Rate",
                data: "exchange_rate"
            }, {
                title: "Sub Total",
                data: "sub_total_amount"
            }, {
                title: "PPN",
                data: "ppn_amount"
            }, {
                title: "Total Payment",
                data: "total_payment_amount"
            }, {
                title: "Invoice Status",
                data: null,
                render: function(data, type, row, meta) {
                    return "-"
                }
            }, {
                title: "Tax Status",
                data: null,
                render: function(data, type, row, meta) {
                    return "-"
                }
            }, {
                title: "DO Status",
                render: function(data, type, row, meta) {
                    return `<div class="bg-danger" style="min-width: 20px; min-height: 20px; display: inline-block; border-radius: 4px;">&nbsp;</div>`
                }
            }]
        });

        $(document).on('click', '#applyFilterSI', function(e) {
            e.preventDefault();
            salesInvoiceListTable.ajax.reload();
        });

        salesInvoiceDetailListTable = $('#salesInvoiceDetailListTable').DataTable({
            destroy: true,
            serverSide: true,
            processing: true,
            scrollX: true,
            scrollY: "500px",
            scrollCollapse: true,
            autoWidth: false,
            ajax: {
                url: `{{ url('/transaction/sales/sales_invoice/all-detail') }}`,
                method: "GET",
                data: function(d) {
                    d.startDate = $('#fromDateFilterDetail').val();
                    d.endDate = $('#untilDateFilterDetail').val();
                    d.currency = $('#currencyFilterDetail').val();
                },
                beforeSend: function() {
                    $('#salesInvoiceDetailListTable tbody').html(`
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
                title: 'No',
                data: null,
                orderable: false,
                searchable: false,
                className: 'text-center',
                render: function(data, type, row, meta) {
                    return meta.row + 1 + '.';
                }
            }, {
                title: "Date",
                data: "invoice_date"
            }, {
                title: "Invoice Number",
                data: "invoice_number"
            }, {
                title: "Item Code",
                data: "item_code"
            }, {
                title: "Part Name",
                data: "sku_name"
            }, {
                title: "Part Number",
                data: "sku_specification_code"
            }, {
                title: "Unit",
                data: "sku_inventory_unit"
            }, {
                title: "Currency",
                data: "currency"
            }, {
                title: "Exchange Rate",
                data: "exchange_rate"
            }, {
                title: "Price",
                data: "price",
                render: function(data, type, row, meta) {
                    return parseFloat(data);
                }
            }, {
                title: "Quantity",
                data: "qty",
                render: function(data, type, row, meta) {
                    return parseFloat(data);
                }
            }]
        });

        $(document).on('click', '#applyFilterSIDetail', function(e) {
            e.preventDefault();
            salesInvoiceDetailListTable.ajax.reload();
        });

        $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function(event) {
            let tabId = $(event.target).attr('data-bs-target');

            if (tabId === '#nav-si') {
                salesInvoiceListTable.ajax.reload();
            } else {
                salesInvoiceDetailListTable.ajax.reload();
            }
        });

        $(document).on('click', '#searchDataButton', function(e) {
            e.preventDefault();
            const customer = $('#customerSelect').val();
            if (!customer) {
                Swal.fire({
                    title: 'Customer Required',
                    text: 'Please enter the customer before proceeding.',
                    icon: 'warning',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                });
                return;
            }
            const valExchange = $('#exchangeRateInput').val();
            if (!valExchange) {
                Swal.fire({
                    title: 'Exchange Rate Required',
                    text: 'Please enter the exchange rate before proceeding.',
                    icon: 'warning',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                });
                return;
            }

            const typeVal = $('input[name="searchTypeRadio"]:checked').val();
            initListItemDatatable(typeVal);
        });

        $('#listItemTable').on('preXhr.dt', function() {
            $('#listItemTable tbody').html(`
                <tr>
                    <td colspan="100%" class="text-center p-3">
                        <div class="dt-spinner"></div>
                        Loading data...
                    </td>
                </tr>
            `);
        });

        $(document).on('change', '#invoiceTypeSelect', function(e) {
            e.preventDefault();
            const val = $(this).val();
            if (val == 'Regular') {
                $('#invoicePhaseSelect').val('Final Payment').trigger('change');
                $('#invoicePhaseSelect').attr('disabled', true);
            } else {
                $('#invoicePhaseSelect').val(null).trigger('change');
                $('#invoicePhaseSelect').attr('disabled', false);
            }
        });

        $(document).on('change', '#invoicePhaseSelect', function(e) {
            e.preventDefault();
            const val = $(this).val();
            if (val == 'Final Payment') {
                $('#partialPayCheck').prop('disabled', true);
            } else {
                $('#partialPayCheck').prop('disabled', false);
            }
            calculateGrandTotal();
        })

        $(document).on('change', '#currencySelect', function(e) {
            e.preventDefault();
            const val = $(this).val();
            if (!val) {
                $('#exchangeRateInput').val("");
                $('#exchangeRateInput').attr('disabled', true);
                return;
            } else if (val == 'IDR') {
                $('#exchangeRateInput').val(1);
                $('#exchangeRateInput').attr('disabled', true);
                return;
            }

            $.ajax({
                url: `{{ url('transaction/sales/sales_invoice/exchange-rate') }}`,
                method: "GET",
                data: {
                    currency: val,
                },
                success: function(res) {
                    if (res.data) {
                        $('#exchangeRateInput').val(res.data.val_exchangerates);
                        $('#exchangeRateInput').attr('disabled', false);
                    } else {
                        $('#exchangeRateInput').val("");
                        $('#exchangeRateInput').attr('disabled', false);
                    }
                }
            });
        });

        $(document).on('input', '.decimal-input', function() {
            this.value = this.value
                .replace(/[^0-9.]/g, '')
                .replace(/(\..*?)\..*/g, '$1')
                .replace(/(\.\d{2}).*/g, '$1');
        });

        $(document).on('input', '.number-default-zero', function() {
            if ($(this).val() === '') {
                $(this).val(0);
            }
        });

        $(document).on('change', '#ppnCheck', function() {
            const isChecked = $(this).is(':checked');

            if (isChecked) {
                $('#ppnInput').prop("disabled", false);
                calculatePPN();
            } else {
                $('#ppnInput').prop("disabled", true);
                $('#ppnAmountInput').val('0');
            }
            calculateGrandTotal();
        });

        $(document).on('change', '#discountCheck', function() {
            const isChecked = $(this).is(':checked');

            if (isChecked) {
                $('#discountInput').prop("disabled", false);
                calculateDiscount();
            } else {
                $('#discountInput').prop("disabled", true);
                $('#discountAmountInput').val('0');
            }
            calculateGrandTotal();
        });

        $(document).on('change', '#pphCheck', function() {
            const isChecked = $(this).is(':checked');

            if (isChecked) {
                $('#pphInput').prop("disabled", false);
                calculatePPH();
            } else {
                $('#pphInput').prop("disabled", true);
                $('#pphAmountInput').val('0');
            }
            calculateGrandTotal();
        });

        $(document).on('change', '#partialPayCheck', function() {
            const isChecked = $(this).is(':checked');

            if (isChecked) {
                $('#partialPayInput').prop("disabled", false);
                calculatePartialPay();
            } else {
                $('#partialPayInput').prop("disabled", true);
                $('#partialPayAmountInput').val('0');
            }
            calculateGrandTotal();
        });

        $('#modalCreate').on('hidden.bs.modal', function() {
            $('#invoiceTypeSelect').val(null).trigger('change');
            $('#invoicePhaseSelect').val(null).trigger('change');
            $('#invoicePhaseSelect').prop('disabled', false);
            $('#invoiceDateInput').val(currentDate());
            $('#taxNumberInput').val("");
            $('#customerSelect').val("").trigger('change');
            $('#currencySelect').val("").trigger('change');
            $('#exchangeRateInput').val("");
            $('#exchangeRateInput').prop('disabled', true);
            $('#kmkDateInput').val(currentDate());
            $('#kmkNumberInput').val("");
            $('#topInput').val("").trigger('change');
            itemTempCount = 0;
            listItemTemp = [];
            $('input[name="searchDataButton"][value="doNumber"]').prop('checked', true);
            $('#tbodyListInvoiceItems').empty().append(`
            <tr>
                <td colspan="11" class="text-center">No data available</td>
            </tr>`);

            $('#subTotalInput').val("0");
            $('#totalInput').val("0");
            $('#grandTotalInput').val("0");
            $('#totalPaymentInput').val("0");
            $('#ppnCheck').prop('checked', false);
            $('#ppnInput').val(11).prop("disabled", true);
            $('#ppnAmountInput').val("0");
            $('#discountCheck').prop('checked', false);
            $('#discountInput').val(0).prop("disabled", true);
            $('#discountAmountInput').val("0");
            $('#totalServiceInput').val("0");
            $('#pphCheck').prop('checked', false);
            $('#pphInput').val(2).prop("disabled", true);
            $('#pphAmountInput').val("0");
            $('#partialPayCheck').prop('checked', false);
            $('#partialPayCheck').prop('disabled', false);
            $('#partialPayInput').val(0).prop("disabled", true);
            $('#partialPayAmountInput').val("0");

            const now = new Date();
            const year = now.getFullYear().toString().slice(-2);
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const prefixInvoiceNumber = `${year}/MUI/${month}`;
            $('#invoiceNumberInput').val(prefixInvoiceNumber);
        });

        $(document).on('click', '#createSubmitBtn', function(e) {
            e.preventDefault();

            const invoiceType = $('#invoiceTypeSelect').val();
            const invoicePhase = $('#invoicePhaseSelect').val();
            const invoiceDate = $('#invoiceDateInput').val();
            const invoiceNumber = $('#invoiceNumberInput').val();
            const taxNumber = $('#taxNumberInput').val();
            const customerId = $('#customerSelect').val();
            const currency = $('#currencySelect').val();
            const exchangeRate = $('#exchangeRateInput').val();
            const kmkDate = $('#kmkDateInput').val();
            const kmkNumber = $('#kmkNumberInput').val();
            const termsOfPayment = $('#topInput').val();

            if (!invoiceType) {
                alert('Invoice Type is required');
                return;
            }
            if (!invoicePhase) {
                alert('Invoice Phase is required');
                return;
            }
            if (!invoiceDate) {
                alert('Invoice Date is required');
                return;
            }
            if (!invoiceNumber) {
                alert('Invoice Number is required');
                return;
            }
            if (!customerId) {
                alert('Customer is required');
                return;
            }
            if (!currency) {
                alert('Currency is required');
                return;
            }
            if (!exchangeRate) {
                alert('Exchange Rate is required');
                return;
            }
            if (!termsOfPayment) {
                alert('Terms of Payment is required');
                return;
            }

            const isPartialChecked = $('#partialPayCheck').is(':checked');
            if (invoicePhase !== 'Final Payment' && !isPartialChecked) {
                alert('Partial Payment must be checked for this Invoice Phase');
                return;
            }

            let ppnPercentage = 0;
            let ppnAmount = 0;
            if ($('#ppnCheck').is(':checked')) {
                ppnPercentage = parseFloat($('#ppnInput').val() || 0);
                ppnAmount = parseFloat($('#ppnAmountInput').val() || 0);
            }
            let discountPercentage = 0;
            let discountAmount = 0;
            if ($('#discountCheck').is(':checked')) {
                discountPercentage = parseFloat($('#discountInput').val() || 0);
                discountAmount = parseFloat($('#discountAmountInput').val() || 0);
            }
            const totalServiceAmount = parseFloat($('#totalServiceInput').val() || 0)
            let pphPercentage = 0;
            let pphAmount = 0;
            if ($('#pphCheck').is(':checked')) {
                pphPercentage = parseFloat($('#pphInput').val() || 0);
                pphAmount = parseFloat($('#pphAmountInput').val() || 0);
            }
            let partialPayPercentage = 0;
            let partialPayAmount = 0;
            if ($('#partialPayCheck').is(':checked')) {
                partialPayPercentage = parseFloat($('#partialPayInput').val() || 0);
                partialPayAmount = parseFloat($('#partialPayAmountInput').val() || 0);
            }
            const subTotalAmount = parseFloat($('#subTotalInput').val() || 0);
            const totalAmount = parseFloat($('#totalInput').val() || 0);
            const grandTotalAmount = parseFloat($('#grandTotalInput').val() || 0);
            const totalPaymentAmount = parseFloat($('#totalPaymentInput').val() || 0);

            const bodyData = {
                invoiceType,
                invoicePhase,
                invoiceDate,
                invoiceNumber,
                taxNumber,
                customerId,
                currency,
                exchangeRate,
                kmkDate,
                kmkNumber,
                termsOfPayment,
                ppnPercentage,
                ppnAmount,
                discountPercentage,
                discountAmount,
                totalServiceAmount,
                pphPercentage,
                pphAmount,
                partialPayPercentage,
                partialPayAmount,
                subTotalAmount,
                totalAmount,
                grandTotalAmount,
                totalPaymentAmount
            };

            $('#createSubmitBtn').html(`<i class="fas fa-spinner fa-spin mr-1"></i> Please wait...`)
                .attr(
                    'disabled', true);

            $.ajax({
                url: `{{ url('transaction/sales/sales_invoice/create-invoice') }}`,
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    ...bodyData,
                    listItems: listItemTemp
                },
                success: function(res) {
                    if (res.success) {
                        Swal.fire({
                            title: 'Success',
                            text: 'Invoice has been created successfully.',
                            icon: 'success',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        });
                        $('#modalCreate').modal('hide');
                        salesInvoiceListTable.ajax.reload();
                        salesInvoiceDetailListTable.ajax.reload();
                    } else {
                        Swal.fire({
                            text: res.message,
                            icon: 'warning',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function(err) {
                    console.error(err);
                },
                complete: function() {
                    $('#createSubmitBtn').html('Save').attr('disabled', false);
                }
            });
        });
    });

    const showCreateModal = () => {
        $('#modalCreate').modal('show');
        initListItemDatatable();
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

        if (!searchType || searchType == 'doNumber') {
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
            }, {
                title: "Action",
                data: "id",
                render: function(data, typeCol, row, meta) {
                    return `<button class="btn btn-sm btn-success" onclick="addItemDONumber(${data})">+</button>`
                }
            });
        } else {
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
            }, {
                title: "Item Name",
                data: "sku_name"
            }, {
                title: "Part Number",
                data: "sku_specification_code"
            }, {
                title: "Unit",
                data: "sku_inventory_unit"
            }, {
                title: "Qty",
                data: "qty"
            }, {
                title: "Currency",
                data: "currency"
            }, {
                title: "Price",
                data: "price"
            }, {
                title: "Action",
                data: "id",
                render: function(data, typeCol, row, meta) {
                    let rowData = JSON.stringify(row).replace(/"/g, '&quot;');
                    return `<button class="btn btn-sm btn-success" onclick="addItemPart(${rowData})">+</button>`
                }
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
                data: function(d) {
                    d.searchType = searchType;
                    d.customer = $('#customerSelect').val();
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

    const addItemDONumber = (id) => {
        const exchangeRate = parseFloat($('#exchangeRateInput').val() || 1);
        $.ajax({
            url: "{{ url('transaction/sales/sales_invoice/source/detail') }}",
            method: "GET",
            data: {
                id
            },
            success: function(res) {
                const data = res.data;
                if (data.length > 0) {
                    const hasDuplicate = data.some(rowData =>
                        listItemTemp.some(val => val.id == rowData.id)
                    );

                    if (hasDuplicate) {
                        Swal.fire({
                            title: 'Already Added',
                            text: 'This item is already in your list.',
                            icon: 'warning',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        });
                        return;
                    }

                    data.forEach(item => {
                        listItemTemp.push({
                            rowNumber: itemTempCount + 1,
                            id: item.id,
                            deliveryOrderId: item.delivery_order_id,
                            poNumber: item.po_number,
                            cdsCode: item.cds_code,
                            doDate: item.do_date,
                            doNumber: item.do_number,
                            skuId: item.sku_id,
                            itemCode: item.item_code,
                            itemName: item.sku_name,
                            partNumber: item.sku_specification_code,
                            qty: parseFloat(item.qty),
                            price: item.price,
                            totalPrice: item.price * parseFloat(item.qty) * exchangeRate
                        });

                        if (listItemTemp.length == 1) {
                            $('#tbodyListInvoiceItems').empty();
                        }

                        $('#tbodyListInvoiceItems').append(`
                            <tr id="listRowItem${itemTempCount+1}">
                                <td>${item.po_number}</td>
                                <td>${item.cds_code}</td>
                                <td>${item.do_date}</td>
                                <td>${item.do_number}</td>
                                <td>${item.item_code}</td>
                                <td>${item.sku_name}</td>
                                <td>${item.sku_specification_code}</td>
                                <td>${parseFloat(item.qty)}</td>
                                <td>${item.price}</td>
                                <td>${item.price * parseFloat(item.qty)}</td>
                                <td><button type="button" class="btn btn-sm btn-danger" onclick="deleteRowItem(${itemTempCount+1})"><i class="fas fa-trash"></i></button></td>
                            </tr>
                        `);

                        itemTempCount += 1;
                    });

                    calculateTotal();
                    calculateGrandTotal();
                }
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        })

    }

    const addItemPart = (rowData) => {
        const exchangeRate = parseFloat($('#exchangeRateInput').val() || 1);
        const isExist = listItemTemp.some(val => val.id == rowData.id);
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

        listItemTemp.push({
            rowNumber: itemTempCount + 1,
            id: rowData.id,
            deliveryOrderId: rowData.delivery_order_id,
            poNumber: rowData.po_number,
            cdsCode: rowData.cds_code,
            doDate: rowData.do_date,
            doNumber: rowData.do_number,
            skuId: rowData.sku_id,
            itemCode: rowData.item_code,
            itemName: rowData.sku_name,
            partNumber: rowData.sku_specification_code,
            qty: parseFloat(rowData.qty),
            price: rowData.price,
            totalPrice: rowData.price * parseFloat(rowData.qty) * exchangeRate
        });

        if (listItemTemp.length == 1) {
            $('#tbodyListInvoiceItems').empty();
        }

        $('#tbodyListInvoiceItems').append(`
            <tr id="listRowItem${itemTempCount+1}">
                <td>${rowData.po_number}</td>
                <td>${rowData.cds_code}</td>
                <td>${rowData.do_date}</td>
                <td>${rowData.do_number}</td>
                <td>${rowData.item_code}</td>
                <td>${rowData.sku_name}</td>
                <td>${rowData.sku_specification_code}</td>
                <td>${parseFloat(rowData.qty)}</td>
                <td>${rowData.price}</td>
                <td>${rowData.price * parseFloat(rowData.qty)}</td>
                <td><button type="button" class="btn btn-sm btn-danger" onclick="deleteRowItem(${itemTempCount+1})"><i class="fas fa-trash"></i></button></td>
            </tr>
        `);

        itemTempCount += 1;
        calculateTotal();
        calculateGrandTotal();
    }

    const deleteRowItem = (rowNumber) => {
        listItemTemp = listItemTemp.filter(val => val.rowNumber != rowNumber);
        $('#listRowItem' + rowNumber).remove();

        if (listItemTemp.length == 0) {
            $('#tbodyListInvoiceItems').append(`
            <tr>
                <td colspan="11" class="text-center">No data available</td>
            </tr>`);
        }
        calculateTotal();
        calculateGrandTotal();
    }

    const calculateTotal = () => {
        const totalItemPrice = listItemTemp.reduce((sum, item) => sum + item.totalPrice, 0);
        $('#subTotalInput').val(totalItemPrice.toFixed(2));
        $('#totalInput').val(totalItemPrice.toFixed(2));
    }

    const currentDate = () => {
        const today = new Date();
        const year = today.getFullYear();
        const month = String(today.getMonth() + 1).padStart(2, '0');
        const day = String(today.getDate()).padStart(2, '0');

        return `${year}-${month}-${day}`;
    }

    const calculatePPN = () => {
        const subTotal = parseFloat($('#subTotalInput').val()) || 0;
        const ppnPercent = parseFloat($('#ppnInput').val()) || 0;

        if (subTotal > 0 && ppnPercent > 0) {
            let ppnAmount = subTotal * (ppnPercent / 100);
            ppnAmount = ppnAmount.toFixed(2);

            $('#ppnAmountInput').val(ppnAmount);
        } else {
            $('#ppnAmountInput').val("0");
        }
    }

    const calculateDiscount = () => {
        const subTotal = parseFloat($('#subTotalInput').val()) || 0;
        const discountPercent = parseFloat($('#discountInput').val()) || 0;

        if (subTotal > 0 && discountPercent > 0) {
            let discountAmount = subTotal * (discountPercent / 100);
            discountAmount = discountAmount.toFixed(2);

            $('#discountAmountInput').val(discountAmount);
        } else {
            $('#discountAmountInput').val("0");
        }
    }

    const calculatePPH = () => {
        const subTotal = parseFloat($('#subTotalInput').val()) || 0;
        const pphPercent = parseFloat($('#pphInput').val()) || 0;

        if (subTotal > 0 && pphPercent > 0) {
            let pphAmount = subTotal * (pphPercent / 100);
            pphAmount = pphAmount.toFixed(2);

            $('#pphAmountInput').val(pphAmount);
        } else {
            $('#pphAmountInput').val("0");
        }
    }

    const calculatePartialPay = () => {
        const subTotal = parseFloat($('#subTotalInput').val()) || 0;
        const partialPayPercent = parseFloat($('#partialPayInput').val()) || 0;

        if (subTotal > 0 && partialPayPercent > 0) {
            let partialPayAmount = subTotal * (partialPayPercent / 100);
            partialPayAmount = partialPayAmount.toFixed(2);

            $('#partialPayAmountInput').val(partialPayAmount);
        } else {
            $('#partialPayAmountInput').val("0");
        }
    }

    const calculateGrandTotal = () => {
        const subTotal = parseFloat($('#subTotalInput').val()) || 0;
        const ppnAmount = parseFloat($('#ppnAmountInput').val()) || 0;
        const discountAmount = parseFloat($('#discountAmountInput').val()) || 0;
        const totalServiceAmount = parseFloat($('#totalServiceInput').val()) || 0;
        const pphAmount = parseFloat($('#pphAmountInput').val()) || 0;

        const grandTotal = subTotal + ppnAmount - discountAmount + totalServiceAmount + pphAmount;
        if (grandTotal > 0) {
            $('#grandTotalInput').val(grandTotal.toFixed(2));
        } else {
            $('#grandTotalInput').val(0);
        }
        calculateTotalPayment();
    }

    const calculateTotalPayment = () => {
        const grandTotal = parseFloat($('#grandTotalInput').val()) || 0;
        const isPartialPayDisabled = $('#partialPayCheck').prop('disabled');

        if (isPartialPayDisabled) {
            if (grandTotal > 0) {
                $('#totalPaymentInput').val(grandTotal.toFixed(2));
            } else {
                $('#totalPaymentInput').val(0);
            }
        } else {
            const partialPayAmount = parseFloat($('#partialPayAmountInput').val()) || 0;
            if (partialPayAmount > 0) {
                $('#totalPaymentInput').val(partialPayAmount.toFixed(2));
            } else {
                $('#totalPaymentInput').val(0);
            }
        }
    }
</script>
