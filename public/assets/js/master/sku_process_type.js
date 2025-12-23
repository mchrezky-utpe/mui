document.addEventListener("DOMContentLoaded", async () => {
    const route = "sku-process-type";

    const addButtonEl = document.querySelector("#add_button");
    // const addModalEl = document.querySelector("#add_modal");
    const addModalEl = $("#add_modal");

    addButtonEl.addEventListener("click", () => {
        // console.log("prev modal");
        addModalEl.modal("show");
        // addModalEl.classList.add("show");
        // console.log("after modal");
    });

    const selectInputItemTypeEl = $("#add_modal [name='mst_sku_type_id']");
    const selectInputItemTypeEl2 = $("#edit_modal [name='mst_sku_type_id']");

    const formRemoveEl = document.querySelector("#form-remove");
    // console.log("selectInputItemTypeEl", selectInputItemTypeEl);

    // $("#add_modal").on("click", () => {
    //     $("")
    // })

    // select input
    let itemType = [];

    // (async () => {
    try {
        const fetched = await fetchedJson("/api/sku-type/name-n-extension");
        itemType = fetched?.data;

        // console.log("fetched in itemType", fetched);
        // console.log("itemType:", JSON.stringify(itemType, 0, 4));
        populateSelectV2(itemType, selectInputItemTypeEl);
        populateSelectV2(itemType, selectInputItemTypeEl2);
    } catch (e) {
        console.error(e);
    }
    // })();

    // if (itemType.length) {
    //     populateSelect(itemType, selectInputItemTypeEl);
    // } else console.warn("itemType is empty!!!");

    const table = new DataTable(".data-table-item", {
        scrollX: true,
        scrollY: "400px",
        scrollCollapse: true,
        fixedColumns: {
            left: 1,
            right: 1,
            heightMatch: "auto",
        },
        paging: true,
        pageLength: 10,
        responsive: false,
        columnDefs: [
            {
                targets: [0],
                className: "dtfc-fixed-left",
                orderable: false,
                searchable: false,
            },
            {
                targets: -1,
                className: "dtfc-fixed-right bg-light",
                orderable: false,
                searchable: false,
                width: "120px",
            },
            {
                targets: "_all",
                className: "text-nowrap bordered-cell",
            },
        ],
        processing: true,
        serverSide: true,
        ajax: {
            url: `/api/${route}`,
            type: "GET",
            dataSrc: "data", // PENTING!
        },

        columns: [
            // Index number
            {
                data: null,
                render: (data, type, row, meta) =>
                    meta.row + meta.settings._iDisplayStart + 1,
                className: "text-center",
                width: "50px",
            },

            { data: "prefix", defaultContent: "-" },
            { data: "manual_id", defaultContent: "-" },
            { data: "category" },
            { data: "description", defaultContent: "-" },

            // Item type (nested object)
            {
                data: "item_type.description",
                defaultContent: "-",
            },
            {
                data: "item_type.prefix",
                defaultContent: "-",
                className: "text-center",
            },

            // Action
            {
                data: "id",
                orderable: false,
                searchable: false,
                className: "dtfc-fixed-right text-center",
                width: "120px",
                render: (id) => `
                    <div class="d-flex gap-1 justify-content-center">
                        <button data-id="${id}" type="button" class="edit btn btn-success btn-sm">
                            <i class="fas fa-pencil-alt"></i>
                        </button>
                        <button data-id="${id}" type="button" class="remove btn btn-danger btn-sm">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                `,
                _render: (id) => `
                    <div class="d-flex gap-1 justify-content-center">
                        <button @onclick="" data-id="${id}" type="button" class="edit btn btn-success btn-sm">
                            <i class="fas fa-pencil-alt"></i>
                        </button>

                        <form action="/sku-part-information/${id}/delete" method="post">
                            <input type="hidden" name="_token" value="${
                                document.querySelector("input[name=_token]")
                                    .value
                            }">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
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

            console.log("mainDataList:", mainDataList);
        }
    });

    const delegationEdit = (e) => {
        const editButtonEl = e?.target.closest(".edit");

        if (!editButtonEl) return;

        const id = editButtonEl?.dataset?.id;
        const data = mainDatas?.[id];

        if (!data || typeof data != "object")
            return console.log(
                `${id} not in ${Object.keys(mainDatas).join(",")}`
            );

        // fill edit
        // $("#edit_modal form").action = `${route}/${id}`;
        $("#edit_modal [name='id']").val(data.id);
        $("#edit_modal [name='manual_id']").val(data.manual_id);
        $("#edit_modal [name='category']").val(data.category);
        $("#edit_modal [name='description']").val(data.description);
        $("#edit_modal [name='prefix']").val(data.prefix);
        $("#edit_modal [name='mst_sku_type_id']").val(data.mst_sku_type_id);
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
    // table.on("click", delegations);
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
