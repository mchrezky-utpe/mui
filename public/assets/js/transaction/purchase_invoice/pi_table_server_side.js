import { setGlobalVariable } from "./pi_global_variable.js";

export function handleTableServerSide() {
    const table_pi = $("#table-pi").DataTable({
     
        scrollX: true,
        scrollY: "400px",
        processing: true,
        serverSide: true,
        // fixedColumns: {
        //     right: 1,
        //     heightMatch: 'auto'
        // },
        processing: true,
        serverSide: true,
        ajax: {
            url: base_url + "pi/all",
            type: "GET",
            data: function (d) {
                d.start_date = $('input[name="start_date"]').val();
                d.end_date = $('input[name="end_date"]').val();
                d.flag_status = $("#status").val();
            },
        },
        columns: [
            {
                data: null,
            },
            {
                data: "doc_num",
            },
            {
                data: "manual_id",
            },
            {
                data: "trans_date",
            },
            {
                data: "department",
            },
            {
                data: "supplier",
            },
            {
                data: "terms",
            },
            {
                data: "currency",
            },
            {
                data: "val_discount",
            },
            {
                data: "val_vat",
            },
            {
                data: "val_pph23",
            },
            {
                data: "val_total",
            },
        ],
        columnDefs: [
            {
                targets: 0,
                orderable: false,
                searchable: false,
                render: function (data, type, row, meta) {
                    const csrfToken = document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content");

                    let button = `
                        <div class="btn-group" role="group">
                        <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Action
                        </button>

                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                            <button data-id="${data.id}" type="button"class="checkAndVerify dropdown-item">
							   Item Check and Verification
                            </button>

                            <button data-id="${data.id}" type="button" class="adjustment dropdown-item">
							   Adjustment
                            </button>

                            <button data-id="${data.id}" type="button" class="receipt dropdown-item">
							   Receipt
                            </button>

                            <button data-id="${data.id}" type="button" class="rollback dropdown-item">
							   Rollback
                            </button>

                            <form action="/pi/${data.id}/delete" method="post"> 
							    <input type="hidden" name="_token" value="${csrfToken}">
                              <button class="dropdown-item">Delete</button>
                            </form>

                            <a href="/pi/${data.id}/export" class=dropdown-item">
							   Export to Spreedsheet
                            </a>

                        </div>
                      </div> `
                    return button;
                },
            },
        ],
    });
    setGlobalVariable("table_pi", table_pi);
}
