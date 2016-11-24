/**
 * @contact-form-name: General form
 *
 * ----- Table of contents -------------------------------------
 *
 * 1. Define variables
 * 2. Include custom form methods from methods.js
 * 3. Add the validation rules
 * */

function generalEnquiriesForm(){
    /**
     * 1. Declare variables
     * */
    var formName = "#general";
    var form = $(formName);

    /**
     * 2. Included custom form validation methods from methods.js
     * */
    formMethods();

    /**
     * 3. Add the validation rules
     * */
    form.validate({
        errorElement: 'span',
        errorClass: 'form-error form-hint',
        highlight: function(element, errorClass, validClass) {
            $(element).closest('input[type="text"]').addClass("form-warning");
            $(element).closest('input[type="email"]').addClass("form-warning");
            $(element).closest('textarea').addClass("form-warning");
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).closest('input[type="text"]').removeClass("form-warning");
            $(element).closest('input[type="email"]').removeClass("form-warning");
            $(element).closest('textarea').removeClass("form-warning");
        },
        rules: {
            "full-name": {
                required: true,
                noSpace: true
            },
            email: {
                required: true,
                email:true,
                advEmail:true
            },
            "confirm-email": {
                equalTo: "#email"
            },
            country:{
                required:true,
                noSpace:true
            },
            reason:{
                required:true,
                noSpace:true
            },
            enquiry:{
                required:true,
                noSpace:true
            }

        },
        /**
         * Error messages
         * */
        messages: {
            "full-name": {
                required: "Please enter your first name"
            },
            email: "Please enter your email address",
            "confirm-email": {
                required:"Please enter your email address",
                equalTo: "Please enter your email address again"
            },
            country:{
                required:"Please enter your country"
            },
            reason:{
                required:"Please select an option"
            },
            enquiry:{
                required:"Please enter your enquiry"
            }
        }
    });
}