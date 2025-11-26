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



    
$(document).on("click", ".edit", function (e) {
    var id = this.dataset.id;
    $.ajax({
        type: "GET",
        url: base_url + "packaging-information-category/" + id,
        success: function (data) {
            var data = data.data;

            $("[name=id]").val(data.id);
            $("[name=description]").val(data.description);
            $("[name=type_id]").val(data.type_id);
            $("[name=model_id]").val(data.model_id);
            $("[name=unit_id]").val(data.unit_id);
            $("[name=category_size]").val(data.category_size);
            $("[name=total_stock]").val(data.total_stock);
          
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

fetchSkuModel()
    .then((data) => {
        console.log("Succesfully fetchSkuModel:", data);
        populateSelect('Category Moddel',data, $("[name=model_id]"));
    })
    .catch((err) => {
        console.error("Error fetchSkuModel:", err);
    });



fetchSkuUnit()
    .then((data) => {
        console.log("Succesfully fetchSkuUnit:", data);
        populateSelect('Category Unit',data, $("[name=unit_id]"));
    })
    .catch((err) => {
        console.error("Error fetchSkuUnit:", err);
    });

function fetchSkuModel() {
    return new Promise((resolve, reject) => {
        $.ajax({
            type: "GET",
            url: base_url + "api/sku-model/droplist",
            success: function (data) {
                resolve(data.data);
            },
            error: function (err) {
                console.error("Error fetchSkuModel:", err);
                reject(err);
            },
        });
    });
}
    
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


function fetchSkuUnit() {
    return new Promise((resolve, reject) => {
        $.ajax({
            type: "GET",
            url: base_url + "api/sku-unit/droplist",
            success: function (data) {
                resolve(data.data);
            },
            error: function (err) {
                console.error("Error fetchSkuUnit:", err);
                reject(err);
            },
        });
    });
}