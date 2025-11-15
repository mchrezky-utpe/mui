import {
	setGlobalVariable
} from './supplier_performance_global_variable.js';

export function initParam() {
	
	fetchSupplierMaster()
		.then(data => {
			console.log("Succesfully get Supplier:", data);
			populateSelect('Supplier', data, $('.supplier_select'));
		})
		.catch(err => {
			console.error("Error get Supplier:", err);
		});

	fetchDepartmentMaster()
		.then(data => {
			console.log("Succesfully get Department:", data);
			populateSelect('Department', data, $('.department_select'));
		})
		.catch(err => {
			console.error("Error get Department:", err);
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
// 