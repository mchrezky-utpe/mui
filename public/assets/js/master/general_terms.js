
$(document).on('click','#add_button',function(){
    $('.detail_table tbody').empty();
});

$(document).on('click', '.edit', function (e) {
    var id = this.dataset.id;
    $.ajax({
        type: 'GET',
        url: base_url + 'general-terms/' + id,
        success: function (data) {

            var data = data.data;

            $('[name=id]').val(data.id);
            $('[name=manual_id]').val(data.manual_id);
            $('[name=description]').val(data.description);

            $('.detail_table tbody').empty();
            detailRowCount = 0 ;
            for (let index = 0; index < data.details.length; index++) {
                detailRowCount++;
                const newRow = `
                    <tr>
                        <td>${detailRowCount}</td>
                        <td>
                        <input value="${data.details[index].id}" type="hidden" class="form-control" name="detail_id[]">
                        <input value="`+data.details[index].description+`" type="text" class="form-control" name="description_detail[]" placeholder="Description">
                        </td>
                        <td><button type="button" class="btn btn-danger btn-sm delete_row">x</button></td>
                    </tr>
                `;
        
                $(".detail_table tbody").append(newRow);  
            }

            $('#edit_modal').modal('show');

        },
        error: function (err) {
            debugger;
        }
    });

});



    // =========== HANDLING ROW ADD DETAIL
	let detailRowCount = 0;
	$(".add_row_detail").on("click", function() {
		detailRowCount++;
		const newRow = `
            <tr>
                <td>${detailRowCount}</td>
                <td>
                    <input type="hidden" class="form-control" name="detail_id[]">
                    <input type="text" class="form-control" name="description_detail[]" placeholder="Description">
                </td>
                <td><button type="button" class="btn btn-danger btn-sm delete_row">x</button></td>
            </tr>
        `;

		$("#detail_table tbody").append(newRow);
	});
    
    	// Event delegation for deleting rows
	$(".detail_table").on("click", ".delete_row", function() {
		$(this).closest("tr").remove();
		detailUpdateRowNumbers();
	});

    	// Update row numbers after deletion
	function detailUpdateRowNumbers() {
		detailRowCount = 0;
		$(".detail_table tbody tr").each(function() {
			detailRowCount++;
			$(this).find("td:first").text(detailRowCount);
		});
	}


