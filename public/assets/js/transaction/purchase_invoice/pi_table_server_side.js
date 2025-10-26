import { setGlobalVariable } from "./pi_global_variable.js";

export function handleTableServerSide() {
    const table_pi = $("#table-pi").DataTable({
        scrollCollapse: true,
        scrollX: true,
        scrollY: '50vh',
        processing: true,
        serverSide: true,
        fixedColumns: {
            left: 6,
            heightMatch: 'auto'
        },
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
            {
                data: "receipt_date1",
            },
            {
                data: "recipent1",
            },
            {
                data: "receipt_status1",
            },
            {
                data: "receipt_date2",
            },
            {
                data: "recipent2",
            },
            {
                data: "receipt_status2",
            },
            {
                data: "receipt_date3",
            },
            {
                data: "recipent3",
            },
            {
                data: "receipt_status3",
            },
        ],
        columnDefs: [
            {
                targets: 0,
                orderable: false,
                searchable: false,
                render:  function (data, type, row, meta) {
                    return `<button class="btn btn-sm btn-info view-details" data-id="${data.id}" >Detail</button>'`;
                }
            },
            {
                targets: 1,
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

                            <button data-id="${data.id}" type="button" class="edit dropdown-item">
							   Adjustment
                            </button>

                            <div class="dropdown-submenu">
                                <button data-id="${data.id}" type="button" class="dropdown-item">
                                    Receipt
                                </button>
                                <div class="dropdown-menu custom-submenu">
                                    <a href="/pi/${data.id}/receipt/1" data-phase="1" class="btn dropdown-item submenu-item">
                                        Phase 1
                                    </a>
                                    <a href="/pi/${data.id}/receipt/2" data-phase="2" class="btn dropdown-item submenu-item">
                                        Phase 2
                                    </a>
                                    <a href="/pi/${data.id}/receipt/3" data-phase="3" class="btn dropdown-item submenu-item">
                                        Phase 3
                                    </a>
                                </div>
                            </div>

                            <div class="dropdown-submenu">
                                <button data-id="${data.id}" type="button" class="dropdown-item">
                                    Rollback
                                </button>
                                <div class="dropdown-menu custom-submenu">
                                    <a href="/pi/${data.id}/rollback/0" data-phase="0" class="btn dropdown-item submenu-item">
                                        Phase 0
                                    </a>
                                    <a href="/pi/${data.id}/rollback/1" data-phase="1" class="btn dropdown-item submenu-item">
                                        Phase 1
                                    </a>
                                    <a href="/pi/${data.id}/rollback/2" data-phase="2" class="btn dropdown-item submenu-item">
                                        Phase 2
                                    </a>
                                    <a href="/pi/${data.id}/rollback/3" data-phase="3" class="btn dropdown-item submenu-item">
                                        Phase 3
                                    </a>
                                </div>
                            </div>

                            <form action="/pi/${data.id}/delete" method="post"> 
							    <input type="hidden" name="_token" value="${csrfToken}">
                              <button class="dropdown-item">Delete</button>
                            </form>

                            <a href="/pi/${data.id}/export" class="btn dropdown-item">
							   Export to Spreedsheet
                            </a>

                        </div>
                      </div> `
                    return button;
                },
            }
        ],
    });
    setGlobalVariable("table_pi", table_pi);
}
