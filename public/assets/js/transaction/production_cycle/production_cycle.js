$(document).on("click", ".edit", function (e) {
    var id = this.dataset.id;
    $.ajax({
        type: "GET",
        url: base_url + "production_cycle/" + id,
        success: function (data) {
            var data = data.data;

            $("[name=id]").val(data.id);
            $("[name=description]").val(data.description);
            $("[name=num_jigging]").val(data.num_jigging);
            $("[name=num_lineprocess]").val(data.num_lineprocess);
            $("[name=num_unjigging]").val(data.num_unjigging);
            $("[name=num_inspection]").val(data.num_inspection);
            $("[name=num_assembly]").val(data.num_assembly);
            $("[name=num_cutting]").val(data.num_cutting);
            $("[name=num_masking]").val(data.num_masking);
            $("[name=num_buffing]").val(data.num_buffing);

            $("#edit_modal").modal("show");
        },
        error: function (err) {
            debugger;
        },
    });
});
