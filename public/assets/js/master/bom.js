$(document).ready(function () {

    // =========== GET DATA PAGEABLE
    $("#table-bom").DataTable({
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
                data: "sku_id",
            },
            {
                data: "remark",
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
                render: function (data, type, row, meta) {
                    return meta.row + 1;
                },
            },
            {
                targets: 3,
                orderable: false,
                searchable: false,
                render: function (data, type, row, meta) {
                    const csrfToken = document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content");
                    return (
                        `
                        <form action="/po/` +
                        data.id +
                        `/delete" method="post" onsubmit="return confirm('Are you sure you want to delete it?')">
						<div class="d-flex">
							<input type="hidden" name="_token" value="${csrfToken}">
							<a  target="/bom/edit"   href="bom/` + data.id +`/edit" class="btn btn-success">
							 <span class="fas fa-pencil-alt"></span>
                            </a>
							<a  target="/bom/edit"   href="bom/` + data.id +`/edit-detail" class="btn btn-success">
							 Edit Detail
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
});