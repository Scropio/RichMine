/*==============================================
 *http://www.xiaobing360.com
 * jQuery浜や簰缁勪欢 Version 1.0
 * Copyright 2016-2017 xb, Inc. Author WANGHAO
 * Licensed under the MIT license
 */
if (typeof jQuery === 'undefined') {
    throw new Error('闇€瑕佹坊鍔爅Query!')
}

/**
 * XBUI瀵艰埅浜や簰缁勪欢
 * Author锛歸anghao
 * 2017-03-06
 */
+(function ($) {

    "use strict";

    //鏋勯€犲嚱鏁�
    function Navigation(element, options) {
        // this.settings = $.extend(true,$.fn.KEFUTU.defaults, options||{});//鑾峰彇鍙傛暟
        var me = this;
        me.obj = element; //瀵艰埅瀵硅薄
        me.data_cell = me.obj.attr('data-cell');//瑙﹀彂瀵硅薄
        me.data_toggle = me.obj.attr('data-toggle');//瑙﹀彂鏁堟灉
        me.data_trigger = me.obj.attr('data-trigger');//瑙﹀彂浜嬩欢
        me.data_target = me.obj.attr('data-target');//瑙﹀彂鐩爣
        me.data_direction = me.obj.attr('data-direction');//绾挎潯绉诲姩鏂瑰悜
        me.init();
        return element;
    }

    //瀹氫箟鍒濆鍖栧嚱鏁� 鍦ㄦ鍙互鐭ラ亾浣犻渶瑕佸鍔犵殑鐗规晥
    Navigation.prototype.init = function () {
        var me = this;

        // 瀵艰埅浜や簰鏁堟灉
        if (me.data_toggle == '' || me.data_toggle == 'undefined') me.data_toggle = "slideDown";
        if (me.data_trigger == '' || me.data_trigger == 'undefined') me.data_trigger = "mouseover";

        me.obj.find(me.data_cell).hover(function () {
            $(this).addClass('on');
        }, function () {
            $(this).removeClass('on');
        })

        switch (me.data_toggle) {
            case 'slideDown':
                me.obj.find(me.data_cell).hover(function () {
                    console.log(me.data_target);
                    $(this).find(me.data_target).stop(true, true).slideDown();
                }, function () {
                    $(this).find(me.data_target).stop(true, true).slideUp();
                })
                break;
            case 'fade':
                me.obj.find(me.data_cell).hover(function () {
                    console.log(me.data_target);
                    $(this).find(me.data_target).stop(true, true).fadeIn();
                }, function () {
                    $(this).find(me.data_target).stop(true, true).fadeOut();
                })
                break;
            case 'movingLine':

                me.movingLine();

                break;
            case 'mobileNav':
                me.mobileNav1();

                break;
            default:
            //n 涓� case 1 鍜� case 2 涓嶅悓鏃舵墽琛岀殑浠ｇ爜
        }
        // 鍙傛暟
        // console.log(me.effect);
    }

    Navigation.prototype.movingLine = function () {
        var me = this;

        if (me.obj.find('.active').length) {
            //鍒濆鍖栫劍鐐�

            var pX = me.obj.find('.active').position().left;//褰撳墠鍒楀潗鏍�
            var pY = me.obj.find('.active').position().top;//褰撳墠鍒楀潗鏍�
            var pW = me.obj.find('.active').outerWidth(); //褰撳墠鍒楀
            var pH = me.obj.find('.active').outerHeight(); //褰撳墠鍒楅珮
            var pMl = parseInt(me.obj.find('.active').css("margin-left")); //褰撳墠鍒梞arginleft
            var pIndex = me.obj.find('.active').index(); //褰撳墠绱㈠紩
            me.obj.find('.active').removeClass('move');

            if (me.data_direction == '' || me.data_direction == 'h') {
                me.obj.find(".movingLine").stop().animate({'left': pX, 'width': pW}, 300);
            }

            if (me.data_direction == 'v') {
                me.obj.find(".movingLine").stop().animate({'left': pX, 'top': pY + pH, 'width': pW}, 300);
            }

            // 缁戝畾榧犳爣浜嬩欢
            me.obj.find(me.data_cell).each(function (index) {
                var $this = $(this);

                // 榧犳爣鏉ラ
                $this.on('mouseenter', function (e) {
                    // 鑾峰彇瀵艰埅鍒楀熀鏈睘鎬�
                    var pX = $(this).position().left;//褰撳墠鍒楀潗鏍�
                    var pY = $(this).position().top;//褰撳墠鍒楀潗鏍�
                    var pW = $(this).outerWidth(); //褰撳墠鍒楀
                    var pH = $(this).outerHeight(); //褰撳墠鍒楅珮
                    var pMl = parseInt($(this).css("margin-left")); //褰撳墠鍒梞arginleft
                    var pIndex = index; //褰撳墠绱㈠紩
                    me.obj.find('.active').addClass('move'); //绉诲姩涓�

                    if (me.data_direction == '' || me.data_direction == 'h') {
                        me.obj.find(".movingLine").stop().animate({'left': pX, 'width': pW}, 300);
                    }

                    if (me.data_direction == 'v') {
                        me.obj.find(".movingLine").stop().animate({'left': pX, 'top': pY + pH, 'width': pW}, 300);
                    }

                    // console.log(pX+'/'+pY+'/'+pW+'/'+pH+'/'+pMl+'/'+pIndex);
                })

                $this.on('mouseleave', function (e) {
                    // 鑾峰彇瀵艰埅鍒楅珮浜爮鐩熀鏈睘鎬�
                    var pX = me.obj.find('.active').position().left;//褰撳墠鍒楀潗鏍�
                    var pY = me.obj.find('.active').position().top;//褰撳墠鍒楀潗鏍�
                    var pW = me.obj.find('.active').outerWidth(); //褰撳墠鍒楀
                    var pH = me.obj.find('.active').outerHeight(); //褰撳墠鍒楅珮
                    var pMl = parseInt(me.obj.find('.active').css("margin-left")); //褰撳墠鍒梞arginleft
                    var pIndex = me.obj.find('.active').index(); //褰撳墠绱㈠紩
                    me.obj.find('.active').removeClass('move');

                    if (me.data_direction == '' || me.data_direction == 'h') {
                        me.obj.find(".movingLine").stop().animate({'left': pX, 'width': pW}, 300);
                    }
                    if (me.data_direction == 'v') {
                        me.obj.find(".movingLine").stop().animate({'left': pX, 'top': pY + pH, 'width': pW}, 300);
                    }

                })
            })


        } else {

            // 缁戝畾榧犳爣浜嬩欢
            me.obj.find(me.data_cell).each(function (index) {
                var $this = $(this);
                var movingLine = me.obj.find(".movingLine");
                movingLine.hide();
                // 榧犳爣鏉ラ
                $this.on('mouseenter', function (e) {
                    // 鑾峰彇瀵艰埅鍒楀熀鏈睘鎬�
                    var pX = $(this).position().left;//褰撳墠鍒楀潗鏍�
                    var pY = $(this).position().top;//褰撳墠鍒楀潗鏍�
                    var pW = $(this).outerWidth(); //褰撳墠鍒楀
                    var pH = $(this).outerHeight(); //褰撳墠鍒楅珮
                    var pMl = parseInt($(this).css("margin-left")); //褰撳墠鍒梞arginleft
                    var pIndex = index; //褰撳墠绱㈠紩
                    me.obj.find('.active').addClass('move'); //绉诲姩涓�
                    // movingLine.fadeIn(300);
                    if (me.data_direction == '' || me.data_direction == 'h') {
                        movingLine.stop(true, true).fadeIn(300).stop(true, true).animate({
                            'left': pX,
                            'width': pW
                        }, 300);
                    }

                    if (me.data_direction == 'v') {
                        movingLine.stop(true, true).fadeIn(300).stop(true, true).animate({
                            'left': pX,
                            'top': pY + pH,
                            'width': pW
                        }, 300);
                    }

                    // console.log(pX+'/'+pY+'/'+pW+'/'+pH+'/'+pMl+'/'+pIndex);
                })
                //
            })
        }

    }

    // 绉诲姩绔鑸紨绀�
    Navigation.prototype.mobileNav1 = function () {
        //椤剁骇瀵艰埅鎺у埗
        var me = this,
            win_height = $(window).height(),
            win_width = $(window).width(),
            header_height = me.obj.outerHeight(),
            navSide = $('.nav-main'),
            btnNavTop = $('#btn-toggle');

        //浜岀骇瀵艰埅鎺у埗
        var btnNavSecond = $('.btn-nav-second');
        var navSecond = $('.menu');

        btnNavTop.on('click', function () {
            var $this = $(this);
            $('html').css({'overflow': 'hidden'});
            win_height = $(window).height();
            win_width = $(window).width();
            $this.toggleClass('on');
            //鍒濆鍖栭珮搴�
            navSide.css({'width': win_width, 'height': win_height, 'top': header_height}).stop(true, true).fadeIn(300);

            $(window).resize(function () {
                win_height = $(window).height();
                win_width = $(window).width();
                navSide.css({'width': win_width, 'height': win_height, 'top': header_height});
            })
            //濡傛灉浜岀骇鑿滃崟鎵撳紑浜嗭紝灏辫鍏抽棴
            if (navSecond.hasClass('on')) {
                btnNavSecond.click();
            }
            // 鍏抽棴瀵艰埅鏃跺€�
            if (navSide.hasClass('on')) {
                $('html').css({'overflow': 'auto'});
                navSide.removeClass('on').stop(true, true).fadeOut();

                $('#pageMask').remove();
                $(window).off();

            } else {
                // 鎵撳紑
                navSide.addClass('on');
                $('body').append('<div id="pageMask" style="position:fixed;left:0;top:0;">');
                $('#pageMask').css({'width': win_width, 'height': win_height});
            }

            // 瀛愯彍鍗曟搷浣�
            navSide.find('>ul>li .btn-handle').click(function () {
                me = $(this);

                if (!me.parent().parent().hasClass('on')) {
                    me.parent().parent().siblings().find('ul').stop(true, true).slideUp();
                    me.parent().parent().siblings().removeClass('on');
                    me.parent().parent().addClass('on');
                    me.parent().siblings('ul').stop(true, true).slideDown();
                } else {
                    me.parent().parent().removeClass('on');
                    me.parent().siblings('ul').stop(true, true).slideUp();
                }

                return false

            })


        })

        //缁戝畾浜嬩欢
        btnNavSecond.click(function () {
            //濡傛灉椤剁骇鑿滃崟鎵撳紑浜嗗氨瑕佸叧闂�
            if (navSide.hasClass('on')) {
                btnNavTop.click();
            }
            if (navSecond.hasClass('on')) {
                navSecond.stop(true, true).slideUp(300);
                navSecond.removeClass('on');
            } else {
                navSecond.stop(true, true).slideDown(300);
                navSecond.addClass('on');
            }

        })

    }


    // 鏋愭瀯鍑芥暟

    //娉ㄥ唽
    $.fn.navigation = function (element, options) {
        //涓轰簡閾惧紡璋冪敤
        return this.each(function () {
            var me = $(this);
            //鍒濆鍖栧疄渚�
            var instance = me.attr('role');
            if (instance == 'navigation') {
                instance = new Navigation(me, options);
            }

        })
    }

    // $(window).on('load',function(){
    //   // alert();
    //   // obj.navigation({});
    //   var obj = $('[role="navigation"]');
    //   var effect = obj.attr('effect');
    //   obj.navigation();
    // });
    $(document).ready(function () {
        $('[role="navigation"]').navigation();
    })

})(jQuery);

