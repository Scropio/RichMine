/*!
 * 灏忓叺寤虹珯鍏叡寤虹珯鍏叡JS
 * Copyright 2016-6-3 xiaobing, Inc.
 * Licensed under MIT license
 */

$(document).ready(function () {
    /*瀵艰埅鎺у埗*/

    var body = $('.body');

    ;(function ($) {

        // footer
        // var footNav = $('.foot-nav');
        // footNav.find('>li').click(function(){
        //    $(this).find('ul').slideToggle(300);
        // })

        var btnMenu = $('#btn-menu');
        var menuBody = $('#menu');
        var closeMenu = $('#close-menu')

        btnMenu.click(function () {

            if (menuBody.hasClass("menu-hidden")) {
                menuBody.removeClass("menu-hidden");
                body.css('overflow', 'hidden');
            }
            else {
                menuBody.addClass("menu-hidden");
                body.css('overflow', 'auto');
            }
        })
        menuBody.find('.mask').click(function () {
            menuBody.addClass("menu-hidden");
            body.css('overflow', 'auto');
        })
        closeMenu.click(function () {
            menuBody.addClass("menu-hidden");
            body.css('overflow', 'auto');
        })

        //杩斿洖
        $('.btn-back').click(function () {
            window.history.back();
        })

        //瑙ｉ櫎娴忚鍣ㄦ嫋鎷戒簨浠�
        var $img = $("img");
        var moving = function (event) {
            //something
        }
        //IE涓嬮渶瑕佸湪document鐨刴ousemove閲岄潰鍙栨秷榛樿浜嬩欢;瑕佺敤鍘熺敓JS鐨勪簨浠朵笉鑳界敤JQuery
        // document.onmousemove = function(e){
        //     var ev = e || event;
        //     ev.cancelBubble=true;
        //     ev.returnValue = false;
        // }
        $img.mousedown(function (event) {
            //FF涓嬮渶瑕佸湪mousedown鍙栨秷榛樿鎿嶄綔;
            event.preventDefault();
            event.stopPropagation();
            $(this).bind("mousemove", moving);
        })


        /*棣栭〉*/
        ;(function () {
            // banner
            var swiper = new Swiper('.swiper-index', {
                slidesPerView: 1,
                spaceBetween: 0,
                pagination: '.swiper-pagination',
                paginationClickable: true,
                autoplay: 5000,
                speed: 1000,
            });
            var swiper = new Swiper('.swiper-proclass', {
                slidesPerView: 3,
                spaceBetween: 10
            });
            var swiper = new Swiper('.swiper-case', {
                slidesPerView: 2.1,
                spaceBetween: 10
            });
            var swiper = new Swiper('.swiper-newstab', {
                slidesPerView: 3,
                spaceBetween: 0
            });
            var swiper = new Swiper('.swiper-pagenav', {
                slidesPerView: 3,
                spaceBetween: 0
            });
            var swiper = new Swiper('.swiper-pagenav-three', {
                slidesPerView: 3,
                spaceBetween: 0
            });

        })();

        $('.swiper-newstab').find('#tabs').tabs(".news-group>.list-news", {
            event: 'mouseover',
            tab: 'div',
            tabs: 'div',
            effect: 'default',
            current: 'active',
            fadeInSpeed: 600
        });


    })(jQuery)


//end ready
})






























