var NHAN_XE_VE_KET_QUA_BAD=Drupal.t('Result bad');
var NHAN_XE_VE_KET_QUA_NORMAL=Drupal.t('Result normal');
var NHAN_XE_VE_KET_QUA_GOOD=Drupal.t('Result good');
var NHAN_XE_VE_KET_QUA_PERFECT=Drupal.t('Result perfect');
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
            var content=$('.page-node-quiz-results-view #block-system-main > .content');
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
            });
            correct=total-incorrect;
            var rate=(correct/total)*100;
            var message="";
            //bad, normal, good, better, best, perfect
            if(rate<50){
                message='BAD';
            }else if(rate<70){
                message='NORMAL';
            }else if(rate<80){
                message='GOOD';
            }else{
                message='PERFECT';
            }
            summary+="<ul>";
            globalResult+='<div class="total-correct"><span class="correct"></span>Bạn đã trả lời: <span class="count">'+correct+'</span></div>';
            globalResult+='<div class="total-incorrect"><span class="incorrect"></span>Cần xem xét lại: <span class="count">'+incorrect+'</span></div>';
            globalResult+='<div class="total-answer">Kết quả: <span class="count">'+correct+'/'+total+'</span></div>';
            globalResult+='</div>';

            content.prepend('<h2 class="result-detail">'+Drupal.t('Đáp án chi tiết')+'</h2>');
            content.prepend('<div class="admin-message">'+window['NHAN_XE_VE_KET_QUA_'+message]+'</div>');
            content.prepend(summary);
            content.prepend(globalResult);

            //add class to table
            content.find('table.sticky-enabled').addClass('table').addClass('table-striped').addClass('table-hover');
            $(".page-node-quiz-results-view #quiz-view-table").addClass('table').addClass('table-striped');
        },

        /*
        * add class to quiz table
         */
        addStyleToQuizTable:function () {
            $('#quiz-view-table').addClass('table').addClass('table-striped');
            $('.userpoints-myuserpoints-list').addClass('table').addClass('table-striped');
            $('.userpoints-myuserpoints-total').addClass('table').addClass('table-striped');
        },

        //google login
        triggerGoogleLoginButton: function(){
            $('.btn-social.btn-google').click(function (e) {
                $('#edit-submit-google').trigger('click');
                e.preventDefault();
            })

        },

        //Add title to tuluyen page
        addTitleToTuluyen:function () {
          $('#views-exposed-form-tu-luyen-page .views-exposed-form .views-exposed-widgets').prepend('<div class="views-exposed-widget"><h1 class="title">Thi tự luyện</h1></div>')
        },

        menuRps: function () {
            $('#navigation').removeClass('open');
            $('#menu-icon').click(function(e){
                e.preventDefault();
                $(this).toggleClass('open');
                $('#navigation').toggleClass('open');
                $('html').toggleClass('open_overlay');
            });

            $('#content').on("click", function () {
                $('html').removeClass('open_overlay');
                $('#navigation').removeClass('open');
            });

        },

        slider:function(){
            $('.banner-top-1 .row').slick({
                dots: true,
                infinite: true,
                speed: 300,
                responsive: [
                    {
                        breakpoint: 2024,
                        settings: "unslick"
                    },
                    {
                        breakpoint: 767,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }
                    // You can unslick at a given breakpoint now by adding:
                    // settings: "unslick"
                    // instead of a settings object
                ]
            });
        }
    }

    $(function () {
        oms.menuRps();
        oms.initMatchHeight();
        oms.initQuickTabExams();
        oms.disablePageCategory();
        oms.generateQuizResult();
        oms.addStyleToQuizTable();
        oms.triggerGoogleLoginButton();
        oms.addTitleToTuluyen();
        oms.slider();
    })


})(jQuery)