<script>
    $(document).ready(function() {

        function loadData(q = '', type = null, pageUrl = null) {

            if (!type) {
                type = $('input[name="type"]:checked').val();
            }

            let baseUrl = "{{ url('transaction/inventory/minimum_stock/data') }}";
            let finalUrl = pageUrl ?
                pageUrl :
                `${baseUrl}?q=${encodeURIComponent(q)}&type=${type}`;

            $('#data').html('<div class="text-center py-3"><small>Loading...</small></div>');

            $('#data').load(finalUrl, function(response, status) {
                if (status === "error") {
                    $('#data').html('<div class="alert alert-danger">Gagal memuat data.</div>');
                }
            });
        }

        function getCurrentFilter() {
            return {
                q: $('#search').val(),
                type: $('input[name="type"]:checked').val()
            };
        }

        let filter = getCurrentFilter();
        loadData(filter.q, filter.type);

        // Event: Search
        let typingTimer;
        $('#search').on('keyup', function() {
            clearTimeout(typingTimer);
            let q = $(this).val();
            let type = $('input[name="type"]:checked').val();
            typingTimer = setTimeout(() => loadData(q, type), 400);
        });

        // Event: Ganti kategori
        $('input[name="type"]').on('change', function() {
            let type = $(this).val();
            let q = $('#search').val();
            loadData(q, type);
        });

        // Event: Klik pagination
        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            let pageUrl = $(this).attr('href');
            let q = $('#search').val();
            let type = $('input[name="type"]:checked').val();

            if (pageUrl.includes('?')) {
                pageUrl += `&q=${encodeURIComponent(q)}&type=${type}`;
            } else {
                pageUrl += `?q=${encodeURIComponent(q)}&type=${type}`;
            }

            loadData(q, type, pageUrl);
        });

        // Klik row
        $(document).on('click', '.row-item', function() {

            let id = $(this).data('id');
            let isOpening = $(this).data('opening');

            // if (isOpening == 1) {

            //     Swal.fire({
            //         icon: 'info',
            //         title: 'Already Opening',
            //         text: 'Item already has opening stock.',
            //     });

            // } else {

            $('#sku_id').val(id);
            $('#qty').val('');
            $('#modalMinimum').modal('show');
            // }
        });

        $('#btnSubmitMinimum').on('click', function() {

            let sku_id = $('#sku_id').val();
            let qty = $('#qty').val();

            if (!qty || qty < 0) {
                Swal.fire('Warning', 'Qty cannot be less than 0', 'warning');
                return;
            }

            Swal.fire({
                title: 'Processing...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: "{{ url('transaction/inventory/minimum_stock/minimum_stock') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    sku_id: sku_id,
                    qty: qty
                },
                success: function(res) {

                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Minimum stock saved successfully'
                    });

                    $('#modalMinimum').modal('hide');

                    let filter = getCurrentFilter();
                    loadData(filter.q, filter.type);
                },
                error: function(err) {

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to save minimum stock'
                    });
                }
            });

        });

    });
</script>