$(document).on('click', '.edit', function (e) {
    var id = this.dataset.id;
    $.ajax({
        type: 'GET',
        url: base_url + 'general-tax/' + id,
        success: function (data) {
            var data = data.data;

            $('[name=id]').val(data.id);
            $('[name=manual_id]').val(data.manual_id);
            $('[name=description]').val(data.description);
            $('[name=value]').val(data.value);

            $('#edit_modal').modal('show');

        },
        error: function (err) {
            debugger;
        }
    });
});
