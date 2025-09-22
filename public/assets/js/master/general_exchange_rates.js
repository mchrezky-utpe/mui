$(document).on('click', '.edit', function (e) {
    var id = this.dataset.id;
    $.ajax({
        type: 'GET',
        url: base_url + 'general-exchange-rates/' + id,
        success: function (data) {
            var data = data.data;

            $('[name=id]').val(data.id);
            $('[name=date]').val(data.valid_from_date);
            $('[name=gen_currency_id]').val(data.gen_currency_id);
            $('[name=val_exchangerates]').val(data.val_exchangerates);

            $('#edit_modal').modal('show');

        },
        error: function (err) {
            debugger;
        }
    });
});




fetchCurrencyMaster()
        .then((data) => {
            console.log("Succesfully get Department:", data);
            populateSelectCurrency("Currency", data, $("[name=gen_currency_id]"));
            $(".currency_select").val(65).change();
        })
        .catch((err) => {
            console.error("Error get Currency:", err);
        });

function fetchCurrencyMaster() {
return new Promise((resolve, reject) => {
        $.ajax({
            type: "GET",
            url: base_url + "api/general-currency",
            success: function (data) {
                resolve(data.data);
            },
            error: function (err) {
                console.error("Error fetching currency master:", err);
                reject(err);
            },
        });
    });
}

  
function populateSelectCurrency(title, master_data, element) {
  element.empty();
  element.append('<option value="">-- Select '+title+' --</option>');
  master_data.forEach(data => {
      element.append(`<option value="${data.id}">${data.prefix}</option>`);
  });
}