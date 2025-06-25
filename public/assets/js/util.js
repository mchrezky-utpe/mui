
    $('.closeParentModalButton').click(function() {
      // Cari parent element dengan class .modal dan sembunyikan
      $(this).closest('.modal').modal('hide');
    });


// common button submit
$(document).on('click', '.btn_submit_modal', function (e) {
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

    $form.submit();
});


$('#add_button , .add_modal').click(function() {
    $("input[type=text], textarea, select").not("[name=manual_id], [name=gen_currency_id], [name=doc_number] [name=group_tag]").val("");
    $("input[type=checkbox]").prop('checked', false);
});

$(function() {
    let table = new DataTable('.data-table');

    // $('#example-table-fixed-column-scrollx').DataTable({
    //     scrollY: "800px",
    //     scrollX: true,
    //     scrollCollapse: true,
    //     paging: true,
    //     fixedColumns: {
    //         leftColumns: 3,
    //         rightColumns: 3
    //     }
    // });
});

function formatMoney(value) {
    return accounting.formatMoney(value, "", 0);
}

function unformatMoney(value) {
    return accounting.unformat(value);
}

function deleteDelimiterMultipleInput(parent, input){
$(parent).find(input).each(function(){
    var price = $(this).val();
    $(this).val(accounting.unformat(price));
});
}