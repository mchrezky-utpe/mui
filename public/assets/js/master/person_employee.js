$(document).on("click", ".edit", function (e) {
    var id = this.dataset.id;
    $.ajax({
        type: "GET",
        url: base_url + "person-employee/" + id,
        success: function (data) {
            var data = data.data;

            $("[name=id]").val(data.id);
            $("[name=firstname]").val(data.firstname);
            $("[name=middlename]").val(data.middlename);
            $("[name=lastname]").val(data.lastname);
            $("[name=fullname]").val(data.fullname);
            $("[name=flag_gender]").val(data.flag_gender);

            $("#edit_modal").modal("show");
        },
        error: function (err) {
            debugger;
        },
    });
});
