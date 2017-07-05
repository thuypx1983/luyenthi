(function ($) {
    var oms={

        /**
         * Init match height
         */
        initMatchHeight: function (){
            $('.region-header >div.block,.contact-us-info>div.col-md-4,#block-block-14 .col-md-6').matchHeight({
                byRow: true,
                property: 'height',
                target: null,
                remove: false
            });
        },

        /**
         * Init quicktab
         */
        initQuickTabExams: function(){
            var title=$('#quicktabs-tabpage-thi_thu_ptth_quoc_gia-2').find('.views-field-title');
            $('#quicktabs-tab-thi_thu_ptth_quoc_gia-2').text(title.text());
            title.remove();
            var title=$('#quicktabs-tabpage-thi_thu_thcs-2').find('.views-field-title');
            $('#quicktabs-tab-thi_thu_thcs-2').text(title.text());
            title.remove();
        }

    }

    $(function () {
        oms.initMatchHeight();
        oms.initQuickTabExams();
    })


})(jQuery)