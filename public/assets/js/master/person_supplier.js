$(document).on('click', '.edit', function (e) {
    var id = this.dataset.id;
    $.ajax({
        type: 'GET',
        url: base_url + 'person-supplier/' + id,
        success: function (data) {
            var data = data.data;

            $('[name=id]').val(data.id);
            $('[name=manual_id]').val(data.manual_id);
            $('[name=description]').val(data.description);
            $('[name=contact_person_01]').val(data.contact_person_01);
            $('[name=contact_person_02]').val(data.contact_person_02);
            $('[name=phone_01]').val(data.phone_01);
            $('[name=fax_01]').val(data.fax);
            $('[name=email_02]').val(data.email_02);
            $('[name=contact_person_01]').val(data.contact_person_02);

            $('#edit_modal').modal('show');

        },
        error: function (err) {
            debugger;
        }
    });
});
