<script>
    $(document).ready(function() {
        // Fetch medicines when the page loads
        $.ajax({
            url: "{{ route('getStockMedicines') }}",
            type: "GET",
            success: function(data) {
                let dropdown = $('#medicine-dropdown');
                data.forEach(function(medicine) {
                    dropdown.append(
                        $('<option>', {
                            value: medicine.id,
                            text: medicine.medicine
                        })
                    );
                });
            },
            error: function(err) {
                console.log('Error fetching medicines:', err);
            }
        });
    });
</script>