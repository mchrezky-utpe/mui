$(document).ready(function () {


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
                $("[name=lead_time]").val(Number(data.lead_time).toFixed(0));
                $("[name=valid_date_from]").val(data.valid_date_from);
                $("[name=flag_status]").val(data.flag_status);
                $("[name=price]").val(Number(data.price).toFixed(0));
                $("[name=price_retail]").val(Number(data.price_retail).toFixed(0));
                $("[name=moq]").val(Number(data.moq).toFixed(0));
                $("[name=sku_id]").val(data.sku_id);
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


$(".btn_production_item").click(function () {
    initItemProductionMaterial();
});


function initItemProductionMaterial(){
    
    $('#table-item-production').DataTable().destroy();
    $('#table-item-production').empty();
    var table =    $('#table-item-production').DataTable({
		scrollCollapse: true,
		processing: true,
		serverSide: true,
        pageLength: 15,
		ajax: {
			url: base_url + 'api/sku-production-material',
			type: "GET",
			data: function(d) {
				d.start_date = $('input[name="start_date"]').val();
				d.end_date = $('input[name="end_date"]').val();
				d.customer = $('#customer').val();
			}
		},
		columns: [
			{
				data: "sku_id"
			},
			{
				data: "sku_name"
			},
			{
				data: "sku_specification_code"
			}
		]
	});
    
    $('#table-item-production tbody').on('click', 'tr', function() {
        var data = table.row(this).data();
        $('[name=sku_name]').val(data.sku_name);
        $('[name=sku_code]').val(data.sku_id);
        $('[name=sku_id]').val(data.id);
    });
}


    $(".btn_general_item").click(function () {
            
            
            $('#table-item-general').DataTable().destroy();
            $('#table-item-general').empty();
            var table =    $('#table-item-general').DataTable({
                scrollCollapse: true,
                processing: true,
                serverSide: true,
                pageLength: 15,
                ajax: {
                    url: base_url + 'api/sku-general-item',
                    type: "GET",
                    data: function(d) {
                        d.start_date = $('input[name="start_date"]').val();
                        d.end_date = $('input[name="end_date"]').val();
                        d.customer = $('#customer').val();
                    }
                },
                columns: [
                    {
                        data: "sku_id"
                    },
                    {
                        data: "sku_name"
                    },
                    {
                        data: "sku_specification_code"
                    }
                ]
            });
            
            $('#table-item-general tbody').on('click', 'tr', function() {
                var data = table.row(this).data();
                $('[name=sku_name]').val(data.sku_name);
                $('[name=sku_code]').val(data.sku_id);
                $('[name=sku_id]').val(data.id);
            });

            initItemGeneral();
        });


    function initItemGeneral(){
        fetchSkuGeneralMaster()
            .then((data) => {
                console.log("Succesfully get Sku:", data);
                populateSelectSku("Sku", data, $("[name=sku_id]"));
            })
            .catch((err) => {
                console.error("Error get Sku:", err);
                    });
    }

    initParam();
    
    function initParam() {

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
