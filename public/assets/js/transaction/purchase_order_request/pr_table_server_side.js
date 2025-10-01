import { setGlobalVariable } from "./pr_global_variable.js";

export function handleTableServerSide() {


    const table_pr = $("#table-pr").DataTable({
        scrollCollapse: true,
        scrollX: true,
        scrollY: 300,
        processing: true,
        serverSide: true,
        fixedColumns: {
            right: 1,
            heightMatch: 'auto'
        },
        ajax: {
            url: base_url + "pr/api/all",
            type: "GET",
            data: function (d) {
                d.start_date = $('input[name="start_date"]').val();
                d.end_date = $('input[name="end_date"]').val();
                d.customer = $("#customer").val();
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
                data: "trans_date",
            },
            {
                data: "department",
            },
            {
                data: "transaction_type",
            },
            {
                data: "transaction_purpose",
            },
            {
                data: "supplier",
            },
            {
                data: "transaction_status",
            },
            {
                data: "description",
            },
            {
                data: "total_f",
            },
            {
                data: null,
            },
        ],
        columnDefs: [
            {
                targets: 0,
                orderable: false,
                searchable: false,
                render: function (data, type, row, meta) {
                    return meta.row + 1;
                },
            },
            {
                targets: 10,
                orderable: false,
                searchable: false,
                render: function (data, type, row, meta) {
                    const csrfToken = document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content");

                    let button_action = 
                        `<button data-id="`+data.id+`" type="button" class="btn_detail btn btn-info">
                          <span class="fas fa-eye"></span>
                        </button>`

                    if (data.flag_status == 2) {
                        button_action +=
                            `
							<button data-id="` +
                            data.id +
                            `" type="button" class="create_po btn btn-primary">
                            	<span>Create PO</span>
                            </button>
							`;
                    } else if (data.flag_status == 1) {
                        button_action +=
                            `
								<button data-id="` +
                            data.id +
                            `" type="button"  class="edit btn btn-success">
									<span class="fas fa-pencil-alt"></span>
								</button>
								<button type="submit" class="btn btn-danger">
									<span class="fas fa-trash"></span>
								</button>`;
                    }
                    return (
                        `
                        <form action="/pr/` +
                        data.id +
                        `/delete" method="post" onsubmit="return confirm('Are you sure you want to delete it?')">
                            <input type="hidden" name="_token" value="${csrfToken}">
							` +
                        button_action +
                        `
                        </form>
                    `
                    ); // Menampilkan nomor urut
                },
            },
        ],
    });
    
    
    setGlobalVariable("table_pr", table_pr);
}
