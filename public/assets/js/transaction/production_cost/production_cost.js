$(document).on("click", ".edit", function (e) {
    var id = this.dataset.id;
    $.ajax({
        type: "GET",
        url: base_url + "production_cost/" + id,
        success: function (data) {
            var data = data.data;

            $("[name=id]").val(data.id);
            $("[name=sku_name]").val(data.sku_name);
            $("[name=sku_model]").val(data.sku_model);

            $("#edit_modal").modal("show");
        },
        error: function (err) {
            debugger;
        },
    });
});
