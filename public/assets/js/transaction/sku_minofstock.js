$(document).on('click', '.edit', function (e) {
    var id = this.dataset.id;
    $.ajax({
        type: 'GET',
        url: base_url + 'sku-minofstock/' + id,
        success: function (data) {
            var data = data.data;

            $('[name=id]').val(data.id);
            $('[name=manual_id]').val(data.manual_id);
            $('[name=sku_id]').val(data.sku_id);
            $('[name=qty]').val(data.qty);

            $('#edit_modal').modal('show');

        },
        error: function (err) {
            debugger;
        }
    });
});
