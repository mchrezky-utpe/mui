$(document).ready(function () {

    // =========== GET DATA PAGEABLE
   const table_bom =  $("#table-bom").DataTable({
        fixedColumns: {
            start: 0,
            end: 5,
        },
        scrollCollapse: true,
        scrollX: true,
        scrollY: 300,

        processing: true,
        serverSide: true,
        ajax: {
            url: base_url + "bom/all/pageable",
            type: "GET",
            data: function (d) {
            },
        },
        order: [
            [3, "desc"],
            [2, "desc"],
        ],
        columns: [
            {
                data: null,
            },
            {
                data: "prefix",
            },
            {
                data: "sku_id",
            },
            {
                data: "sku_name",
            },
            {
                data: "sku_model",
            },
            {
                data: "remark",
            },
            {
                data: "verification",
            },
            {
                data: "status",
            },
            {
                data: "main_priority",
            },
            {
                data: null,
            },
        ],
        columnDefs: [
            {
                targets: 0,
                orderable: false,
                searchable: false,
                render:  function (data, type, row, meta) {
                    return `<button class="btn btn-sm btn-info view-details" data-id="${data.id}" >Detail</button>'`;
                }
            },
            {
                targets: 9,
                orderable: false,
                searchable: false,
                render: function (data, type, row, meta) {
                    const csrfToken = document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content");
                    return (
                        `
                        <form action="/bom/` +
                        data.id +
                        `/delete" method="post" onsubmit="return confirm('Are you sure you want to delete it?')">
						<div class="d-flex">
							<input type="hidden" name="_token" value="${csrfToken}">
							<a  target="/bom/edit"   href="bom/` + data.id +`/edit" class="btn btn-success">
							 <span class="fas fa-pencil-alt"></span>
                            </a>
                            <button type="submit" class="btn btn-danger">
                            <span class="fas fa-trash"></span>
                            </button>
						</div>
						</form>
                    `
                    );
                },
            },
        ],
    });

    // =========== HANDLING PARAM
    initParam();
    function populateSelectSku(title, master_data, element) {
        element.empty();
        element.append('<option value="">-- Select ' + title + " --</option>");
        master_data.forEach((data) => {
            element.append(
                `<option sku_id="${data.sku_id}" unit="${data.sku_procurement_unit}" value="${data.id}">${data.sku_name}</option>`
            );
        });
    }

    function initParam() {
        fetchSkuMaster()
            .then((data) => {
                console.log("Succesfully get Sku:", data);
                populateSelectSku("Sku", data, $("[name=sku_id]"));
            })
            .catch((err) => {
                console.error("Error get Sku:", err);
            });
    }
    
    function fetchSkuMaster() {
        return new Promise((resolve, reject) => {
            $.ajax({
                type: "GET",
                url: base_url + "api/sku-part-information",
                success: function (data) {
                    resolve(data.data);
                },
                error: function (err) {
                    console.error("Error fetching terms master:", err);
                    reject(err);
                },
            });
        });
    }


    // Expand row on button click
    $('#table-bom tbody').on('click', '.view-details', function() {
        var tr = $(this).closest('tr');
        var row = table_bom.row(tr);
        var id = $(this).data('id');

        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass('shown');
        } else {
            $.ajax({
                url: '/bom/'+id+'/items',
                type: 'GET',
                success: function(data) {
                    let body = "";
                    data.data.forEach(obj => {
                        body += 
                        `<tr>
                            <td>${obj.index_data}</td>
                            <td>${obj.material_code}</td>
                            <td>${obj.material_name}</td>
                            <td>${obj.spec_code}</td>
                            <td>${obj.item_type}</td>
                            <td>${obj.process_type}</td>
                            <td>${obj.sku_procurement_type}</td>
                            <td>${obj.sku_inventory_unit}</td>
                            <td>${obj.qty}</td>
                            <td>${obj.qty_each_unit}</td>
                            <td>${obj.currency}</td>
                            <td>${obj.material}</td>
                            <td>${obj.price}</td>
                            <td>${obj.price}</td>
                            <td>${obj.process}</td>
                        </tr>`
                    });
                    const total = data.data.reduce((accumulator, value) => {
                                return accumulator + Number(value.total_f);
                                }, 0);
                    body += 
                        `<tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>${total}</th>
                            <th>${total}</th>
                            <th>${total}</th>
                        </tr>`

                    var detailHtml = `
                        <div class="p-3 bg-light">
                            <table class="table table-sm">
                                <tr style="text-align:center">
                                    <th colspan="10" >Production Material Information</th>
                                    <th colspan="5">Cost</th>
                                </tr>
                                <tr>
                                    <th>Index</th>
                                    <th>Material Code</th>
                                    <th>Material Name</th>
                                    <th>Spesification Code</th>
                                    <th>Item Type</th>
                                    <th>Process Type</th>
                                    <th>Proc. Type</th>
                                    <th>Unit</th>
                                    <th>Qty/Unit</th>
                                    <th>Qty</th>
                                    <th>Curr</th>
                                    <th>Material</th>
                                    <th>Price</th>
                                    <th>Sub Process</th>
                                    <th>Process</th>
                                </tr>
                                `+
                                    body
                                +`
                            </table>
                        </div>
                    `;
                    row.child(detailHtml).show();
                    tr.addClass('shown');
                }
            });
        }
    });


});