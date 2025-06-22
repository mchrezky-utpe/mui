$(document).on('click', '.edit', function (e) {
    var id = this.dataset.id;
    $.ajax({
        type: 'GET',
        url: base_url + 'sku-type/' + id,
        success: function (data) {
            var data = data.data;

            $('[name=id]').val(data.id);
            $('[name=manual_id]').val(data.manual_id);
            $('[name=sku_category_id]').val(data.sku_category_id);
            $('[name=sku_sub_category_id]').val(data.sku_sub_category_id);
            $('[name=description]').val(data.description);
            $('[name=prefix]').val(data.prefix);
            $('[name=group_tag]').val(data.group_tag);
            $('[name=sku_classification_id]').val(data.sku_classification_id);
            $('[name=flag_trans_type]').val(data.flag_trans_type);
			if(data.flag_primary == 1){
				$('[name=flag_primary]').prop('checked', true);
			}			
			if(data.flag_checking == 1){
				$('[name=flag_checking]').prop('checked', true);
			}	
            $('[name=flag_checking]').val(data.flag_checking);
            $('[name=flag_checking_result]').val(data.flag_checking_result);		
			if(data.flag_bom == 1){
				$('[name=flag_bom]').prop('checked', true);
			}
            $('[name=flag_allowance]').val(data.flag_allowance);
            $('[name=val_allowance]').val(data.val_allowance);

            $('#edit_modal').modal('show');

        },
        error: function (err) {
            debugger;
        }
    });
});


function populateSelectSubCategory(master_data, element) {
    element.empty();
    element.append('<option value=""> === Select === </option>');
    master_data.forEach(data => {
        element.append(`<option value="${data.id}">${data.sku_sub_category}</option>`);
    });
}


function populateSelectClassification(master_data, element) {
    element.empty();
    element.append('<option value=""> === Select === </option>');
    master_data.forEach(data => {
        element.append(`<option value="${data.id}">${data.sku_classification}</option>`);
    });
}

function populateSelect(master_data, element) {
    element.empty();
    element.append('<option value=""> === Select === </option>');
    master_data.forEach(data => {
        element.append(`<option value="${data.id}">${data.description}</option>`);
    });
}


fetchSkuCategory()
.then(data => {
    console.log("Succesfully get sku category:", data);
    populateSelect(data, $('[name=sku_category_id]'));
})
.catch(err => {
    console.error("Error get sku category:", err);
});

fetchSkuSubCategory()
.then(data => {
    console.log("Succesfully get sku ub category:", data);
    populateSelectSubCategory(data, $('[name=sku_sub_category_id]'));
})
.catch(err => {
    console.error("Error get sku category:", err);
});

fetchSkuClassification()
.then(data => {
    console.log("Succesfully get sku classification:", data);
    populateSelectClassification(data, $('[name=sku_classification_id]'));
})
.catch(err => {
    console.error("Error get sku category:", err);
});

function fetchSkuCategory() {
	return new Promise((resolve, reject) => {
		$.ajax({
			type: 'GET',
			url: base_url + 'api/sku-category/droplist',
			success: function(data) {
				resolve(data.data);
			},
			error: function(err) {
				console.error("Error fetching sku sub category:", err);
				reject(err);
			}
		});
	});
}

function fetchSkuSubCategory() {
	return new Promise((resolve, reject) => {
		$.ajax({
			type: 'GET',
			url: base_url + 'api/sku-sub-category/droplist',
			success: function(data) {
				resolve(data.data);
			},
			error: function(err) {
				console.error("Error fetching sku sub category:", err);
				reject(err);
			}
		});
	});
}

function fetchSkuClassification() {
	return new Promise((resolve, reject) => {
		$.ajax({
			type: 'GET',
			url: base_url + 'api/sku-classification/droplist',
			success: function(data) {
				resolve(data.data);
			},
			error: function(err) {
				console.error("Error fetching sku classification:", err);
				reject(err);
			}
		});
	});
}