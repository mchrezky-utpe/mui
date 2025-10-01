
$(document).on('click', '.edit', function (e) {
    var id = this.dataset.id;
    $.ajax({
        type: 'GET',
        url: base_url + 'person-supplier/' + id,
        success: function (data) {
            var data = data.data;

            $('[name=id]').val(data.id);
            $('[name=manual_id]').val(data.manual_id);
            $('[name=prefix]').val(data.prefix);
            $('[name=address_01]').val(data.address_01);
            $('[name=description]').val(data.description);
            $('[name=contact_person_01]').val(data.contact_person_01);
            $('[name=contact_person_02]').val(data.contact_person_02);
            $('[name=contact_person_03').val(data.contact_person_03);
            $('[name=phone_01]').val(data.phone_01);
            $('[name=fax_01]').val(data.fax_01);
            $('[name=email_02]').val(data.email_02);
            $('[name=email_03]').val(data.email_03);
            $('[name=contact_person_01]').val(data.contact_person_01);

            $('#edit_modal').modal('show');

        },
        error: function (err) {
            debugger;
        }
    });
});
