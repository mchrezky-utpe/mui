import {
	initParam
} from "./pa_param.js";
// import { handleTableServerSide } from "./pi_table_server_side.js";
// import { handleActionTable } from "./pi_action_table.js";

$(document).ready(function() {
	initParam();


	    $('#tab1-tab').on('click', function() {
         	$('.supplier_select').show();
         	$('.supplier_label').show();
         	$('.department_select').hide();
         	$('.department_label').hide();
			$("#purchase_order_table tbody").empty();
		});
            
		$('#tab2-tab').on('click', function() {
         	$('.department_select').show();
         	$('.department_label').show();
         	$('.supplier_select').hide();
         	$('.supplier_label').hide();
			$("#purchase_order_table tbody").empty();
		});
            


	$('#btn-filter').on('click', function() {
		let tabType = "";
		if($('.supplier_select').is(":visible")){
			tabType = "supplier";
		}else{
			tabType = "department";
		}
		const startdate = $("#startDate").val();
		const endDate = $("#endDate").val();
		const supplier_id = $("#supplier_id").val();
		const gen_department_id = $("#gen_department_id").val();
		fetchDataSummaryOrder(startdate, endDate, supplier_id,gen_department_id,tabType)
			.then(data => {
				console.log("Succesfully get data:", data);
				$("#purchase_order_table tbody").empty();
				if(tabType == "supplier"){
					for (let index = 0; index < data.length; index++) {
						const item = data[index];
						const newRow = 
							`<tr data-id="${item.prs_supplier_id}">
								<td>
									${item.supplier}
								</td>
							</tr>`;

						$("#purchase_order_table tbody").append(newRow);
					}
				}else{
					for (let index = 0; index < data.length; index++) {
						const item = data[index];
						const newRow = 
							`<tr data-id="${item.gen_department_id}">
								<td>
									${item.department}
								</td>
							</tr>`;

						$("#purchase_order_table tbody").append(newRow);
					}
				}
				// Muat konten tab pertama saat halaman dimuat
				// loadBarChart(data);
			}).catch(err => {
				console.error("Error get data:", err);
			});
	});

	// Event delegation untuk menu item
	$(document).on('click', '.menu-item', function() {
		$('.menu-item').removeClass('active');
		$(this).addClass('active');
	});


	$(document).on('click', '#purchase_order_table tbody tr', function() {
		let tabType = "";
		if($('.supplier_select').is(":visible")){
			tabType = "supplier";
		}else{
			tabType = "department";
		}
		
		const id = parseInt($(this).data('id'));
		const startdate = $("#startDate").val();
		const endDate = $("#endDate").val();

		// Remove selected class dari semua row
		$('#purchase_order_table tbody tr').removeClass('selected');

		// Add selected class ke row yang diklik
		$(this).addClass('selected');

		// Load detail produk
		console.log("click")
		loadPurchaseOrderList(startdate, endDate, id,tabType);
	});

});

function loadPurchaseOrderList(startdate, endDate, id,tabType) {
	$.ajax({
		type: "GET",
		url: base_url + `pa/order/list?startDate=${startdate}&endDate=${endDate}&id=${id}&tabType=${tabType}`,
		success: function(data) {
			data = data.data;
            loadLineChart(data);
		},
		error: function(err) {
			debugger;
			reject(err);
		},
	});

}

function loadLineChart(dataPo) {

	  // Group data by trans_date
    const groupedData = dataPo.reduce((acc, current) => {
        const date = current.trans_date;
        acc[date] = (acc[date] || 0) + Number(current.total);
        return acc;
    }, {});

    // Konversi ke array dan sort by date
    const sortedEntries = Object.entries(groupedData)
        .sort(([dateA], [dateB]) => new Date(dateA) - new Date(dateB));

    const labels = sortedEntries.map(([date]) => date);
    const data = sortedEntries.map(([, total]) => total);


    const chartData = {
        tab: {
            labels: labels,
            datasets: [{
                label: 'Purchase Order Trends',
                data: data,
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: 'rgba(75, 192, 192, 0.1)',
                tension: 0.1,
                fill: true
            }]
        }
    };
	// load line chart
	initializeChart(`chart`, chartData[`tab`]);
}


function fetchDataSummaryOrder(startdate, endDate, supplier_id, gen_department_id,tabType) {
	return new Promise((resolve, reject) => {
		$.ajax({
			type: "GET",
			url: base_url + `pa/order/summary?startDate=${startdate}&endDate=${endDate}&supplier_id=${supplier_id}&gen_department_id=${gen_department_id}&tabType=${tabType}`,
			success: function(data) {
				resolve(data.data);
			},
			error: function(err) {
				debugger;
				reject(err);
			},
		});

	});
}


// Fungsi untuk inisialisasi grafik
function initializeChart(canvasId, data) {
    
	const canvas = document.getElementById(canvasId);
	const chart = Chart.getChart(canvas);
	if (canvas) {
		const chart = Chart.getChart(canvas);
		if (chart) {
			chart.destroy();
		}
	}
	const ctx = $(`#${canvasId}`)[0].getContext('2d');
	new Chart(ctx, {
		type: 'line',
		data: data,
		options: {
			responsive: true,
			maintainAspectRatio: false,
			plugins: {
				legend: {
					position: 'top',
				},
				title: {
					display: true,
					text: 'Trend Data'
				}
			}
		}
	});
}