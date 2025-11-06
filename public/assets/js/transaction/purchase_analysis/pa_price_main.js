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
		const gen_supplier_id = $("#gen_supplier_id").val();
		const keywords = $("#keywords").val();
		
		fetchDataSummaryPrice(startdate, endDate, gen_supplier_id,keywords)
			.then(data => {
				console.log("Succesfully get data:", data);
				$("#purchase_price_table tbody").empty();
				for (let index = 0; index < data.length; index++) {
					const item = data[index];
					const newRow =
						`<tr data-id="${item.mst_sku_id}">
                            <td>
                                ${item.sku_name}
                            </td>
                            <td>
                                ${item.sku_id}
                            </td>
                        </tr>`;

					$("#purchase_price_table tbody").append(newRow);
				}
				// Muat konten tab pertama saat halaman dimuat
				loadBarChart(data);
			}).catch(err => {
				console.error("Error get data:", err);
			});
	});

	// Event delegation untuk menu item
	$(document).on('click', '.menu-item', function() {
		$('.menu-item').removeClass('active');
		$(this).addClass('active');
	});


	$(document).on('click', '#purchase_price_table tbody tr', function() {
		const gen_supplier_id = $("#gen_supplier_id").val();
		const sku_id = parseInt($(this).data('id'));
		const startdate = $("#startDate").val();
		const endDate = $("#endDate").val();

		// Remove selected class dari semua row
		$('#purchase_price_table tbody tr').removeClass('selected');

		// Add selected class ke row yang diklik
		$(this).addClass('selected');

		// Load detail produk
		console.log("click")
		loadPurchasePriceList(startdate, endDate, sku_id, gen_supplier_id);
	});

});

function loadPurchasePriceList(startdate, endDate, sku_id, gen_supplier_id) {
	$.ajax({
		type: "GET",
		url: base_url + `pa/price/list?startDate=${startdate}&endDate=${endDate}&sku_id=${sku_id}&gen_supplier_id=${gen_supplier_id}`,
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

function loadLineChart(data) {
	
    const labels = data.map( d => d.valid_date_from);
    const items =  data.map( d => d.price);

    const chartData = {
        tab: {
            labels: labels,
            datasets: [{
                label: 'Purchase Price',
                data: items,
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: 'rgba(75, 192, 192, 0.1)',
                tension: 0.1,
                fill: true
            }]
        }
    };
	// load line chart
	initializeChart(`barChartTab`, chartData[`tab`]);
}


function loadBarChart(dataSummary) {
	// bar chart
	const barChartData = {
		tab: {
			labels: dataSummary.map(m => m.department),
			datasets: [{
				label: 'Department',
				data: dataSummary.map(m => m.total),
				backgroundColor: 'rgba(54, 162, 235, 0.8)',
				borderColor: 'rgba(54, 162, 235, 1)',
				borderWidth: 1
			}]
		}
	};
	initializeBarChart(`barChartTab`, barChartData[`tab`]);
}



function fetchDataSummaryPrice(startdate, endDate, gen_supplier_id,keywords) {
	return new Promise((resolve, reject) => {
		$.ajax({
			type: "GET",
			url: base_url + `pa/price/summary?startDate=${startdate}&endDate=${endDate}&gen_supplier_id=${gen_supplier_id}&keywords=${keywords}`,
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
					text: 'Purchase Frequency'
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