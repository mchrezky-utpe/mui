$(document).ready(function () {

    // handling pagination data
    
	const table_pricelist = $('#table-pagination').DataTable({
		fixedColumns: {
			start: 0,
			end: 5
		},
		scrollCollapse: true,
		scrollX: true,
		scrollY: 300,

		processing: true,
		serverSide: true,
		ajax: {
			url: base_url + 'sku-pricelist/api/all/pagination',
			type: "GET",
			data: function(d) {
				d.start_date = $('input[name="start_date"]').val();
				d.end_date = $('input[name="end_date"]').val();
				d.customer = $('#customer').val();
			}
		},
		columns: [{
				data: null
			}, 
			{
				data: "sku_id"
			},
			{
				data: "sku_name"
			},
			{
				data: "sku_type"
			},
			{
				data: "sku_procurement_unit"
			},
			{
				data: "currency"
			}, 
            {
				data: "price"
			},
			{
				data: "price_retail"
			},
			{
				data: "pricelist_status"
			},
			{
				data: "valid_date_from"
			},
			{
				data: "valid_date_to"
			},
			{
				data: "valid_date_status"
			},
			{
				data: null
			},
		],
		columnDefs: [
			{
				targets: 0,
				orderable: false,
				searchable: false,
				render: function(data, type, row, meta) {
					return meta.row + 1;
				}
			},
			{
				targets: 12,
				orderable: false,
				searchable: false,
				render: function(data, type, row, meta) {
					const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
					return `

                    <form action="/sku-pricelist/` + data.id + `/delete" method="post"> 
					<input type="hidden" name="_token" value="${csrfToken}">
                      <div class="d-flex">
                        <button data-prs_supplier_id="${data.prs_supplier_id}"  data-item_id="{{ $value->item_id }}"  type="button" class="history btn btn-secondary">
                          <span class="fas fa-list"></span>
                      </button>
                        <button data-id="${data.id}" type="button" class="edit btn btn-success">
                          <span class="fas fa-pencil-alt"></span>
                        </button>
                        <button class="btn btn-danger">
                          <span class="fas fa-trash"></span>
                        </button>
                      </form>
                    `;
				}
			}
		]
	});
    // end of hanlding pagination data


    $(document).on("click", ".edit", function (e) {
        var id = this.dataset.id;
        $.ajax({
            type: "GET",
            url: base_url + "sku-pricelist/" + id,
            success: function (data) {
                var data = data.data;
                $("[name=id]").val(data.id);
                $("[name=sku_production_material_id]").val(data.sku_id);
                $("[name=prs_supplier_id]").val(data.prs_supplier_id);
                $("[name=gen_currency_id]").val(data.gen_currency_id);
                $("[name=lead_time]").val(data.lead_time);
                $("[name=valid_date_from]").val(data.valid_date_from);
                $("[name=flag_status]").val(data.flag_status);
                $("[name=price]").val(data.price);
                $("[name=price_retail]").val(data.price_retail);
                $("[name=sku_id]").change();
                $("#edit_modal").modal("show");
            },
            error: function (err) {
                debugger;
            },
        });
    });

    $(document).on("change", "[name=sku_id]", function (e) {
        var selectedOption = $("[name=sku_id] option:selected");
        $("[name=material_code]").val(selectedOption.attr("sku_id"));
        $("[name=procurement_unit]").val(selectedOption.attr("unit"));
    });

    // =========== HANDLING PARAM

    function populateSelectSku(title, master_data, element) {
        element.empty();
        element.append('<option value="">-- Select ' + title + " --</option>");
        master_data.forEach((data) => {
            element.append(
                `<option sku_id="${data.sku_id}" unit="${data.sku_procurement_unit}" value="${data.id}">${data.sku_name}</option>`
            );
        });
    }

    initParam();
    
    function initParam() {

        fetchSkuProductionMaster()
            .then((data) => {
                console.log("Succesfully get Sku:", data);
                populateSelectSku("Sku", data, $("[name=sku_id]"));
            })
            .catch((err) => {
                console.error("Error get Sku:", err);
            });

        fetchSkuGeneralMaster()
            .then((data) => {
                console.log("Succesfully get Sku:", data);
                populateSelectSku("Sku", data, $("[name=sku_id]"));
            })
            .catch((err) => {
                console.error("Error get Sku:", err);
            });

        fetchCurrency()
            .then((data) => {
                console.log("Succesfully get currency:", data);
                populateSelect("Currency", data, $("[name=gen_currency_id]"));
                $("[name=gen_currency_id]").val(65).change();
            })
            .catch((err) => {
                console.error("Error get currency:", err);
            });

        fetchSupplier()
            .then((data) => {
                console.log("Succesfully get supplier:", data);
                populateSelect("Supplier", data, $("[name=prs_supplier_id]"));
            })
            .catch((err) => {
                console.error("Error get supplier:", err);
            });
    }

    function fetchSkuProductionMaster() {
        return new Promise((resolve, reject) => {
            $.ajax({
                type: "GET",
                url: base_url + "api/sku-production-material",
                success: function (data) {
                    resolve(data.data);
                },
                error: function (err) {
                    console.error("Error fetching master:", err);
                    reject(err);
                },
            });
        });
    }

    function fetchSkuGeneralMaster() {
        return new Promise((resolve, reject) => {
            $.ajax({
                type: "GET",
                url: base_url + "api/sku-general-item",
                success: function (data) {
                    resolve(data.data);
                },
                error: function (err) {
                    console.error("Error fetching master:", err);
                    reject(err);
                },
            });
        });
    }

    function fetchCurrency() {
        return new Promise((resolve, reject) => {
            $.ajax({
                type: "GET",
                url: base_url + "api/general-currency",
                success: function (data) {
                    resolve(data.data);
                },
                error: function (err) {
                    console.error("Error fetching:", err);
                    reject(err);
                },
            });
        });
    }

    function fetchSupplier() {
        return new Promise((resolve, reject) => {
            $.ajax({
                type: "GET",
                url: base_url + "api/person-supplier",
                success: function (data) {
                    resolve(data.data);
                },
                error: function (err) {
                    console.error("Error fetching:", err);
                    reject(err);
                },
            });
        });
    }

    function populateSelect(title, master_data, element) {
        element.empty();
        element.append('<option value="">-- Select ' + title + " --</option>");
        master_data.forEach((data) => {
            element.append(
                `<option value="${data.id}">${data.description}</option>`
            );
        });
    }
});

