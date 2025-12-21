$("#table-data").DataTable({
        scrollCollapse: true,
        scrollX: true,
        // scrollY: '50vh',
        processing: true,
        serverSide: true,
        ajax: {
            url: base_url + "customer/all",
            type: "GET"
        },
        columns: [
            {
                data: "prefix",
            },
            {
                data: "name",
            },
            {
                data: "initials",
            },
            {
                data: "office_address",
            },
            {
                data: "phone_number",
            },
            {
                data: "fax_number",
            },
            {
                data: "email",
            },
            {
                data: "npwp",
            },
            {
                data: "contact_person_name",
            },
            {
                data: "contact_person_phone",
            },
            {
                data: "contact_person_email",
            },
            {
                data: null,
            },
        ],
        columnDefs: [
            {
                targets: 11,
                orderable: false,
                searchable: false,
                render:  function (data, type, row, meta) {
                      const csrfToken = document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content");
                    return (
                        `
                        <form action="/customer/` +
                        data.id +
                        `/delete" method="post" onsubmit="return confirm('Are you sure you want to delete it?')">
						<div class="d-flex">
							<input type="hidden" name="_token" value="${csrfToken}">
							<button data-id="` +
                        data.id +
                        `" type="button" class="edit btn btn-success me-1">
                            <span class="fas fa-pencil-alt"></span>
                            </button>
                            <button type="submit" class="btn btn-danger">
                            <span class="fas fa-trash"></span>
                            </button>
						</div>
						</form>
                    `
                    );
                }
            }
        ],
    });




$(document).on('click', '.edit', function (e) {
    var id = this.dataset.id;
    $.ajax({
        type: 'GET',
        url: base_url + 'customer/' + id,
        success: function (data) {
            var data = data.data;

            $('[name=id]').val(data.id);
            $('[name=prefix]').val(data.prefix);
            $('[name=name]').val(data.name);
            $('[name=initials]').val(data.initials);
            $('[name=office_address]').val(data.office_address);
            $('[name=npwp]').val(data.npwp);
            $('[name=phone_number]').val(data.phone_number);
            $('[name=fax_number]').val(data.fax_number);
            $('[name=phone_number]').val(data.phone_number);
            $('[name=email]').val(data.email);
            $('[name=contact_person_name]').val(data.contact_person_name);
            $('[name=contact_person_phone]').val(data.contact_person_phone);
            $('[name=contact_person_email]').val(data.contact_person_email);

            $('#edit_modal').modal('show');

        },
        error: function (err) {
            debugger;
        }
    });
});
