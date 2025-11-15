import {
	initParam
} from "./supplier_performance_param.js";
// import { handleTableServerSide } from "./pi_table_server_side.js";
// import { handleActionTable } from "./pi_action_table.js";

$(document).ready(function() {
	initParam();

	
	$('.nav-link').on('click', function() {
		const canvas = document.getElementById("chart");
		if (canvas) {
			const chart = Chart.getChart(canvas);
			if (chart) {
				chart.destroy();
			}
		}
		
		$("#detail_performance_table tbody").empty();
	});

	$('#btn-filter').on('click', function() {
		
		const canvas = document.getElementById("chart");
		if (canvas) {
			const chart = Chart.getChart(canvas);
			if (chart) {
				chart.destroy();
			}
		}
		
		$("#detail_performance_table tbody").empty();
		
		const startdate = $("#startDate").val();
		const endDate = $("#endDate").val();
		const supplier_id = $("#supplier_id").val();
		fetchDataSummaryOrder(startdate, endDate, supplier_id)
			.then(data => {
				console.log("Succesfully get data:", data);
				$("#supplier_peformance_table tbody").empty();
				
			for (let index = 0; index < data.length; index++) {
				const item = data[index];
				const newRow = 
					`<tr data-id="${item.prs_supplier_id}">
						<td>
							${item.supplier}
						</td>
						<td>
							${item.total_late}
						</td>
						<td>
							${item.delivery_grade}
						</td>
						<td>
							-
						</td>
						<td>
							-
						</td>
					</tr>`;

				$("#supplier_peformance_table tbody").append(newRow);
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


	$(document).on('click', '#supplier_peformance_table tbody tr', function() {
		let tabType = "delivery";
		
		const tabId = $("#dashboardTabs .active").attr('id');
        
        if (tabId === 'tab1-tab') {
            tabType = 'delivery';
        } else if (tabId === 'tab2-tab') {
            tabType = 'quality';
        }
	
		const prs_supplier_id = parseInt($(this).data('id'));
		const startdate = $("#startDate").val();
		const endDate = $("#endDate").val();

		// Remove selected class dari semua row
		$('#supplier_peformance_table tbody tr').removeClass('selected');

		// Add selected class ke row yang diklik
		$(this).addClass('selected');

		// Load detail produk
		console.log("click")

		if(tabType == "delivery"){
			loadDeliveryDetailList(startdate, endDate, prs_supplier_id);
		}else{
			loadQualityDetailList(startdate, endDate, prs_supplier_id);
		}
	});

});


function loadDeliveryDetailList(startdate, endDate, prs_supplier_id) {
	$.ajax({
		type: "GET",
		url: base_url + `supplier-performance/summary/detail?startDate=${startdate}&endDate=${endDate}&prs_supplier_id=${prs_supplier_id}`,
		success: function(data) {
			data = data.data;
			
		    $("#detail_performance_table tbody").empty();
			
		    $("#detail_performance_table tbody").append(
				` <tr class="row_sds">
                                        <td>1</td>
                                        <td>Total SDS</td>
                                    </tr>
                                    <tr class="row_on_schedule">
                                        <td>2</td>
                                        <td>Total On Schedule</td>
                                    </tr>
                                    <tr class="row_late">
                                        <td>3</td>
                                        <td>Total Late</td>
                                    </tr>`
			);

				
			for (let index = 0; index < data.length; index++) {
				const item = data[index];
				$("#detail_performance_table tbody .row_sds")
				.append(`<td>${item.total_sds}</td>`);

				$("#detail_performance_table tbody .row_on_schedule")
				.append(`<td>${item.total_on_schedule}</td>`);

				$("#detail_performance_table tbody .row_late")
				.append(`<td>${item.total_late}</td>`)
			}	
            loadDeliveryLineChart(data,'Supplier Delivery Performance',"Late");
		},
		error: function(err) {
			debugger;
			reject(err);
		},
	});

}




function loadQualityDetailList(startdate, endDate, prs_supplier_id) {
	$.ajax({
		type: "GET",
		url: base_url + `supplier-performance/summary/detail?startDate=${startdate}&endDate=${endDate}&prs_supplier_id=${prs_supplier_id}`,
		success: function(data) {
			data = data.data;
			
		    $("#detail_performance_table tbody").empty();
			
		    $("#detail_performance_table tbody").append(
				`					<tr class="row_received">
                                        <td>1</td>
                                        <td>Total Received</td>
                                    </tr>
                                    <tr class="row_ng">
                                        <td>2</td>
                                        <td>Total NG</td>
                                    </tr>
                                    <tr class="row_ppm">
                                        <td>3</td>
                                        <td>Total PPM</td>
                                    </tr>`
			);

				
			for (let index = 0; index < data.length; index++) {
				const item = data[index];
				$("#detail_performance_table tbody .row_received")
				.append(`<td>${item.total_sds}</td>`);

				$("#detail_performance_table tbody .row_ng")
				.append(`<td>${item.total_on_schedule}</td>`);

				$("#detail_performance_table tbody .row_ppm")
				.append(`<td>${item.total_late}</td>`)
			}	
            loadDeliveryLineChart(data,'Supplier Quality Performance',"PPM");
		},
		error: function(err) {
			debugger;
			reject(err);
		},
	});

}

function loadDeliveryLineChart(data, label, title) {
    const chartData = {
        tab: {
            labels: data.map(m => m.period_label),
            datasets: [{
                label: label,
                data: data.map(m => Number(m.total_late)),
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: 'rgba(75, 192, 192, 0.1)',
                tension: 0.1,
                fill: true
            }]
        }
    };
	// load line chart
	initializeChart(`chart`, chartData[`tab`],title);
}


function fetchDataSummaryOrder(startdate, endDate, supplier_id) {
	return new Promise((resolve, reject) => {
		$.ajax({
			type: "GET",
			url: base_url + `supplier-performance/summary?startDate=${startdate}&endDate=${endDate}&prs_supplier_id=${supplier_id}`,
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
function initializeChart(canvasId, data, title) {
    
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
			},
        scales: {
            x: {
                min: 0, // Minimum value untuk sumbu X
                // Opsi konfigurasi tambahan untuk sumbu X:
                title: {
                    display: true,
                    text: 'Periode Waktu'
                },
                grid: {
                    color: 'rgba(0, 0, 0, 0.1)'
                }
            },
            y: {
                beginAtZero: true, // Untuk sumbu Y tetap mulai dari 0
                title: {
                    display: true,
                    text: title
                }
            }
		}
		}
	});
}