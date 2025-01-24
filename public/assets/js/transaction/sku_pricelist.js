$(document).ready(function(){

    
$(document).on('click', '.edit', function (e) {
    var id = this.dataset.id;
    $.ajax({
        type: 'GET',
        url: base_url + 'sku-pricelist/' + id,
        success: function (data) {
            var data = data.data;

            $('[name=id]').val(data.id);
            $('[name=manual_id]').val(data.manual_id);
            $('[name=sku_id]').val(data.sku_id);
            $('[name=price]').val(data.price);
            $('[name=gen_currency_id]').val(data.gen_currency_id);
            $('[name=prs_supplier_id]').val(data.prs_supplier_id);

            $('#edit_modal').modal('show');

        },
        error: function (err) {
            debugger;
        }
    });
});



// =========== HANDLING PARAM
initParam();
function initParam(){
    fetchSkuMaster()
    .then(data => {
        console.log("Succesfully get Sku:", data);
        populateSelect('Sku', data, $('[name=sku_id]')) ;
    }).catch(err => {
        console.error("Error get Sku:", err);
    });

    fetchCurrency()
    .then(data => {
        console.log("Succesfully get currency:", data);
        populateSelect('Currency', data, $('[name=gen_currency_id]')) ;
    }).catch(err => {
        console.error("Error get currency:", err);
    });
    
    fetchSupplier()
    .then(data => {
        console.log("Succesfully get supplier:", data);
        populateSelect('Supplier', data, $('[name=prs_supplier_id]')) ;
    }).catch(err => {
        console.error("Error get supplier:", err);
    });
}


function fetchSkuMaster() {
    return new Promise((resolve, reject) => {
        $.ajax({
            type: 'GET',
            url: base_url + 'api/sku',
            success: function (data) {
                resolve(data.data);
            },
            error: function (err) {
                console.error("Error fetching terms master:", err);
                reject(err);
            }
        });
    });
}

function fetchCurrency() {
    return new Promise((resolve, reject) => {
        $.ajax({
            type: 'GET',
            url: base_url + 'api/currency',
            success: function (data) {
                resolve(data.data);
            },
            error: function (err) {
                console.error("Error fetching:", err);
                reject(err);
            }
        });
    });
}

function fetchSupplier() {
    return new Promise((resolve, reject) => {
        $.ajax({
            type: 'GET',
            url: base_url + 'api/person-supplier',
            success: function (data) {
                resolve(data.data);
            },
            error: function (err) {
                console.error("Error fetching:", err);
                reject(err);
            }
        });
    });
}

function populateSelect(title, master_data, element) {
    element.empty();
    element.append('<option value="">-- Select '+title+' --</option>');
    master_data.forEach(data => {
        element.append(`<option value="${data.id}">${data.description}</option>`);
    });
}

});
    
