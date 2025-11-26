$("#table-data").DataTable({
        scrollCollapse: true,
        scrollX: true,
        // scrollY: '50vh',
        processing: true,
        serverSide: true,
        ajax: {
            url: base_url + "packaging-information-partition/all",
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
                data: "size",
            },
            {
                data: "capacity",
            },
            {
                data: null,
            },
        ],
        columnDefs: [
            {
                targets: 6,
                orderable: false,
                searchable: false,
                render:  function (data, type, row, meta) {
                      const csrfToken = document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content");
                    return (
                        `
                        <form action="/packaging-information-partition/` +
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


$(document).on("click", ".edit", function (e) {
    var id = this.dataset.id;
    $.ajax({
        type: "GET",
        url: base_url + "packaging-information-partition/" + id,
        success: function (data) {
            var data = data.data;

            $("[name=id]").val(data.id);
            $("[name=description]").val(data.description);
            $("[name=type_id]").val(data.type_id);
            $("[name=size]").val(data.size);
            $("[name=capacity]").val(data.capacity);
          
             $("#edit_modal").modal("show");
        
        },
        error: function (err) {
            debugger;
        },
    });
});

    // LOAD MASTER 
    fetchSkuType()
    .then((data) => {
        console.log("Succesfully fetchSkuType:", data);
        populateSelect('Category Type',data, $("[name=type_id]"));
    })
    .catch((err) => {
        console.error("Error fetchSkuType:", err);
    });

    
function fetchSkuType() {
    return new Promise((resolve, reject) => {
        $.ajax({
            type: "GET",
            url: base_url + "api/sku-type/droplist",
            success: function (data) {
                resolve(data.data);
            },
            error: function (err) {
                console.error("Error fetchSkuType:", err);
                reject(err);
            },
        });
    });
}