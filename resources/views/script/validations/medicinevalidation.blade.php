<script>
    $(function () {
        $('#medicineForm').validate({
            rules: {
                category: {
                    required: true,
                },
                medicine: {
                    required: true,
                },
                qty: {
                    required: true,
                },
                measure: {
                    required: true,
                },
                lotno: {
                    required: true,
                },
                expirydate: {
                    required: true,
                },
                refnoid: {
                    required: true,
                },
            },
            messages: {
                category: {
                    required: "Please Enter Category",
                },
                medicine: {
                    required: "Please Enter Medicine Name",
                },
                qty: {
                    required: "Please Enter Quantity",
                },
                measure: {
                    required: "Please Enter Unit Measure",
                },
                lotno: {
                    required: "Please Enter Lot No.",
                },
                expirydate: {
                    required: "Please Select Expiry Date",
                },
                refnoid: {
                    required: "Please Enter Reference ID",
                },
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.col-md-12').append(error);        
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