<script>
$(document).ready(function() {

    function loadData(q = '', type = 2, date = '', pageUrl = null) {
        let baseUrl = "{{ url('transaction/inventory/stock_opening/data') }}";
        let finalUrl = pageUrl ? pageUrl : `${baseUrl}?q=${encodeURIComponent(q)}&type=${type}&date=${date}`;

        $('#data').html('<div class="text-center py-3"><small>Loading...</small></div>');
        $('#data').load(finalUrl, function(response, status) {
            if (status === "error") {
                $('#data').html('<div class="alert alert-danger">Gagal memuat data.</div>');
            }
        });
    }

    // Load awal
    loadData();

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

});
</script>
