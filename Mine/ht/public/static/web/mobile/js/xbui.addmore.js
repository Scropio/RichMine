/**
 * 鍏叡JS
 * @authors xiaobingTech wang
 * @date  2015-11-11
 * @version 1.0
 */


//By.jingshuixian

//鍔犺浇鏇村鏁版嵁
;(function($, window, document, undefined) {
    $.fn.loadingData = function(options) {
        var defaults = {
            page: 2,
            rows: 10
        }
        var options = $.extend({},defaults, options);
        this.each(function() {
            //鑾峰彇瀵硅薄
            $(this).on('click',function(){
                loadingdata(this);
            })
        }); //end this.each

        function loadingdata(obj){
            //鑾峰彇缁戝畾鏇村鐨刬d
            var id = $(obj).attr('id');
            var more = $('#' + id);
            var loading = $('#' + id + '_loading');
            var templ = $('#' + id + '_templ');
            var list = $('#' + id + '_list');

            //鑾峰彇url
            var url = location.href + "?p=" + options.page;
            more.hide();
            loading.show();
            $.getJSON(url, function(data){

                if(data.lists.length > 0){
                    options.page++;
                    var gettpl = templ.html();
                    laytpl(gettpl).render(data, function(html){
                        list.append(html);
                        if(data.size < options.rows){
                            more.unbind('click').html("娌℃湁浜�");
                        }
                    });
                }else{
                    more.unbind('click').html("娌℃湁浜�");
                }
            });
            more.show();
            loading.hide();
        }
    }

})(jQuery, window, document)

            