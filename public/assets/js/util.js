
$('.btn_submit_modal').click(function() {
    $(this).closest('.modal').find('form').submit();
}); 

$('#add_button').click(function() {
    $("input[type=text], textarea, select").val("");
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