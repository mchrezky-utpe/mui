import {
	initParam
} from "./pa_param.js";
// import { handleTableServerSide } from "./pi_table_server_side.js";
// import { handleActionTable } from "./pi_action_table.js";

$(document).ready(function() {
	initParam();

	$('#btn-filter').on('click', function() {
		const startdate = $("#startDate").val();
		const endDate = $("#endDate").val();
		const count = $("#count").val();
	
		fetchDataSummary(startdate, endDate, count)
			.then(data => {
				console.log("Succesfully get summary:", data);
				$("#purchase_table tbody").empty();
				for (let index = 0; index < data.length; index++) {
					const item = data[index];
					const newRow =
						`<tr data-id="${item.prs_supplier_id}">
                            <td>
                                ${item.supplier}
                            </td>
                            <td>
                                ${Number(item.total).toLocaleString()}
                            </td>
                        </tr>`;

					$("#purchase_table tbody").append(newRow);
				}
				// Muat konten tab pertama saat halaman dimuat
				loadBarChart(data);
			}).catch(err => {
				console.error("Error get summary:", err);
			});
	});

	// Event delegation untuk menu item
	$(document).on('click', '.menu-item', function() {
		$('.menu-item').removeClass('active');
		$(this).addClass('active');
	});

});

function loadBarChart(dataSummary) {
	// bar chart
	const barChartData = {
		tab: {
			labels: dataSummary.map(m => m.supplier),
			datasets: [{
				label: 'Supplier Trends',
				data: dataSummary.map(m => m.total),
				backgroundColor: 'rgba(54, 162, 235, 0.8)',
				borderColor: 'rgba(54, 162, 235, 1)',
				borderWidth: 1
			}]
		}
	};
	initializeBarChart(`barChartTab`, barChartData[`tab`]);
}



function fetchDataSummary(startdate, endDate, count) {
	return new Promise((resolve, reject) => {
		$.ajax({
			type: "GET",
			url: base_url + `pa/supplier-trend/summary?startDate=${startdate}&endDate=${endDate}&count=${count}`,
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

function initializeBarChart(canvasId, data) {

	const canvas = document.getElementById(canvasId);
	const chart = Chart.getChart(canvas);
	if (canvas) {
		const chart = Chart.getChart(canvas);
		if (chart) {
			chart.destroy();
		}
	}

	const ctx = document.getElementById(canvasId).getContext('2d');
	return new Chart(ctx, {
		type: 'bar',
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
					text: 'Purchase Supplier Trends'
				},
				tooltip: {
					mode: 'index',
					intersect: false
				}
			},
			scales: {
				y: {
					beginAtZero: true,
					grid: {
						drawBorder: false
					}
				},
				x: {
					grid: {
						display: false
					}
				}
			},
			animation: {
				duration: 1000,
				easing: 'easeInOutQuart'
			}
		}
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