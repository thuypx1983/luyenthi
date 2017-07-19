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
            select.find('option[value=0],option[value=27]').hide();
        },

        /**
         * Quiz result
         */
        generateQuizResult:function () {
            var total=0;
            var incorrect=0;
            var correct=0;
            var globalResult='<div class="global-result">';
            var summary="<ul class='summary-result'>";
            var i=1;
            var content=$('.page-node-quiz-results-view #block-system-main');
            content.find('fieldset.form-wrapper').each(function(){
                total++;
                var className="";
                if($(this).find('.quiz-score-icon.incorrect').length==1){
                    incorrect++;
                    className='incorrect';
                }else {
                    className='correct';
                };
                summary+='<li class="'+className+'">'+i+'</li>';
                i++;
            })
            correct=total-incorrect;
            summary+="<ul>";
            globalResult+='<div class="total-correct"><span class="correct"></span>Bạn đã trả lời: <span class="count">'+correct+'</span></div>';
            globalResult+='<div class="total-incorrect"><span class="incorrect"></span>Cần xem xét lại: <span class="count">'+incorrect+'</span></div>';
            globalResult+='<div class="total-answer">Kết quả: <span class="count">'+correct+'/'+total+'</span></div>';
            globalResult+='</div>';
            content.prepend(summary);
            content.prepend(globalResult);
        },

    }

    $(function () {
        oms.initMatchHeight();
        oms.initQuickTabExams();
        oms.disablePageCategory();
        oms.generateQuizResult();
    })


})(jQuery)