/**
 * XBUI鍒楄〃浜や簰鏂规
 * @author Wanghao
 * @date:20170320
 */
+(function ($) {

    "use strict";

    //鏋勯€犲嚱鏁�
    function Datalist(element, options) {
        // this.settings = $.extend(true,$.fn.KEFUTU.defaults, options||{});//鑾峰彇鍙傛暟
        var me = this;
        me.obj = element; //瀵艰埅瀵硅薄
        me.data_cell = me.obj.attr('data-cell');//瑙﹀彂瀵硅薄
        me.data_toggle = me.obj.attr('data-toggle');//瑙﹀彂鏁堟灉
        me.data_trigger = me.obj.attr('data-trigger');//瑙﹀彂浜嬩欢
        me.data_target = me.obj.attr('data-target');//瑙﹀彂鐩爣
        me.data_direction = me.obj.attr('data-direction');//绾挎潯绉诲姩鏂瑰悜

        me.init();
        return element;
    }

    //瀹氫箟鍒濆鍖栧嚱鏁� 鍦ㄦ鍙互鐭ラ亾浣犻渶瑕佸鍔犵殑鐗规晥
    Datalist.prototype.init = function () {
        var me = this;

        // 瀵艰埅浜や簰鏁堟灉
        if (me.data_toggle == '' || me.data_toggle == 'undefined') me.data_toggle = "fadeIn";
        if (me.data_trigger == '' || me.data_trigger == 'undefined') me.data_trigger = "mouseover";

        me.obj.find(me.data_cell).hover(function () {
            $(this).addClass('on');
        }, function () {
            $(this).removeClass('on');
        })

        switch (me.data_toggle) {

            case 'fadeIn':

                me.obj.find(me.data_cell).hover(function () {

                    $(this).find(me.data_target).stop(true, true).fadeIn();

                }, function () {

                    $(this).find(me.data_target).stop(true, true).fadeOut();

                })

                break;

            case 'custom':


                break;

            default:
            //n 涓� case 1 鍜� case 2 涓嶅悓鏃舵墽琛岀殑浠ｇ爜
        }
        // 鍙傛暟
        // console.log(me.effect);
    }


    // 鏋愭瀯鍑芥暟


    $.fn.Datalist = function (element, options) {
        //涓轰簡閾惧紡璋冪敤
        return this.each(function () {
            var me = $(this);
            //鍒濆鍖栧疄渚�
            var instance = me.attr('role');
            if (instance == 'datalist') {
                instance = new Datalist(me, options);
            }

        })
    }

    // $(window).on('load',function(){
    //   // alert();
    //   // obj.navigation({});
    //   var obj = $('[role="navigation"]');
    //   var effect = obj.attr('effect');
    //   obj.navigation();
    // });

    $(document).ready(function () {

        // var obj = ;
        $('[role="datalist"]').Datalist();
    })

})(jQuery);


