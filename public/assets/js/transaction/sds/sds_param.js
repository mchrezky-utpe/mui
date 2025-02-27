import {
	setGlobalVariable
} from './sds_global_variable.js';

export function initParam() {
	
	fetchSupplierMaster()
		.then(data => {
			console.log("Succesfully get Supplier:", data);
			populateSelect('Supplier', data, $('#supplier_select'));
		})
		.catch(err => {
			console.error("Error get Supplier:", err);
		});

			$(document).on('change', '#supplier_select', function() {
			const supplier_id = $('#supplier_select').val();
			fetchPoDroplist(supplier_id)
				.then(data => {
					// setGlobalVariable('poMaster', data);
					populateSelect('Po', data, $('#po_select'));
				})
				.catch(err => {
					console.error("Error get po:", err);
				});
	
		});
		
	// fetchPoDroplist()
	// .then(data => {
	// 	console.log("Succesfully get po:", data);
	// 	populateSelect('Po', data, $('#po_select'));
	// })
	// .catch(err => {
	// 	console.error("Error get po:", err);
	// });

}
		
function fetchSupplierMaster() {
	return new Promise((resolve, reject) => {
		$.ajax({
			type: 'GET',
			url: base_url + 'api/person-supplier',
			success: function(data) {
				resolve(data.data);
			},
			error: function(err) {
				console.error("Error fetching supplier master:", err);
				reject(err);
			}
		});
	});
}

		
function fetchPoDroplist(supplier_id) {
	return new Promise((resolve, reject) => {
		$.ajax({
			type: 'GET',
			url: base_url + 'api/po/droplist',
			data:{supplier_id : supplier_id},
			success: function(data) {
				resolve(data.data);
			},
			error: function(err) {
				console.error("Error fetching po droplist:", err);
				reject(err);
			}
		});
	});
}
// 