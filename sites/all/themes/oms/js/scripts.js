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
        },

        /**
         * Disable some category
         */
        disablePageCategory: function(){
            var select=$('#views-exposed-form-quiz-filter-page').find('#edit-shs-term-node-tid-depth-select-1');
            alert(select.length)
            select.find('option[value=0],option[value=27]').hide();
        }



    }

    $(function () {
        oms.initMatchHeight();
        oms.initQuickTabExams();
        oms.disablePageCategory();
    })


})(jQuery)