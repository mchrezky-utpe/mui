$(document).on('click', '.edit', function (e) {
    var id = this.dataset.id;
    $.ajax({
        type: 'GET',
        url: base_url + 'sku-pricelist/' + id,
        success: function (data) {
            var data = data.data;

            $('[name=id]').val(data.id);
            $('[name=manual_id]').val(data.manual_id);
            $('[name=sku_id]').val(data.sku_id);
            $('[name=price]').val(data.price);
            $('[name=gen_currency_id]').val(data.gen_currency_id);
            $('[name=prs_supplier_id]').val(data.prs_supplier_id);

            $('#edit_modal').modal('show');

        },
        error: function (err) {
            debugger;
        }
    });
});
