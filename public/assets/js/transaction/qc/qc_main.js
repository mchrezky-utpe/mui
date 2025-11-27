$(document).ready(function() {

    $('[name=search]').on('keydown', function(event) {

     if (event.key === 'Enter' || event.keyCode === 13) {
        event.preventDefault();
        const startdate = $("#start_date").val();
        const endDate = $("#end_date").val();
        const checking_type = $("[name=checking_type]").val();
        if(startdate == "" || endDate == ""){
            alert("Please select date");
            return;
        }

        if(checking_type  == ""){
            alert("Please select checking type");
            return;
        }
        
        fetchDataQcCheck(startdate, endDate, checking_type)
            .then(data => {
                console.log("Succesfully get data qc check:", data);
                $("#table-qc-check tbody").empty();
                for (let index = 0; index < data.length; index++) {
                    const item = data[index];
                    const newRow =
                        `<tr data-id="${item.id}">
                            <td>
                                ${item.trans_date}
                            </td>
                            <td>
                                ${item.po_doc_num}
                            </td>
                            <td>
                                ${item.do_doc_num}
                            </td>
                            <td>
                                ${item.sku_prefix}
                            </td>
                            <td>
                                ${item.sku_description}
                            </td>
                            <td>
                                ${item.sku_type}
                            </td>
                            <td>
                                ${item.sku_inventory_unit}
                            </td>
                            <td>
                                ${item.qty}
                            </td>
                            <td>
                                ${item.qty_os}
                            </td>
                        </tr>`;

                    $("#table-qc-check tbody").append(newRow);
                }

            }).catch(err => {
                console.error("Error get qc check:", err);
            });
        }
    });

    // Event delegation untuk menu item
    $(document).on('click', '.menu-item', function() {
        $('.menu-item').removeClass('active');
        $(this).addClass('active');
    });

    // BUTTON SELECT ROW
    $(document).on('click', '#table-qc-check tbody tr', function() {

        // Remove selected class dari semua row
        $('#table-qc-check tbody tr').removeClass('selected');

        // Add selected class ke row yang diklik
        $(this).addClass('selected');

        // var data =  $(this).find('td');
        const id = $(this).data().id;
        $('#item_id').val(id);

        
        var row = $('#table-qc-check tbody tr[data-id="' + id + '"]');
        var cells = row.find('td');
        var qty_rcv = $(cells[7]).text().trim();
        $('[name=qty_rcv]').val(qty_rcv);

        // Load detail produk
        $('#entry_qcc_modal').modal('show');
        console.log("click")
    });

    // BUTTON OK IN MODAL
    $(document).on('click', '#btn_entry_qcc', function(e) {

        e.preventDefault();
        
            let $modal = $(this).closest('.modal');
            let $form = $modal.find('form');
            let isValid = true;

            $form.find('.error-message').remove(); 
            $form.find('.is-invalid').removeClass('is-invalid');

            $form.find('[required]').each(function () {
                if (!$(this).val() || $(this).val().trim() === '') {
                    isValid = false;
                    $(this).addClass('is-invalid'); // Tambahkan kelas untuk styling error
                    $(this).after('<span class="error-message" style="color: red; font-size: 12px;">This field is required.</span>');
                }
            });
            if (typeof is_using_item !== 'undefined' && is_using_item == true){
            let item_table_id = $('#item_table');
                if (item_table_id.length > 0) {
                    let tableRowCount = item_table_id.find('tbody tr').length;
                    if (tableRowCount === 0) {
                        isValid = false;
                        item_table_id.after('<span class="error-message" style="color: red; font-size: 12px;">The item table cannot be empty.</span>');
                    }
                }
            }
            
            if (!isValid) {
                return false;
            }

            // process DATA
            var targetId = $('#item_id').val(); // atau ambil dari input/parameter lain
    
            // Cari row dengan data-id tertentu
            var row = $('#table-qc-check tbody tr[data-id="' + targetId + '"]');
            
            if (row.length > 0) {
                var cells = row.find('td');
                var rcvDate = $(cells[0]).text().trim();
                var poDocNum = $(cells[1]).text().trim();
                var doDocNum = $(cells[2]).text().trim();
                var itemCode = $(cells[3]).text().trim();
                var itemName = $(cells[4]).text().trim();
                var itemType = $(cells[5]).text().trim();
                var itemUnit = $(cells[6]).text().trim();
                var qty =  $('[name=qty_rcv]').val();
                
                console.log("Data untuk ID", targetId, ":", {
                    rcvDate: rcvDate,
                    poDocNum: poDocNum,
                    doDocNum: doDocNum,
                    itemCode: itemCode,
                    itemName: itemName,
                    itemUnit: itemUnit,
                    qty: qty
                });
                
                 const newRow =
                        `<tr data-id="${targetId}">
                            <td>
                                ${itemCode}
                            </td>
                            <td>
                                ${itemName}
                            </td>
                            <td>
                                ${itemType}
                            </td>
                            <td>
                                ${itemUnit}
                            </td>
                            <td>
                                ${qty}
                            </td>
                            <td>
                               0
                            </td>
                            <td>
                               0
                            </td>
                            <td>
                               0
                            </td>
                            <td>
                                0
                            </td>
                            <td>
                                0
                            </td>
                            <td style="background-color:red">
                                
                            </td>
                        </tr>`;

                    $("#table-qc-check-process tbody").append(newRow);

                $('#entry_qcc_modal').modal('hide');
                // Tampilkan modal
                // showModalWithData(targetId, docNum, supplier, poDate, poType, description);
            } else {
                alert('Data dengan ID ' + targetId + ' tidak ditemukan!');
            }
    });


});



function fetchDataQcCheck(startdate, endDate, checking_type) {
    return new Promise((resolve, reject) => {
        $.ajax({
            type: "GET",
            url: base_url + `qc/check/get?startDate=${startdate}&endDate=${endDate}&checking_type=${checking_type}`,
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