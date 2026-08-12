<script>
    $(function () {
        $('#medForm').validate({
            rules: {
                month: {
                    required: true,
                },
            },
            messages: {
                month: {
                    required: "Please Select Month",
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