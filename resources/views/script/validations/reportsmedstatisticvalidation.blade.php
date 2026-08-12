<script>
    $(function () {
        $('#medStatisticForm').validate({
            rules: {
                reporting_period: {
                    required: true,
                },
                
            },
            messages: {
                reporting_period: {
                    required: "Please Select Reporting Period",
                },
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.col-md-2').append(error);        
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