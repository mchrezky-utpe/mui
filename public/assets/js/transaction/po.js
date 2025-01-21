
var termsMaster;
let departmentMaster;
let supplierMaster;
let currencyMaster;
let skuMaster;
let otherCostMaster;
let deductionMaster;

$(document).ready(function () {

// =========== HANDLING PARAM
initParam();
function initParam(){


    fetchTermsMaster()
    .then(data => {
        console.log("Succesfully get terms:", data);
        populateSelect('Terms', data, $('#terms_select')) ;
    })
    .catch(err => {
        console.error("Error get terms:", err);
    });

    fetchSupplierMaster()
    .then(data => {
        console.log("Succesfully get Supplier:", data);
        populateSelect('Supplier', data, $('#supplier_select')) ;
    })
    .catch(err => {
        console.error("Error get Supplier:", err);
    });

    fetchSkuMaster()
    .then(data => {
        console.log("Succesfully get Sku:", data);
        skuMaster = data;
    })
    .catch(err => {
        console.error("Error get Supplier:", err);
    });

    // fetchDepartmentMaster()
    // .then(data => {
    //     console.log("Succesfully get Department:", data);
    //     populateSelect('Department', data, $('#department_select')) ;
    // })
    // .catch(err => {
    //     console.error("Error get Department:", err);
    // });

    // getDepartment();
    // getSupplier();
    // getCurrency();
    // getSku();
    // getOtherCost();
    // getDeduction();
}

function populateSelect(title, master_data, element) {
    element.empty();
    element.append('<option value="">-- Select '+title+' --</option>');
    master_data.forEach(data => {
        element.append(`<option value="${data.id}">${data.description}</option>`);
    });
}

function fetchTermsMaster() {
    return new Promise((resolve, reject) => {
        $.ajax({
            type: 'GET',
            url: base_url + 'api/sku-unit',
            success: function (data) {
                termsMaster = data.data;
                resolve(termsMaster);
            },
            error: function (err) {
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
            success: function (data) {
                resolve(data.data);
            },
            error: function (err) {
                console.error("Error fetching supplier master:", err);
                reject(err);
            }
        });
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


// =========== HANDLING ROW ADD ITEMS
let rowCount = 0;
$("#add_row").on("click", function () {
    rowCount++;
    let sku_item
    skuMaster.forEach(data => {
        sku_item += `<option value="`+data.id+`">`+data.prefix+" - "+data.description+`</option>`
    });
    const newRow = `
        <tr>
            <td>${rowCount}</td>
            <td><input type="text" class="form-control" name="description[]" placeholder="Description"></td>
            <td>
                <select name="sku[]" class=form-control item_sku">
                    <option value="">
                        -- Select SKU --
                    </option>
                    `+
                    sku_item
                    +`
                </select>
            </td>
            <td><input type="number" class="form-control" name="price[]" placeholder="Price" step="0.01"></td>
            <td><input type="number" class="form-control" name="qty[]" placeholder="Qty" step="1"></td>
            <td><input type="number" class="form-control" name="sub_total[]" placeholder="Sub Total" step="0.01" readonly></td>
            <td><input type="number" class="form-control" name="discount_percentage[]" placeholder="Discount %" step="0.01"></td>
            <td><input type="number" class="form-control" name="after_discount[]" placeholder="After Discount" step="0.01" readonly></td>
            <td><input type="number" class="form-control" name="vat[]" placeholder="VAT" step="0.01"></td>
            <td><input type="number" class="form-control" name="total[]" placeholder="Total" step="0.01" readonly></td>
            <td><button type="button" class="btn btn-danger btn-sm delete_row">x</button></td>
        </tr>
    `;

    $("#add_table tbody").append(newRow);
});

// Event delegation for deleting rows
$("#add_table").on("click", ".delete_row", function () {
    $(this).closest("tr").remove();
    updateRowNumbers();
});

// Update row numbers after deletion
function updateRowNumbers() {
    rowCount = 0;
    $("#add_table tbody tr").each(function () {
        rowCount++;
        $(this).find("td:first").text(rowCount);
    });
}

// =========== HANDLING ROW ADD OTHER COST
let otherCostRowCount = 0;
$("#add_row_other_cost").on("click", function () {
    otherCostRowCount++;
    const newRow = `
        <tr>
            <td>${otherCostRowCount}</td>
            <td><input type="text" class="form-control" name="description[]" placeholder="Description"></td>
            <td>
                <select name="cost[]" class=form-control item_sku">
                    <option value="">
                        -- Select Cost --
                    </option>
                </select>
            </td>
            <td><input type="number" class="form-control" name="price[]" placeholder="Price" step="0.01"></td>
            <td><input type="number" class="form-control" name="qty[]" placeholder="Qty" step="0.01"></td>
            <td><input type="number" class="form-control" name="total[]" placeholder="Total" step="0.01" readonly></td>
            <td><button type="button" class="btn btn-danger btn-sm delete_row">x</button></td>
        </tr>
    `;

    $("#other_cost_table tbody").append(newRow);
});

// Event delegation for deleting rows
$("#other_cost_table").on("click", ".delete_row", function () {
    $(this).closest("tr").remove();
    othrtCostUpdateRowNumbers();
});

// Update row numbers after deletion
function othrtCostUpdateRowNumbers() {
    otherCostRowCount = 0;
    $("#other_cost_table tbody tr").each(function () {
        otherCostRowCount++;
        $(this).find("td:first").text(otherCostRowCount);
    });
}





});
