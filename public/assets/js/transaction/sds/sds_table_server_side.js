import {
	setGlobalVariable
} from './sds_global_variable.js';

export function handleTableServerSide() {
	
    const table_sds = $("#table_sds").DataTable({
     
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
            url: base_url + "api/sds/all",
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
                data: "trans_date",
            },
            {
                data: "department",
            },
            {
                data: "supplier",
            },
            {
                data: "sds_status",
            },
            {
                data: "rev_counter",
            },
            {
                data: "status_sent_to_edi",
            },
            {
                data: "sds_delivery",
            },
            {
                data: "status_sent_to_edi",
            },
            {
                data: "sds_shipment",
            },
            {
                data: "status_reschedule",
            },
            {
                data: "rev_date",
            }
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


                    let stateButtonEdi = "";
                    if(data.is_sent_to_edi == 0 && data.flag_status == 1){
                        stateButtonEdi = "";
                     }else{ stateButtonEdi = "disabled"}
                        
					
                    let stateButtonPullBack = "";
                    if(data.flag_status == 1 && data.is_sent_to_edi == 0){
                        stateButtonPullBack = "";
                     }else{ stateButtonPullBack = "disabled"}
					
                    let stateButtonReschedule = "";
                    if(data.flag_status == 3){
                        stateButtonReschedule = "";
                     }else{ stateButtonReschedule = "disabled"}

                    let button = `
                        <div class="btn-group" role="group">
                        <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Action
                        </button>

                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                            <button data-id="${data.id}" class="dropdown-item btn_detail" type="button">Detail</button>

							<button ${stateButtonEdi} data-id="${data.id}" class="dropdown-item edit" type="button">Edit</button>
                                
							<form action="/sds/${data.id}/delete" method="post"> 
							    <input type="hidden" name="_token" value="${csrfToken}">
                              <button ${stateButtonEdi} class="dropdown-item" href="#">Delete</button>
                            </form>

							<form action="/sds/send-to-edi?id=${data.id}" method="post"> 
							    <input type="hidden" name="_token" value="${csrfToken}">
                              <button ${stateButtonEdi} class="dropdown-item .send_to_edit" href="#">Send To EDI</button>
                            </form>

							 <form action="/sds/pull-back?id=${data.id}" method="post"> 
                           		<input type="hidden" name="_token" value="${csrfToken}">
                              <button  ${stateButtonPullBack} class="dropdown-item btn_pullback" href="#">Pull Back</button>
                          	</form>

                          <form action="/sds/reschedule?id=${data.id}" method="post"> 
                              <input type="hidden" name="_token" value="${csrfToken}">
                              <button ${stateButtonReschedule} type="button" data-id="${data.id}" class="dropdown-item btn_reschedule" href="#">Reschedule</button>
                          </form>

                        </div>
                      </div> `
                    return button;
                },
            },
        ],
    });
	setGlobalVariable('table_sds', table_sds);
}