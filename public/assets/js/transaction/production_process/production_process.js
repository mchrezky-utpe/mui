$(document).on("click", ".edit", function (e) {
    var id = this.dataset.id;
    $.ajax({
        type: "GET",
        url: base_url + "production_process/" + id,
        success: function (data) {
            var data = data.data;

            $("[name=id]").val(data.id);
            $("[name=description]").val(data.description);
            $("[name=flag_process_classification]").val(
                data.flag_process_classification
            );
            $("[name=flag_checking_input_method]").val(
                data.flag_checking_input_method
            );
            $("[name=flag_item_size_category]").val(
                data.flag_item_size_category
            );
            $("[name=line_part_code]").val(data.line_part_code);
            $("[name=val_area]").val(data.val_area);
            $("[name=val_weight]").val(data.val_weight);
            $("[name=qty_standard]").val(data.qty_standard);
            $("[name=qty_target]").val(data.qty_target);

            $("#edit_modal").modal("show");
        },
        error: function (err) {
            debugger;
        },
    });
});
