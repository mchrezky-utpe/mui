$(document).on('change', '[name=date]', function() {
    var selectedDate = $(this).val(); 

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    $.ajax({
        url: base_url + 'api/stock-view/sync', 
        type: "POST",
        data: {
            _token: csrfToken,
            date: selectedDate 
        }, 
        async: false, 
        success: function(response) {
            $('#table_stock_view').DataTable().ajax.reload(null, false); // false untuk mempertahankan paging
        },
        error: function(xhr, status, error) {
            console.error("Terjadi kesalahan: " + error);
        }
    });
});


$('#table_stock_view').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: base_url + 'api/stock-view',
        type: "GET",
        data: function(d) {
            d.date = $('input[name="date"]').val();
        }
    },
    order: [
        [3, 'desc'],
        [2, 'desc']
    ],
    columns: [
            {
                data: "report_date"
            },
            {
                    data: "item_code"
                },
                {
                    data: "group_code"
                },
                {
                    data: "item_name"
                },
                {
                    data: "specification_code"
                },
                {
                    data: "item_type"
                },
                {
                    data: "item_classification"
                },
                {
                    data: "sales_category"
                },
                {
                    data: "unit"
                },
                {
                    data: "warehouse"
                },
                {
                    data: "supplier"
                },
                {
                    data: "min"
                },
                {
                    data: "max"
                },
                {
                    data: "msr"
                }
    ]
});

$('[name=date]').change();


// {
//     data: "specification_code"
// },