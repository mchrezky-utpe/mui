<script>
    $(document).ready(function() {

        function loadData(q = '', type = null, date = '', pageUrl = null) {

            if (!type) {
                type = $('input[name="type"]:checked').val();
            }

            let baseUrl = "{{ url('transaction/inventory/stock_opening/data') }}";
            let finalUrl = pageUrl ?
                pageUrl :
                `${baseUrl}?q=${encodeURIComponent(q)}&type=${type}&date=${date}`;

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
                type: $('input[name="type"]:checked').val(),
                date: $('#date').val()
            };
        }

        let filter = getCurrentFilter();
        loadData(filter.q, filter.type, filter.date);

        // Event: Search
        let typingTimer;
        $('#search').on('keyup', function() {
            clearTimeout(typingTimer);
            let q = $(this).val();
            let type = $('input[name="type"]:checked').val();
            let date = $('#date').val();
            typingTimer = setTimeout(() => loadData(q, type, date), 400);
        });

        // Event: Ganti kategori
        $('input[name="type"]').on('change', function() {
            let type = $(this).val();
            let q = $('#search').val();
            let date = $('#date').val();
            loadData(q, type, date);
        });

        // Event: Ganti tanggal
        $('#date').on('change', function() {
            let date = $(this).val();
            let q = $('#search').val();
            let type = $('input[name="type"]:checked').val();
            loadData(q, type, date);
        });

        // Event: Klik pagination
        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            let pageUrl = $(this).attr('href');
            let q = $('#search').val();
            let type = $('input[name="type"]:checked').val();
            let date = $('#date').val();

            if (pageUrl.includes('?')) {
                pageUrl += `&q=${encodeURIComponent(q)}&type=${type}&date=${date}`;
            } else {
                pageUrl += `?q=${encodeURIComponent(q)}&type=${type}&date=${date}`;
            }

            loadData(q, type, date, pageUrl);
        });

        // Klik row
        $(document).on('click', '.row-item', function() {

            let id = $(this).data('id');
            let isOpening = $(this).data('opening');

            if (isOpening == 1) {

                Swal.fire({
                    icon: 'info',
                    title: 'Already Opening',
                    text: 'Item already has opening stock.',
                });

            } else {

                $('#sku_id').val(id);
                $('#qty').val('');
                $('#modalOpening').modal('show');
            }
        });

        $('#btnSubmitOpening').on('click', function() {

            let sku_id = $('#sku_id').val();
            let qty = $('#qty').val();

            if (!qty || qty <= 0) {
                Swal.fire('Warning', 'Qty must be greater than 0', 'warning');
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
                url: "{{ url('transaction/inventory/stock_opening/opening_stock') }}",
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
                        text: 'Opening stock saved successfully'
                    });

                    $('#modalOpening').modal('hide');

                    let filter = getCurrentFilter();
                    loadData(filter.q, filter.type, filter.date);
                },
                error: function(err) {

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to save opening stock'
                    });
                }
            });

        });

    });
</script>