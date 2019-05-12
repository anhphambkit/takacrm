(function(window, document, $) {
    'use strict';
    // Remove Card
    $(document).on("click", 'a[data-action="remove"]', function(e) {
        $(this).closest('.card').remove().slideUp('fast');
    });

    // Close Card
    $(document).on("click", 'a[data-action="close"]', function(e) {
        $(this).closest('.card').removeClass().slideUp('fast');
    });

    // Toggle fullscreen
    $(document).on("click", 'a[data-action="expand"]', function(e) {
        e.preventDefault();
        $(this).closest('.card').find('[data-action="expand"] i').toggleClass('ft-maximize ft-minimize');
        $(this).closest('.card').toggleClass('card-fullscreen');
    });

    // Reload Card
    $(document).on("click", 'a[data-action="reload"]', function(e) {
        var block_ele = $(this).closest('.card');

        // Block Element
        block_ele.block({
            message: '<div class="ft-refresh-cw icon-spin font-medium-2"></div>',
            timeout: 2000, //unblock after 2 seconds
            overlayCSS: {
                backgroundColor: '#FFF',
                cursor: 'wait',
            },
            css: {
                border: 0,
                padding: 0,
                backgroundColor: 'none'
            }
        });
    });

    // Collapsible Card
    $(document).on("click", 'a[data-action="collapse"]', function(e) {
        e.preventDefault();
        $(this).closest('.card').children('.card-content').collapse('toggle');
        $(this).closest('.card').find('[data-action="collapse"] i').toggleClass('ft-minus ft-plus');
    });

})(window, document, jQuery);
