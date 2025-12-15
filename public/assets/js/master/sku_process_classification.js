document.addEventListener("DOMContentLoaded", async () => {
    const addButtonEl = document.querySelector("#add_button");
    // const addModalEl = document.querySelector("#add_modal");
    const addModalEl = $("#add_modal");

    addButtonEl.addEventListener("click", () => {
        console.log("prev modal");
        addModalEl.modal("show");
        // addModalEl.classList.add("show");
        console.log("after modal");
    });

    const selectInputProcessTypeEl = $(
        "#add_modal [name='mst_sku_process_type_id']"
    );
    console.log("selectInputProcessTypeEl", selectInputProcessTypeEl);

    // $("#add_modal").on("click", () => {
    //     $("")
    // })

    // select input
    let processType = [];

    (async () => {
        try {
            const fetched = await fetchedJson("/api/sku-process-type/names");
            processType = fetched?.data;

            console.log("fetched in processType", fetched);
            console.log("processType:", JSON.stringify(processType, 0, 4));
            populateSelectV2(processType, selectInputProcessTypeEl);
        } catch (e) {
            console.error(e);
        }
    })();

    // if (processType.length) {
    //     populateSelect(processType, selectInputProcessTypeEl);
    // } else console.warn("processType is empty!!!");

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
            url: "/api/sku-process-classification",
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

            { data: "code" },
            // { data: "category" },
            {
                data: "process_type.name",
                defaultContent: "-",
            },
            { data: "name" },

            // Item type (nested object)
            // {
            //     data: "item_type.description",
            //     defaultContent: "-",
            // },
            // {
            //     data: "item_type.prefix",
            //     defaultContent: "-",
            //     className: "text-center",
            // },

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
});

const fetchedJson = async (uri, args) => {
    try {
        const fetched = await fetch(uri, args);

        const text = await fetched.text();

        let json;

        try {
            json = JSON.parse(text);
        } catch (e) {
            throw new Error(
                `request fetch '${uri}' was failed cuz the response is not valid json. response: ${text}`
            );
        }

        return json;
    } catch (e) {
        console.error(`Error while fetching, error: ${e}`);
    }
};

/**
 * fill select input option element.
 * note: element should be using jQuery :D
 */
const populateSelectV2 = (master_data, element) => {
    element.empty();
    element.append('<option value=""> -- Select -- </option>');
    master_data.forEach((data) => {
        element.append(
            `<option value="${data.id}">${
                data.description || data.name
            }</option>`
        );
    });
};