let detailRowCount = 0;
$(document).on("click", ".history", function (e) {
    var prs_supplier_id = this.dataset.prs_supplier_id;
    var item_id = this.dataset.item_id;
    $.ajax({
        type: "GET",
        url:
            base_url +
            "sku-pricelist/api/history?prs_supplier_id=" +
            prs_supplier_id +
            "&item_id=" +
            item_id,
        success: function (data) {
            var data = data.data;
            $("#history_table tbody").empty();
            detailRowCount = 0;
            for (let index = 0; index < data.length; index++) {
                detailRowCount++;
                const newRow = `
                    <tr>
                        <td>${detailRowCount}</td>
                        <td>${data[index].sku_id}</td>
                        <td>${data[index].sku_name}</td>
                        <td>${data[index].sku_type}</td>
                        <td>${data[index].sku_procurement_unit}</td>
                        <td>${data[index].currency}</td>
                        <td>${data[index].price}</td>
                        <td>${data[index].price_retail}</td>
                        <td>${data[index].pricelist_status}</td>
                        <td>${data[index].valid_date_from}</td>
                        <td>${data[index].valid_date_to}</td>
                    </tr>
                `;

                $("#history_table tbody").append(newRow);
            }

            $("#history_modal").modal("show");
        },
        error: function (err) {
            debugger;
        },
    });
});
