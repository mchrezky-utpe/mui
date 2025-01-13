$(document).on('click', '.edit', function (e) {
    var id = this.dataset.id;
    $.ajax({
        type: 'GET',
        url: base_url + 'sku/' + id,
        success: function (data) {
            var data = data.data;

            $('[name=id]').val(data.id);
            $('[name=manual_id]').val(data.manual_id);
            $('[name=description]').val(data.description);
            $('[name=type_id]').val(data.sku_type_id).prop('selected', true);
            $('[name=model_id]').val(data.sku_model_id).prop('selected', true);
            $('[name=process_id]').val(data.sku_process_id).prop('selected', true);
            $('[name=business_type_id]').val(data.sku_business_type_id).prop('selected', true);
            $('[name=packaging_id]').val(data.sku_packaging_id).prop('selected', true);
            $('[name=detail_id]').val(data.sku_detail_id).prop('selected', true);
            $('[name=unit_id]').val(data.sku_unit_id).prop('selected', true);

            $('#edit_modal').modal('show');

        },
        error: function (err) {
            debugger;
        }
    });
});
