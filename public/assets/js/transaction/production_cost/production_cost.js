 function getStatus(validTo) {
        const today = new Date();
        const validDate = new Date(validTo);
        return today > validDate ? 'OUT OF DATE' : 'ACTIVE';
    }


$(document).on("click", ".detail", function (e) {
    var id = this.dataset.id;
    $.ajax({
        type: "GET",
        url: base_url + "production_cost/" + id,
        success: function (data) {
            var data = data.data;
 
            let html = '';
        
            data.forEach(function(item) {
                html += `
                    <tr>
                        <td>${item.process_type}</td>
                        <td>${item.procurement_type}</td>
                        <td class="text-right">${item.val_material_cost}</td>
                        <td class="text-right">${item.val_process_cost}</td>
                        <td class="text-right">${item.val_production_cost}</td>
                        <td>${item.valid_date_from}</td>
                        <td>${item.valid_date_to}</td>
                        <td><span class="badge ${getStatus(item.valid_date_to) === 'OUT OF DATE' ? 'badge-danger' : 'badge-success'}">${getStatus(item.valid_date_to)}</span></td>
                    </tr>
                `;
            });

            $('#production_cost_detail_table tbody').html(html);
          

            $("#detail_modal").modal("show");
        },
        error: function (err) {
            debugger;
        },
    });
});

initParam() 
    function initParam() {
        fetchSkuModel()
            .then((data) => {
                console.log("Succesfully get Sku:", data);
                populateSelect("Model", data, $("[name=sku_model]"));
            })
            .catch((err) => {
                console.error("Error get Sku Model:", err);
            });
    }
    
    function fetchSkuModel() {
        return new Promise((resolve, reject) => {
            $.ajax({
                type: "GET",
                url: base_url + "api/sku-model/droplist",
                success: function (data) {
                    resolve(data.data);
                },
                error: function (err) {
                    console.error("Error fetching sku model master:", err);
                    reject(err);
                },
            });
        });
    }


    function populateSelect(title, master_data, element) {
        element.empty();
        element.append('<option value="">-- Select ' + title + " --</option>");
        master_data.forEach((data) => {
            element.append(
                `<option unit="${data.description}" value="${data.id}">${data.description}</option>`
            );
        });
    }


    $(document).on('change', '.status-switch', function() {
        const id = $(this).data('id');
        const isActive = $(this).prop('checked') ? 1 : 0;
        
        const csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content");
        
        $.ajax({
            url: '/production_cost/active_deactive',
            method: 'POST',
            data: {
                id: id,
                status: isActive,
                _token: csrfToken
            },
            success: function(response) {
                console.log('Status updated successfully');
            },
            error: function(xhr) {
                console.log('Status updated successfully'+ xhr);
            }
        });
    });


    

