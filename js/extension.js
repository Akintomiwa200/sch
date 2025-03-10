// Example of extending jQuery to add custom methods or plugins
(function($) {
    // Example of adding a custom method to toggle visibility of elements
    $.fn.toggleVisibility = function() {
        return this.each(function() {
            var $this = $(this);
            $this.css('display', $this.css('display') === 'none' ? 'block' : 'none');
        });
    };

    // Example of adding a method to format a number as currency
    $.fn.formatCurrency = function() {
        return this.each(function() {
            var $this = $(this);
            var value = parseFloat($this.text()).toFixed(2);
            $this.text('$' + value.replace(/\d(?=(\d{3})+\.)/g, '$&,'));
        });
    };

})(jQuery);
