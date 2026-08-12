<script>
    $(function () {
        $('#medStockForm').validate({
            rules: {
                medicine: {
                    required: true,
                },
            },
            messages: {
                medicine: {
                    required: "Please Select Medicine",
                },
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.col-md-3').append(error);        
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            },
        });
    });
</script>