/**
 * 骞荤伅鐗囦氦浜掓柟妗�  鍩轰簬http://www.superslide2.com/ 澶ц瘽涓诲腑 鏀圭紪
 * @author Wanghao
 * @date:20170320
 */
+(function ($) {

    "use strict";

    //鏋勯€犲嚱鏁�
    function Xbslide(element, options) {
        // this.settings = $.extend(true,$.fn.KEFUTU.defaults, options||{});//鑾峰彇鍙傛暟
        var me = this;
        me.obj = element; //瀵艰埅瀵硅薄
        me.data_cell = me.obj.attr('data-cell');//瑙﹀彂瀵硅薄
        me.data_toggle = me.obj.attr('data-toggle');//瑙﹀彂鏁堟灉
        me.data_trigger = me.obj.attr('data-trigger');//瑙﹀彂浜嬩欢
        me.data_target = me.obj.attr('data-target');//瑙﹀彂鐩爣
        me.data_direction = me.obj.attr('data-direction');//绾挎潯绉诲姩鏂瑰悜

        me.init();
        return element;
    }

    //瀹氫箟鍒濆鍖栧嚱鏁� 鍦ㄦ鍙互鐭ラ亾浣犻渶瑕佸鍔犵殑鐗规晥
    Xbslide.prototype.init = function () {
        var me = this;

        // 瀵艰埅浜や簰鏁堟灉
        if (me.data_toggle == '' || me.data_toggle == 'undefined') me.data_toggle = "slideDown";
        if (me.data_trigger == '' || me.data_trigger == 'undefined') me.data_trigger = "mouseover";

        switch (me.data_toggle) {

            case 'fadeIn':
                me.obj.slide({
                    mainCell: ".bd ul",
                    titCell: ".hd ul",
                    effect: "fold",
                    autoPlay: false,
                    autoPage: true,
                    trigger: "click",
                    mouseOverStop: true,
                    interTime: 3500,
                    delayTime: 600,
                    endFun: function (i, c, s) {
                    }
                });


                break;

            case 'custom':


                break;

            default:
            //n 涓� case 1 鍜� case 2 涓嶅悓鏃舵墽琛岀殑浠ｇ爜
        }

    }


    // 鏋愭瀯鍑芥暟


    $.fn.Xbslide = function (element, options) {
        //涓轰簡閾惧紡璋冪敤
        return this.each(function () {
            var me = $(this);
            //瀹炰緥
            var instance = me.attr('role');
            if (instance == 'slide') instance = new Xbslide(me, options);

        })
    }

    // $(window).on('load',function(){
    //   // alert();
    //   // obj.navigation({});
    //   var obj = $('[role="navigation"]');
    //   var effect = obj.attr('effect');
    //   obj.navigation();
    // });

    $(document).ready(function () {
        // var obj = ;
        $('[role="slide"]').Xbslide();
    })

})(jQuery);

/**
 * 甯哥敤JS鎻掍欢
 * @author Wanghao
 * @date:20170321
 */

+(function ($) {
    "use strict";
    $(document).ready(function () {
        //鍥剧墖寤惰繜鍔犺浇鎻愬崌鎬ц兘
        $('img.lazy').lazyload({
            effect: 'fadeIn'
        });

    })
})(jQuery);












