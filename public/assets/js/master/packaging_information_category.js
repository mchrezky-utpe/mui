$("#table-data").DataTable({
        scrollCollapse: true,
        scrollX: true,
        // scrollY: '50vh',
        processing: true,
        serverSide: true,
        ajax: {
            url: base_url + "packaging-information-category/all",
            type: "GET"
        },
        columns: [
            {
                data: "prefix",
            },
            {
                data: "sub_category",
            },
            {
                data: "type",
            },
            {
                data: "description",
            },
            {
                data: "model",
            },
            {
                data: "category_size",
            },
            {
                data: "unit",
            },
            {
                data: "total_stock",
            },
            {
                data: null,
            },
        ],
        columnDefs: [
            {
                targets: 8,
                orderable: false,
                searchable: false,
                render:  function (data, type, row, meta) {
                      const csrfToken = document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content");
                    return (
                        `
                        <form action="/packaging-information-category/` +
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