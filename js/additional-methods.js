(function($) {
    // Custom email validation method
    $.validator.addMethod("emailValidation", function(value, element) {
        return this.optional(element) || /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/.test(value);
    }, "Please enter a valid email address.");

    // Custom phone number validation method
    $.validator.addMethod("phoneValidation", function(value, element) {
        return this.optional(element) || /^\d{10}$/.test(value); // 10-digit phone number
    }, "Please enter a valid phone number.");

    // Add other custom validation methods here
})(jQuery);
