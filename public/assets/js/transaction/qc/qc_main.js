$(document).ready(function() {

    $(document).on('input', '.item_ng', function() {
        const qty_ng = sumNgQuantities();
        const qty_receiving = $('#qty_receiving').val();
        const qty_check = $('#qty_receiving').val();
        const ppm =  (qty_ng/qty_check) * 1000000;
        const qty_percentage =  (qty_ng/qty_check) * 100;
        $('#qty_ng').val(qty_ng);
        $('#td_qty_good').text(qty_receiving-qty_ng);
        $('#td_qty_ng').text(qty_ng);
        $('#td_qty_percentage').text(qty_percentage);
        $('#td_ppm').text(ppm);
    });

    function sumNgQuantities() {
        let totalSum = 0;
        $('.item_ng').each(function() {
            // Get the text content and convert it to a number
            totalSum += Number($(this).val());
        });
        return totalSum;
    }

    $('[name=search]').on('keydown', function(event) {

     if (event.key === 'Enter' || event.keyCode === 13) {
        event.preventDefault();
        const startdate = $("#start_date").val();
        const endDate = $("#end_date").val();
        const checking_type = $("[name=flag_checking_type]").val();
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
                        `<tr data-id="${item.id}" data-trans_po_id="${item.trans_po_id}" data-trans_rr_detail_id="${item.trans_rr_detail_id}">
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
        const trans_po_id = $(this).data().trans_po_id;
        const trans_rr_detail_id = $(this).data().trans_rr_detail_id;
        $('#item_id').val(id);
        $('#trans_po_id').val(trans_po_id);
        $('#trans_rr_detail_id').val(trans_rr_detail_id);

        
        var row = $('#table-qc-check tbody tr[data-id="' + id + '"]');
        var cells = row.find('td');
        var qty_rcv = $(cells[7]).text().trim();
        $('[name=qty_receiving]').val(qty_rcv);

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
                var qty =  $('[name=qty_check]').val();
                var qty_rework =  $('[name=qty_rework]').val();
                
                console.log("Data untuk ID", targetId, ":", {
                    rcvDate: rcvDate,
                    poDocNum: poDocNum,
                    doDocNum: doDocNum,
                    itemCode: itemCode,
                    itemName: itemName,
                    itemUnit: itemUnit,
                    qty: qty,
                    qty_rework: qty_rework
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
                            <td id="td_qty_good">
                               0
                            </td>
                            <td id="td_qty_ng">
                               0
                            </td>
                            <td>
                               ${qty_rework}
                            </td>
                            <td id="td_qty_percentage">
                                0
                            </td>
                            <td id="td_ppm">
                                0
                            </td>
                            <td style="background-color:red">
                                
                            </td>
                        </tr>`;

                    $("#table-qc-check-process tbody").append(newRow);

                $('#entry_qcc_modal').modal('hide');
                // Tampilkan modal
                // showModalWithData(targetId, docNum, supplier, poDate, poType, description);
                  $('#hiddenFields').empty();

                    $('#form_modal').find('input, select, textarea').each(function() {
                        var element = $(this);
                        var name = element.attr('name');
                        var id = element.attr('id');
                        var label = $('label[for="' + id + '"]').text() || name;
                        var value = '';
                        
                        // Ambil nilai berdasarkan tipe
                        if (element.is('input[type="checkbox"]')) {
                            value = element.is(':checked') ? element.val() : '';
                        } else if (element.is('input[type="radio"]')) {
                            if (element.is(':checked')) {
                                value = element.val();
                            }
                        } else{
                            value = element.val();
                        }
                        
                        // Tampilkan di preview
                        if (name && value) {
                            // Buat hidden input untuk form submit
                            var hiddenInput = '<input type="hidden" name="' + name + '" value="' + value + '">';
                            $('#hiddenFields').append(hiddenInput);
                        }
                    });
                    

            } else {
                alert('Data dengan ID ' + targetId + ' tidak ditemukan!');
            }
    });

    $(document).on('change', '[name=sampling]', function(e) {
        
        const sampling = $(this).val();
        const qty_receiving = $('[name=qty_receiving]').val();
        let qty_check = 0;
        if(sampling == 'no'){
            qty_check = qty_receiving;
        }else{
          qty_check = calculateSamplingNormalOrTighten(qty_receiving);
        }
        $('[name=qty_check]').val(qty_check);
    });

    function calculateSamplingNormalOrTighten(qty_receiving){
        if(isNumberInRange(qty_receiving,2,8)){
            return 2;
        }else if(isNumberInRange(qty_receiving,9,15)){
            return 3;
        }else  if(isNumberInRange(qty_receiving,16,25)){
            return 5;
        }else  if(isNumberInRange(qty_receiving,26,51)){
            return 8;
        }else  if(isNumberInRange(qty_receiving,52,90)){
            return 13;
        }else  if(isNumberInRange(qty_receiving,91,150)){
            return 20;
        }else  if(isNumberInRange(qty_receiving,151,280)){
            return 32;
        }else  if(isNumberInRange(qty_receiving,281,500)){
            return 50;
        }else  if(isNumberInRange(qty_receiving,501,1200)){
            return 80;
        }else  if(isNumberInRange(qty_receiving,1201,3200)){
            return 125;
        }else  if(isNumberInRange(qty_receiving,3201,10000)){
            return 200;
        }else  if(isNumberInRange(qty_receiving,10001,35000)){
            return 315;
        }else  if(isNumberInRange(qty_receiving,35001,15000)){
            return 500;
        }else  if(isNumberInRange(qty_receiving,150001,500000)){
            return 800;
        }else  if(qty_receiving > 500000){
            return 1250;
        }else{
            return qty_receiving;
        }
    }

    function isNumberInRange(value, min, max) {
        return value >= min && value <= max;
    }

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