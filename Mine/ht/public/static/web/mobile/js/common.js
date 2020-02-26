/**



 * 鍏叡JS

 * @authors xiaobingTech wang

 * @date  2015-11-11

 * @version 1.0

 */

$(function(){



    //璁惧璇嗗埆

    if(device.ipad() || device.ipod()) window.location.href="http://www.china-hzd.com/";



    //瀵艰埅鐗规晥  鎵撳紑鍏抽棴
    var $navbar = $("#nav_btn");  //涓€绾�
    var $navsub = $('#nav_subbtn');  //浜岀骇

    $navbar.click(function(){


        var obj = $("dl.navbar");

        obj.slideToggle();

        //鍒濆鍖�

        obj.find("dt").removeClass("on");

        obj.find("dd").slideUp(300);

        $navsub.parent().siblings('ul').slideUp(300);

    })



    //缁戝畾杩斿洖

    $(".btn-back").click(function(){

        window.history.back();

    })



    $("dl.navbar").eq(0).addClass("top");

    $("dl.navbar >dt").click(function(){

        /*

    //閲嶇疆



    $(this).parent().siblings().find("dd").slideUp();



    $(this).parent().siblings().find("dt").removeClass("on");



    //濡傛灉鏈夊瓙鑿滃崟鐨勬椂鍊�



    if($(this).siblings("dd").find("li").size()>0){



        if($(this).siblings("dd").is(":hidden")){



            $(this).addClass("on");



            $(this).siblings("dd").slideDown();



        }else



        {

            $(this).removeClass("on");



            $(this).siblings("dd").slideUp();

        }



    }



    */



    })



    //瀵艰埅浜岀骇鑿滃崟

    $navsub.click(function(){


        $(this).parent().siblings('ul').slideToggle(300);

        $("dl.navbar").slideUp(300);

    })







    $(".fixnav").on("click",function(){



        $(this).find(".sub_fixnav").slideToggle();

        //alert();

    })



    //鍘婚櫎鍥剧墖瀹藉害涓庨珮搴︿互鍙妔tyle

    function delhtml(o){

        if($(o).length){

            var $img = $(o).find("img");

            //alert($article_lifeCon.length)

            if($img.length){

                for(var i=0;i<$img.length;i++){

                    $img.eq(i).removeAttr("width").removeAttr("height").removeAttr("style");

                }

            }

        }



    }

    delhtml("#article_lifeCon");

    delhtml("#article_case_con");



    //妗堜緥鍒嗙被 鎿嶄綔

    var $cate_list = $(".cate_list");



    if($cate_list.length > 0){



        for(var i = 0;i < $cate_list.find(">li").length;i++)

        {

            if($cate_list.find(">li").eq(i).find("li").length == 0)

            {

                //褰撳ぇ浜庡ぇ浜庣瓑浜庡晢涓氳璁＄殑鏃跺€�  鍙栨秷瀛愯彍鍗�  鎶婃枃瀛楁敼涓烘煡鐪�

                var linkstr = $cate_list.find(">li").eq(i).find("a").attr("link");

                $cate_list.find(">li").eq(i).find("a").attr("href",linkstr);

                $cate_list.find(">li").eq(i).find("span").text("鏌ョ湅");



                $cate_list.find(">li").eq(i).find("ul").empty();//娓呯┖鑺傜偣

            }

        }



        //**妗堜緥鍒楄〃鐗规晥***

        $cate_list.find(">li").click(function(){



            $(this).siblings().find("ul").slideUp(300);//閲嶇疆

            $(this).find("ul").slideToggle(300);

        })



    }



    /*娉曞緥*/



    if($(".legal_list").length){



        $(".legal_list li").click(function(){



            $(this).find(".con").slideToggle();



            $(this).toggleClass("on");



        })



    }





    /*杩斿洖椤堕儴*/



    $("#gotop,#gotop-fix").on("click",function(){

        goTop();

    })



    //杩斿洖椤堕儴鐨勬樉绀轰笌闅愯棌

    $(window).scroll(function(){



        var screenW = $(window).width(),//window.screen.width,

            screenH = $(window).height(),//$(window).height()//window.screen.height,

            footer_offTop =  $(".footer").offset().top,

            st = $(document).scrollTop();

        //alert(document.body.clientHeight);

        //alert("st:"+ st+"footer:"+footer_offTop);

        if (st > 50){

            $("#gotop-fix").stop().fadeIn(300);

            if(st > footer_offTop-380){

                //alert("st:"+ st+"footer:"+footer_offTop);

                $("#gotop-fix").stop().fadeOut(300);

            }

        } else {

            $("#gotop-fix").stop().fadeOut(300);

        }





    })



})







function goTopEx() {



    //寮规€ц繑鍥為《閮�  鍘熺敓js



    var obj = document.getElementById("gotop");



    function getScrollTop() {



        return document.documentElement.scrollTop + document.body.scrollTop;



    }



    function setScrollTop(value) {



        if (document.documentElement.scrollTop) {



            document.documentElement.scrollTop = value;



        } else {



            document.body.scrollTop = value;



        }



    }



    window.onscroll = function() {



        getScrollTop() > 0 ? obj.style.display = "": obj.style.display = "none";



    }



    obj.onclick = function() {



        var goTop = setInterval(scrollMove, 10);



        function scrollMove() {



            setScrollTop(getScrollTop() / 1.1);



            if (getScrollTop() < 1) clearInterval(goTop);



        }



    }



}



//杩斿洖椤堕儴

function goTop() {



    $('html,body').animate({'scrollTop':0},500);



}





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

            //console.log(obj);
            var more = $('#' + id);

            var loading = $('#' + id + '_loading');

            var templ = $('#' + id + '_templ');

            //console.log(templ);
            var list = $('#' + id + '_list');

            //console.log(list);


            //鑾峰彇url

            var url = location.href + "?p=" + options.page;

            //console.log(url);
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

			