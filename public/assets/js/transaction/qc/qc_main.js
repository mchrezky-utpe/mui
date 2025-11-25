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


    $(document).on('click', '#table-qc-check tbody tr', function() {

        // Remove selected class dari semua row
        $('#table-qc-check tbody tr').removeClass('selected');

        // Add selected class ke row yang diklik
        $(this).addClass('selected');

        // Load detail produk
        $('#entry_qcc_modal').modal('show');
        console.log("click")
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