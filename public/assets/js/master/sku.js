$(document).on('click', '.edit', function (e) {
    var id = this.dataset.id;
    $.ajax({
        type: 'GET',
        url: base_url + 'sku/' + id,
        success: function (data) {
            var data = data.data;

            $('[name=id]').val(data.id);
            $('[name=manual_id]').val(data.manual_id);
            $('[name=description]').val(data.description);
            $('[name=type_id]').val(data.sku_type_id).prop('selected', true);
            $('[name=model_id]').val(data.sku_model_id).prop('selected', true);
            $('[name=process_id]').val(data.sku_process_id).prop('selected', true);
            $('[name=business_type_id]').val(data.sku_business_type_id).prop('selected', true);
            $('[name=packaging_id]').val(data.sku_packaging_id).prop('selected', true);
            $('[name=detail_id]').val(data.sku_detail_id).prop('selected', true);
            $('[name=unit_id]').val(data.sku_unit_id).prop('selected', true);

            $('#edit_modal').modal('show');

        },
        error: function (err) {
            debugger;
        }
    });
});




function populateSelect(master_data, element) {
	element.empty();
	element.append('<option value=""> -- Select -- </option>');
	master_data.forEach(data => {
		element.append(`<option value="${data.id}">${data.description}</option>`);
	});
  }

// ================================

$('.btn_part_information').click(function(){
	fetchSetCode()
	.then(data => {
		console.log("Succesfully fetchSetCode:", data);
		$('[name=group_tag]').val(data);
	})
	.catch(err => {
		console.error("Error fetchSkuType:", err);
	});


});


fetchSkuType()
.then(data => {
    console.log("Succesfully fetchSkuType:", data);
    populateSelect(data, $('[name=sku_type_id]'));
})
.catch(err => {
    console.error("Error fetchSkuType:", err);
});

function fetchSkuType() {
	return new Promise((resolve, reject) => {
		$.ajax({
			type: 'GET',
			url: base_url + 'api/sku-type/droplist',
			success: function(data) {
				resolve(data.data);
			},
			error: function(err) {
				console.error("Error fetchSkuType:", err);
				reject(err);
			}
		});
	});
}
// ================================


// ================================
fetchSkuSalesCategory()
.then(data => {
    console.log("Succesfully fetchSkuSalesCategory:", data);
    populateSelect(data, $('[name=sku_sales_category_id]'));
})
.catch(err => {
    console.error("Error fetchSkuSalesCategory:", err);
});

function fetchSkuSalesCategory() {
	return new Promise((resolve, reject) => {
		$.ajax({
			type: 'GET',
			url: base_url + 'api/sku-sales/droplist',
			success: function(data) {
				resolve(data.data);
			},
			error: function(err) {
				console.error("Error fetchSkuSalesCategory:", err);
				reject(err);
			}
		});
	});
}
// ================================

// ================================
fetchSkuUnit()
.then(data => {
    console.log("Succesfully fetchSkuUnit:", data);
    populateSelect(data, $('[name=sku_procurement_unit_id]'));
    populateSelect(data, $('[name=sku_inventory_unit_id]'));
})
.catch(err => {
    console.error("Error fetchSkuUnit:", err);
});

function fetchSkuUnit() {
	return new Promise((resolve, reject) => {
		$.ajax({
			type: 'GET',
			url: base_url + 'api/sku-unit/droplist',
			success: function(data) {
				resolve(data.data);
			},
			error: function(err) {
				console.error("Error fetchSkuUnit:", err);
				reject(err);
			}
		});
	});
}
// ================================

// ================================
fetchSkuBusinessType()
.then(data => {
    console.log("Succesfully fetchSkuBusinessType:", data);
    populateSelect(data, $('[name=sku_category_id]'));
})
.catch(err => {
    console.error("Error fetchSkuBusinessType:", err);
});

function fetchSkuBusinessType() {
	return new Promise((resolve, reject) => {
		$.ajax({
			type: 'GET',
			url: base_url + 'api/sku-business/droplist',
			success: function(data) {
				resolve(data.data);
			},
			error: function(err) {
				console.error("Error fetchSkuBusinessType:", err);
				reject(err);
			}
		});
	});
}
// ================================


// ================================
fetchSkuModel()
.then(data => {
    console.log("Succesfully fetchSkuModel:", data);
    populateSelect(data, $('[name=sku_business_type_id]'));
})
.catch(err => {
    console.error("Error fetchSkuModel:", err);
});

function fetchSkuModel() {
	return new Promise((resolve, reject) => {
		$.ajax({
			type: 'GET',
			url: base_url + 'api/sku-model/droplist',
			success: function(data) {
				resolve(data.data);
			},
			error: function(err) {
				console.error("Error fetchSkuModel:", err);
				reject(err);
			}
		});
	});
}

function fetchSetCode() {
	return new Promise((resolve, reject) => {
		$.ajax({
			url: "/api/sku/get-set-code", // Endpoint backend
				method: "GET",
				success: function(response) {
					resolve(response.data.code);
				},
				error: function(xhr, status, error) {
					console.error("Error fetching data:", error);
				}
			});
	});
}
// ================================

  // Ketika input diklik, tampilkan modal
  $("[name=group_tag]").on("click", function() {
	// Ambil data dari backend
	$.ajax({
	url: "/api/sku/get-set-code", // Endpoint backend
		method: "GET",
		success: function(response) {
			var list = $("#setCodeList");
			list.empty(); // Kosongkan list sebelum menambahkan data baru

			// Tambahkan data ke dalam list
			response.data.forEach(function(item) {
				list.append('<li data-value="' + item.id + '">' + item.name + '</li>');
			});

            $('#set_code_modal').modal('show');
		},
		error: function(xhr, status, error) {
			console.error("Error fetching data:", error);
		}
	});
});


$("[name=group_tag]").on("click", function() {
	// Ambil data dari backend
	$.ajax({
	url: "/api/sku/get-set-code", // Endpoint backend
		method: "GET",
		success: function(response) {
			var list = $("#setCodeList");
			list.empty(); // Kosongkan list sebelum menambahkan data baru

			// Tambahkan data ke dalam list
			response.data.forEach(function(item) {
				list.append('<li data-value="' + item.id + '">' + item.name + '</li>');
			});

            $('#set_code_modal').modal('show');
		},
		error: function(xhr, status, error) {
			console.error("Error fetching data:", error);
		}
	});
});