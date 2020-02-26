/*==============================================

 * js公共库 用于自定义
 * Copyright 2016 xb, Inc. Author WANGHAO 
 * Licensed xiaomingTECH
 */

$(document).ready(function () {

    /*页面控制*/
    ;
    (function ($) {

        (function () {

            // skitter
            var fullSlide = $('.full-slide');
            //切换动画
            // var effectArr = ['cube', 'cubeRandom', 'block', 'cubeStop', 'circles', 'cubeSpread', 'blindWidth', 'circlesInside', 'fade', 'horizontal']
            fullSlide.skitter({
                label: false,
                numbers: false,
                theme: 'minimalist',
                show_randomly: false,
                navigation: true,
                // with_animations: 'fade',
                animation:'fade',
                progressbar:false
            });

            // tabs 首页
            // $("#nav-case-tabsIndex").tabs(".nav-case-tabsContent > div",{event:'mouseover',tab:'div',tabs:'.item',effect: 'default',current:'active',fadeInSpeed:600});

            // tabs分类打开与关闭
            /*var navCaseTabs = $("#nav-case-tabs"),
             btnMore = '<li class="btn-more"><a href="javascript:">更多</a><span class="caret"></span></li>'
             ;

             navCaseTabs.find('>li').each(function(index){
             if(index<8){
             navCaseTabs.addClass('text-center');
             }else{
             navCaseTabs.removeClass('text-center');
             }
             if(index==8){
             $(this).after(btnMore);
             btnMore = navCaseTabs.find('.btn-more');
             btnMore.click(function(e){
             navCaseTabs.toggleClass('open');
             })
             }
             });*/


            /* var newsPanels = $('#newsPanels');
             newsPanels.find('.list-item .btn-handel').click(function(){
             var listItem = $(this).parents('.list-item');
             listItem.siblings().removeClass('on');
             listItem.siblings().find('.btn-handel').text('+');
             listItem.siblings().find('.item-content').stop().slideUp();
             listItem.addClass('on');
             listItem.find('.item-content').stop().slideDown();
             $(this).text('-');
             })
             newsPanels.find('.list-item').eq(0).find('.btn-handel').click();*/

        })()


        /**
         * 列表菜单特效
         * @type {[type]}
         */
        var navSide = $("#nav-side");
        navSide.find('dt a').click(function (e) {
            me = $(this);
            // 关闭
            me.parents('dl').siblings().removeClass('on').find('dd').slideUp();

            // 打开

            if (!me.parents('dl').hasClass('on')) {
                me.parents('dl').addClass('on');
                me.parent().siblings('dd').slideDown();
            } else {
                me.parents('dl').removeClass('on');
                me.parent().siblings('dd').slideUp();
            }

            return false;
        })




        // 友情连接
        // $('.dropdown-list').dropdownList({skin:'',render:''});

        // $('.full-slide').skitter({
        //   label: false,
        //   numbers: false,
        //   theme: ''
        // });

        //解除浏览器拖拽事件
        var $img = $("img");
        var moving = function (event) {
            //something
        }
        //IE下需要在document的mousemove里面取消默认事件;要用原生JS的事件不能用JQuery
        // document.onmousemove = function(e){
        //     var ev = e || event;
        //     ev.cancelBubble=true;
        //     ev.returnValue = false;
        // }
        $img.mousedown(function (event) {
            //FF下需要在mousedown取消默认操作;
            event.preventDefault();
            event.stopPropagation();
            $(this).bind("mousemove", moving);
        })

        //图片延迟加载提升性能
        $('img.lazy').lazyload({
            effect: 'fadeIn'
        });


        // wow.js
        if (!(/msie [6|7|8|9]/i.test(navigator.userAgent))) {
            var wow = new WOW({
                boxClass: 'wow',
                animateClass: 'animated',
                offset: 20,
                mobile: true,
                live: true
            });
            wow.init();
        }
        ;



        // 搜索
        var search = $('#search');
        var searchInput = search.find('input');
        var searchBtn = search.find('a');
        searchInput.focus(function () {
            if (searchInput.val() == '') {
                searchBtn.css('color', '#666');
            }
            else {
                searchBtn.css('color', '#ec6941');
            }
        })


    })(jQuery)


//end ready

})

/**
 * Author MR wanghao 2016-06-02
 * 滑动跳转构造函数
 */
function aScroll(id, event) {
    var h = $('#' + id).offset().top;//- parseInt($('.header').css('height'))-60;
    $("html, body").stop(true, true).animate({
            scrollTop: h + "px"
        },
        {
            duration: 600,
            easing: "swing"
        });

    return false;
}

