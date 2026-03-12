<script>
    $(document).ready(function() {

        function loadData(q = '', type = null, date = '', pageUrl = null) {

            if (!type) {
                type = $('input[name="type"]:checked').val();
            }

            let baseUrl = "{{ url('transaction/inventory/stock_adjusment/data') }}";
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

            if (isOpening == 0) {

                Swal.fire({
                    icon: 'info',
                    title: 'No Opening Stock',
                    text: 'This item has not been opened yet.',
                });

            } else {

                $('#sku_id').val(id);
                $('#qty').val('');
                $('#modalAdjusment').modal('show');
            }
        });

        $('#btnSubmitAdjusment').on('click', function() {

            let sku_id = $('#sku_id').val();
            let qty = $('#qty').val();

            // hanya boleh angka atau minus di depan
            let regex = /^-?\d+$/;

            if (!regex.test(qty)) {
                Swal.fire('Warning', 'Invalid qty format', 'warning');
                return;
            }

            qty = parseInt(qty);

            Swal.fire({
                title: 'Processing...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: "{{ url('transaction/inventory/stock_adjusment/adjusment_stock') }}",
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
                        text: res.message
                    });

                    $('#modalAdjusment').modal('hide');

                    let filter = getCurrentFilter();
                    loadData(filter.q, filter.type, filter.date);
                },
                error: function(err) {

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: err.responseJSON?.message ?? 'Failed to save adjustment stock'
                    });
                }
            });

        });

        $('#btnImportExcel').on('click', function() {

            let file = $('#file_excel')[0].files[0];

            if (!file) {
                Swal.fire('Warning', 'Please select file first', 'warning');
                return;
            }

            let formData = new FormData();
            formData.append('_token', "{{ csrf_token() }}");
            formData.append('file', file);

            Swal.fire({
                title: 'Importing...',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            $.ajax({
                url: "{{ url('transaction/inventory/stock_adjusment/import_adjusment_stock') }}",
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {

                    $('#modalImportExcel').modal('hide');

                    setTimeout(() => {
                        $('.modal-backdrop').remove();
                        $('body').removeClass('modal-open');
                        $('body').css('padding-right', '');

                        if (res.errors && res.errors.length > 0) {

                            Swal.fire({
                                icon: 'warning',
                                title: 'Import Completed with Errors',
                                html: res.message + '<br><br>' + res.errors.join('<br>')
                            });

                        } else {

                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: res.message
                            });

                        }

                    }, 300);

                    let filter = getCurrentFilter();
                    loadData(filter.q, filter.type, filter.date);
                },
                error: function(err) {

                    Swal.fire('Error', err.responseJSON?.message || 'Import failed', 'error');
                }
            });
        });


    });
</script>