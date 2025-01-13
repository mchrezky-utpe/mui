$(document).on('click', '.edit', function (e) {
    var id = this.dataset.id;
    $.ajax({
        type: 'GET',
        url: base_url + 'user/' + id,
        success: function (data) {
            var data = data.data;

            $('[name=id]').val(data.id);
            $('[name=username]').val(data.username);
            $('[name=name]').val(data.name);
            // $('[name=password]').val(data.password);


            $('#edit_modal').modal('show');

        },
        error: function (err) {
            debugger;
        }
    });
});