/**
 * 弹出式图集相册基于unitegallery制作2016-06-02
 * Author MR wanghao
 * @id： 分类id
 * @element： 事件对象
 * @_index:对象索引
 * @_url:ajax url
 * 数据格式： json：'<img alt="'+ json.alt +'" src="'+ json.thumbs +'" data-image="'+ json.dataImage +'" data-description="'+json.dataDescription+'">';
 */
//构造函数
function showGallery(id, element, _index, _url) {

    //相册画廊
    var gallery = '<div class="gallery-container" id="gallery-container">';
    gallery += '     <div id="gallery" style="display:none;">';
    gallery += '     </div>';
    gallery += '     <a href="javascript:" title="上一个图集" class="ug-btn-prev">\<<a><a class="ug-btn-next" title="下一个图集" href="javascript:" class="ug-btn-next">\><a>';
    gallery += '</div>';

    //遮罩层
    var maskHtml = '<div id="pageMask" style="display:table;background: rgba(0, 0, 0, 0.6) !important;background-color: #000000;filter: alpha(opacity=60);position:fixed;left:0;top:0;">' + gallery + '</div>';

    //创建遮罩和相册
    $('body').append(maskHtml);

    //*添加图集数据  可以是外部数据，例如ajax
    var dataList = '';
    //dataList += '<img alt="Preview Image 1" src="images/thumb1.jpg" data-image="images/big/image1.jpg" data-description="Preview Image 1 Description">';
    var len;
    // 构造函数
    function getData(id, url) {
        dataList = null;//清空数据

        $.ajax({
            type: "GET",
            url: url + '?id=' + id,
            dataType: "json",
            success: function (data) {
                $.each(data, function (index, json) {

                    dataList += '<img alt="' + json.alt + '" src="' + json.thumbs + '" data-image="' + json.dataImage + '" data-description="' + json.dataDescription + '">';
                })

                len = data.length;
                $('#gallery').append(dataList);
            }
        });
    }

    //初始化
    getData(id, _url);
    //请求完毕-》渲染相册
    $(document).ajaxSuccess(function () {
        //alert("AJAX 请求完成");
        var api = jQuery("#gallery").unitegallery();
        //适应浏览器宽高
        var galleryHeight; //相册高度
        var galleryContainer; //相册容器
        var pageMask = $('#pageMask'); //遮罩
        var galleryBox = $('#gallery'); //相册
        var btnControl = $('#btnControl');
        var btnPrev = $('.ug-btn-prev'); //控制
        var btnNext = $('.ug-btn-next');
        var myElement = $(element);

        function fit(galleryHeight) {
            win_height = $(window).height();
            win_width = $(window).width();
            galleryHeight = galleryBox.css('height');
            //alert(galleryHeight)
            $('#pageMask').css({'width': win_width, 'height': win_height});
            galleryContainer = $('#gallery-container');
            galleryContainer.css({
                'width': win_width,
                'height': 'auto',
                'top': '50%',
                'margin-top': -parseInt(galleryHeight) / 2
            });
        }

        //初始化fit
        fit();
        //窗口变化的时候
        $(window).resize(function () {
            galleryHeight = galleryBox.css('height');
            fit(galleryHeight);

        })
        //点击遮罩关闭
        pageMask.click(function (event) {
            $(this).off();
            btnPrev.off();
            btnNext.off();
            $(this).remove();
        })
        //阻止点击冒泡
        galleryBox.click(function (event) {

            event.stopPropagation();
        })

        //下一个图集
        btnNext.on('click', function (e) {
            //api.prevItem();
            event.stopPropagation();
            //元素索引++
            elementIndex++;
            if (elementIndex >= myElement.length) {
                elementIndex = myElement.length - 1;
            }
            ;
            //id
            var cid = myElement.eq(elementIndex).attr('cateid');
            console.log(cid);
            jQuery("#gallery").empty();
            getData(cid, _url);
            setTimeout(function () {
                api = jQuery("#gallery").unitegallery();
            }, 200)

        })

        btnPrev.on('click', function (e) {
            //api.prevItem();
            event.stopPropagation();
            elementIndex--;
            if (elementIndex <= myElement.length - 1) {
                elementIndex = 0;
            }
            ;

            //id;
            var cid = myElement.eq(elementIndex).attr('cateid');

            jQuery("#gallery").empty();
            getData(cid, _url);
            setTimeout(function () {
                api = jQuery("#gallery").unitegallery();
            }, 200)

        })
    });


}
//end show gallary
































