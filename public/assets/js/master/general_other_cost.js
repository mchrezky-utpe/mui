$(document).on('click', '.edit', function (e) {
    var id = this.dataset.id;
    $.ajax({
        type: 'GET',
        url: base_url + 'general-other-cost/' + id,
        success: function (data) {
            var data = data.data;

            $('[name=id]').val(data.id);
            $('[name=manual_id]').val(data.manual_id);
            $('[name=description]').val(data.description);

            $('#edit_modal').modal('show');

        },
        error: function (err) {
            debugger;
        }
    });
});
