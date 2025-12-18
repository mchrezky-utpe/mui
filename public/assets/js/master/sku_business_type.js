document.addEventListener("DOMContentLoaded", async () => {
    const route = "sku-business-type";

    const addButtonEl = document.querySelector("#add_button");
    const addModalEl = $("#add_modal");

    addButtonEl.addEventListener("click", () => {
        addModalEl.modal("show");
    });

    const formRemoveEl = document.querySelector("#form-remove");
    const formEditEl = document.querySelector("#edit_modal form");

    const table = new DataTable(".data-table-item", {
        scrollX: true,
        scrollY: "400px",
        scrollCollapse: true,

        paging: true,
        pageLength: 10,
        responsive: false,

        processing: true,
        serverSide: true,

        ajax: {
            url: `/api/${route}`,
            type: "GET",
            dataSrc: "data",
        },

        columns: [
            {
                data: null,
                orderable: false,
                searchable: false,
                className: "text-center",
                width: "50px",
                render: (data, type, row, meta) =>
                    meta.row + meta.settings._iDisplayStart + 1,
            },
            { data: "prefix", defaultContent: "-" },
            { data: "category", defaultContent: "-" },
            { data: "description" },
            {
                data: "id",
                orderable: false,
                searchable: false,
                className: "text-center",
                width: "120px",
                render: (id) => `
                    <div class="d-flex gap-1 justify-content-center">
                        <button
                            type="button"
                            class="edit btn btn-success btn-sm"
                            data-id="${id}"
                        >
                            <i class="fas fa-pencil-alt"></i>
                        </button>

                        <button
                            type="button"
                            class="remove btn btn-danger btn-sm"
                            data-id="${id}"
                        >
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                `,
            },
        ],
    });

    let mainDataList = [];
    let mainDatas = {};

    // ambil response AJAX DataTables
    table.on("xhr.dt", function (e, settings, json) {
        mainDataList = json.data;

        if (Array.isArray(mainDataList)) {
            mainDatas = mainDataList.reduce((acc, curr) => {
                acc[curr.id] = curr;
                return acc;
            }, {});
        }
    });

    const delegationEdit = (e) => {
        const editButtonEl = e?.target.closest(".edit");

        if (!editButtonEl) return;

        e.preventDefault();

        const id = editButtonEl?.dataset?.id;
        const data = mainDatas?.[id];

        if (!data || typeof data != "object")
            return console.log(
                `${id} not in ${Object.keys(mainDatas).join(",")}`
            );

        // fill edit
        const action = `${route}/${id}`;
        formEditEl.action = action;
        // console.warn("action", action);
        // $("#edit_modal form").action = action;
        console.warn("formEditEl.action", formEditEl.action);
        // console.warn("form Action", $("#edit_modal form").action);
        $("#edit_modal [name='manual_id']").val(data.code);
        $("#edit_modal [name='prefix']").val(data.prefix);
        $("#edit_modal [name='category']").val(data.category);
        $("#edit_modal [name='description']").val(data.description);
        $("#edit_modal").modal("show");
    };

    const delegationRemove = async (e) => {
        const removeButton = e?.target.closest(".remove");
        if (!removeButton) return;

        e?.target.preventDefault?.();
        const id = removeButton.dataset.id;
        const data = mainDatas[id];

        if (!data) return console.warn("data does not exists!");

        const { isConfirmed } = await Swal.fire({
            title: "Yakin ingin hapus Data?",
            text: "Data yang dihapus tidak bisa di kembalikan!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#62c700",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, saya yakin!",
            cancelButtonText: "Batal",
        });

        if (!isConfirmed) return;

        formRemoveEl.action = `${route}/${id}/delete`;
        formRemoveEl.submit();
    };

    const deletagions = (e) => {
        delegationEdit(e);
        delegationRemove(e);
    };

    document.addEventListener("click", deletagions);
    // table.on("click", deletagions);
});

const fetchedJson = async (uri, args) => {
    try {
        const fetched = await fetch(uri, args);

        const text = await fetched.text();

        // let json;

        try {
            return JSON.parse(text);
        } catch (e) {
            throw new Error(
                `request fetch '${uri}' was failed cuz the response is not valid json. response: ${text}`
            );
        }

        // return json;
    } catch (e) {
        console.error(`Error while fetching json, error: ${e}`);
    }
};

/**
 * fill select input option element.
 * note: element should be using jQuery :D
 */
const populateSelectV2 = (
    master_data,
    element,
    columnValueName,
    columnTextName
) => {
    columnValueName ||= "id";
    columnTextName ||= "description";

    if (!master_data) throw new Error("invalid master data!!!");
    if (!element) throw new Error("element not found!!!");

    element.empty();
    element.append('<option value=""> -- Select -- </option>');
    master_data.forEach((data) => {
        element.append(
            `<option value="${data[columnValueName || ""]}">${
                data[columnTextName] || ""
            }</option>`
        );
    });
};

// $(document).on("click", ".edit", function (e) {
//     var id = this.dataset.id;
//     $.ajax({
//         type: "GET",
//         url: base_url + "sku-business/" + id,
//         success: function (data) {
//             var data = data.data;

//             $("[name=id]").val(data.id);
//             $("[name=manual_id]").val(data.manual_id);
//             $("[name=description]").val(data.description);

//             $("#edit_modal").modal("show");
//         },
//         error: function (err) {
//             debugger;
//         },
//     });
// });
