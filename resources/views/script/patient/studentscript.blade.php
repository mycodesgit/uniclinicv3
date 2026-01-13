<script>
    $(document).ready(function() {
        $('.update-field').on('change', function() {
            var elementType = $(this).prop('tagName').toLowerCase();
            if (elementType === 'input' || elementType === 'textarea') {
                columnid = $(this).data('column-id');
                columnname = $(this).data('column-name');
            } else if (elementType === 'select') {
                columnid = $(this).find('option:selected').data('column-id');
                columnname = $(this).find('option:selected').data('column-name');
            }

            var value = $(this).val();

            $.ajax({
                url: '{{ route("patients.update") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: columnid,
                    column: columnname,
                    value: value
                },
                success: function(response) {
                    
                },
                error: function(xhr, status, error) {
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        console.error('Validation errors:', errors);
                    } else {
                        console.error('Error:', error);
                    }
                }
            });
        });
    });
</script>