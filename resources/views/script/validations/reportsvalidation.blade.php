<script>
    $(function () {
        $('#walkinreps').validate({
            rules: {
                category: {
                    required: true,
                },
                pcat: {
                    required: true,
                },
                monthly: {
                    required: true,
                },
                date: {
                    required: true,
                },
            },
            messages: {
                category: {
                    required: "Please Select Category",
                },
                pcat: {
                    required: "Please Select Patient Category",
                },
                monthly: {
                    required: "Please Select Month",
                },
                date: {
                    required: "Please Select Date",
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