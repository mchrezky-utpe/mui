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
		const departmentId = $("#gen_department_id").val();
		
		loadPurchaseList(startdate, endDate, departmentId);
		
		fetchDataSummary(startdate, endDate, departmentId)
			.then(data => {
				console.log("Succesfully get summary:", data);
				$("#purchase_freq_table tbody").empty();
				for (let index = 0; index < data.length; index++) {
					const item = data[index];
					const newRow =
						`<tr data-id="${item.gen_department_id}">
                            <td>
                                ${item.department}
                            </td>
                            <td>
                                ${item.currency}
                            </td>
                            <td>
                                ${item.total}
                            </td>
                        </tr>`;

					$("#purchase_freq_table tbody").append(newRow);
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


	$(document).on('click', '#purchase_freq_table tbody tr', function() {
		const gen_department_id = parseInt($(this).data('id'));
		const startdate = $("#startDate").val();
		const endDate = $("#endDate").val();

		// Remove selected class dari semua row
		$('#purchase_freq_table tbody tr').removeClass('selected');

		// Add selected class ke row yang diklik
		$(this).addClass('selected');

		// Load detail produk
		console.log("click")
		loadPurchaseList(startdate, endDate, gen_department_id);
	});

});

function loadPurchaseList(startDate, endDate, gen_department_id) {
	$.ajax({
		type: "GET",
		url: base_url + `pa/frequency/list?startDate=${startDate}&endDate=${endDate}&gen_department_id=${gen_department_id}`,
		success: function(data) {
			data = data.data;
			$("#table-po tbody").empty();
			for (let index = 0; index < data.length; index++) {
				const item = data[index];
				const newRow =
					`<tr>
                        <td>
                            ${item.trans_date}
                        </td>
                        <td>
                            ${item.doc_num}
                        </td>
                        <td>
                            ${item.department}
                        </td>
                        <td>
                            ${item.sku_name}
                        </td>
                        <td>
                            ${item.sku_inventory_unit}
                        </td>
                        <td>
                            ${item.qty}
                        </td>
                        <td>
                            ${item.currency}
                        </td>
                        <td>
                            ${item.price_f}
                        </td>
                        <td>
                            ${item.total_f}
                        </td>
                    </tr>`;

				$("#table-po tbody").append(newRow);
                loadLineChart(data);
			}
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
        acc[date] = (acc[date] || 0) + Number(current.total_f);
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
                label: 'Purchase Frequency',
                data: data,
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



function fetchDataSummary(startdate, endDate, departmentId) {
	return new Promise((resolve, reject) => {
		$.ajax({
			type: "GET",
			url: base_url + `pa/frequency/summary?startDate=${startdate}&endDate=${endDate}&gen_department_id=${departmentId}`,
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