(function ($) {
    $(function () {
        $('.region-header >div.block,.contact-us-info>div.col-md-4').matchHeight({
            byRow: true,
            property: 'height',
            target: null,
            remove: false
        });





        var type=$('#views-exposed-form-search-tour-page #edit-field-type-value');
        var destination=$('#views-exposed-form-search-tour-page #edit-term-node-tid-depth');
        type.change(function(){
            filterDiemDen(type.val());
            destination.val('All');
        })
        $(function(){
            filterDiemDen(type.val());
        })
        function filterDiemDen(type){

            switch (type){
                case "0":
                    destination.find('option').each(function(){
                        var value=parseInt($(this).attr('value'));
                        if(diem_den_trong_nuoc.indexOf(value) > -1){
                            $(this).show();
                        }else{
                            if($(this).val()!='All'){
                                $(this).hide();
                            }

                        }
                    })

                    break;
                case "1":
                    destination.find('option').each(function(){
                        var value=parseInt($(this).attr('value'));
                        if(diem_den_nuoc_ngoai.indexOf(value) > -1){
                            $(this).show();
                        }else{
                            if($(this).val()!='All'){
                                $(this).hide();
                            }
                        }
                    })
                    break;
                default:
                    destination.find('option').show();
                    break;
            }
        }
    })
})(jQuery)