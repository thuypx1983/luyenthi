(function ($) {
    $(function () {
        $('.region-header >div.block').matchHeight({
            byRow: true,
            property: 'height',
            target: null,
            remove: false
        });
    })
})(jQuery)