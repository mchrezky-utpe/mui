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
        fetchSkuMaster()
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
