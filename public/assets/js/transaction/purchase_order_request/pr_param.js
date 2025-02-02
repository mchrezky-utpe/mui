import {
	setGlobalVariable
} from './pr_global_variable.js';

export function initParam() {
	$(document).on('change', '#supplier_select', function() {
		const supplier_id = $('#supplier_select').val();
		fetchSkuMaster(supplier_id)
			.then(data => {
				setGlobalVariable('skuMaster', data);
				console.log("Succesfully get Sku:", data.sku);
			})
			.catch(err => {
				console.error("Error get Supplier:", err);
			});

	});

	fetchTermsMaster()
		.then(data => {
			console.log("Succesfully get terms:", data);
			populateSelect('Terms', data, $('.terms_select'));
		})
		.catch(err => {
			console.error("Error get terms:", err);
		});

	fetchSupplierMaster()
		.then(data => {
			console.log("Succesfully get Supplier:", data);
			populateSelect('Supplier', data, $('#supplier_select'));
		})
		.catch(err => {
			console.error("Error get Supplier:", err);
		});

	fetchDepartmentMaster()
		.then(data => {
			console.log("Succesfully get Department:", data);
			populateSelect('Department', data, $('#department_select'));
		})
		.catch(err => {
			console.error("Error get Department:", err);
		});

	fetchCurrencyMaster()
		.then(data => {
			console.log("Succesfully get Department:", data);
			populateSelect('Currency', data, $('#currency_select'));
			$('#currency_select').val(65).change();
		})
		.catch(err => {
			console.error("Error get Currency:", err);
		});
}
		
function fetchTermsMaster() {
	return new Promise((resolve, reject) => {
		$.ajax({
			type: 'GET',
			url: base_url + 'general-terms/api/by',
			data: {
				prefix: 'PCT'
			},
			success: function(data) {
				resolve(data.data[0].details);
			},
			error: function(err) {
				console.error("Error fetching terms master:", err);
				reject(err);
			}
		});
	});
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

function fetchDepartmentMaster() {
	return new Promise((resolve, reject) => {
		$.ajax({
			type: 'GET',
			url: base_url + 'api/general-department',
			success: function(data) {
				resolve(data.data);
			},
			error: function(err) {
				console.error("Error fetching department master:", err);
				reject(err);
			}
		});
	});
}

function fetchCurrencyMaster() {
	return new Promise((resolve, reject) => {
		$.ajax({
			type: 'GET',
			url: base_url + 'api/general-currency',
			success: function(data) {
				resolve(data.data);
			},
			error: function(err) {
				console.error("Error fetching currency master:", err);
				reject(err);
			}
		});
	});
}

function fetchSkuMaster(supplier_id) {
	return new Promise((resolve, reject) => {
		$.ajax({
			type: 'GET',
			url: base_url + 'sku-pricelist/api/by',
			data: {
				prs_supplier_id: supplier_id
			},
			success: function(data) {
				resolve(data.data);
			},
			error: function(err) {
				console.error("Error fetching terms master:", err);
				reject(err);
			}
		});
	});
}
// 