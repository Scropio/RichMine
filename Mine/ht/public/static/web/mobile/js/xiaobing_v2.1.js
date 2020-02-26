
$pintuercheck=function(element,type,value){
    $pintu=value.replace(/(^\s*)|(\s*$)/g, "");
    switch(type){
        case"required":
            return /[^(^\s*)|(\s*$)]/.test($pintu);
            break;
        case"chinese":
            return /^[\u0391-\uFFE5]+$/.test($pintu);
            break;
        case"number":
            return /^([+-]?)\d*\.?\d+$/.test($pintu);
            break;
        case"integer":
            return /^-?[1-9]\d*$/.test($pintu);
            break;
        case"plusinteger":
            return /^[1-9]\d*$/.test($pintu);
            break;
        case"unplusinteger":
            return /^-[1-9]\d*$/.test($pintu);
            break;
        case"znumber":
            return /^[1-9]\d*|0$/.test($pintu);
            break;
        case"fnumber":
            return /^-[1-9]\d*|0$/.test($pintu);
            break;
        case"double":
            return /^[-\+]?\d+(\.\d+)?$/.test($pintu);
            break;
        case"plusdouble":
            return /^[+]?\d+(\.\d+)?$/.test($pintu);
            break;
        case"unplusdouble":
            return /^-[1-9]\d*\.\d*|-0\.\d*[1-9]\d*$/.test($pintu);
            break;
        case"english":
            return /^[A-Za-z]+$/.test($pintu);
            break;
        case"username":
            return /^[a-z]\w{3,}$/i.test($pintu);
            break;
        case"mobile":
            return /^\s*(15\d{9}|13\d{9}|14\d{9}|17\d{9}|18\d{9})\s*$/.test($pintu);
            break;
        case"phone":
            return /^((\(\d{2,3}\))|(\d{3}\-))?(\(0\d{2,3}\)|0\d{2,3}-)?[1-9]\d{6,7}(\-\d{1,4})?$/.test($pintu);
            break;
        case"tel":
            return /^\s*(1[1-9]\d{9}|13\d{9}|14\d{9}|17\d{9}|18\d{9})\s*$/.test($pintu)|| /^((\(\d{2,3}\))|(\d{3}\-))?(\(0\d{2,3}\)|0\d{2,3}-)?[1-9]\d{6,7}(\-\d{1,4})?$/.test($pintu);
            break;
        case"email":
            return /^[^@]+@[^@]+\.[^@]+$/.test($pintu);
            break;
        case"email_mobile":
            return /^[^@]+@[^@]+\.[^@]+$/.test($pintu) || /^\s*(15\d{9}|13\d{9}|14\d{9}|17\d{9}|18\d{9})\s*$/.test($pintu);
            break;
        case"url":
            return /^https:|http:\/\/[A-Za-z0-9]+\.[A-Za-z0-9]+[\/=\?%\-&_~`@[\]\':+!]*([^<>\"\"])*$/.test($pintu);
            break;
        case"ip":
            return /^[\d\.]{7,15}$/.test($pintu);
            break;
        case"qq":
            return /^[1-9]\d{4,10}$/.test($pintu);
            break;
        case"currency":
            return /^\d+(\.\d+)?$/.test($pintu);
            break;
        case"zipcode":
            return /^[1-9]\d{5}$/.test($pintu);
            break;
        case"chinesename":
            return /^[\u0391-\uFFE5]{2,15}$/.test($pintu);
            break;
        case"englishname":
            return /^[A-Za-z]{1,161}$/.test($pintu);
            break;
        case"age":
            return /^[1-99]?\d*$/.test($pintu);
            break;
        case"date":
            return /^((((1[6-9]|[2-9]\d)\d{2})-(0?[13578]|1[02])-(0?[1-9]|[12]\d|3[01]))|(((1[6-9]|[2-9]\d)\d{2})-(0?[13456789]|1[012])-(0?[1-9]|[12]\d|30))|(((1[6-9]|[2-9]\d)\d{2})-0?2-(0?[1-9]|1\d|2[0-8]))|(((1[6-9]|[2-9]\d)(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00))-0?2-29-))$/.test($pintu);
            break;
        case"datetime":
            return /^((((1[6-9]|[2-9]\d)\d{2})-(0?[13578]|1[02])-(0?[1-9]|[12]\d|3[01]))|(((1[6-9]|[2-9]\d)\d{2})-(0?[13456789]|1[012])-(0?[1-9]|[12]\d|30))|(((1[6-9]|[2-9]\d)\d{2})-0?2-(0?[1-9]|1\d|2[0-8]))|(((1[6-9]|[2-9]\d)(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00))-0?2-29-)) (20|21|22|23|[0-1]?\d):[0-5]?\d:[0-5]?\d$/.test($pintu);
            break;
        case"idcard":
            return /^(\d{6})(\d{4})(\d{2})(\d{2})(\d{3})([0-9]|X)$/.test($pintu);
            break;
        case"bigenglish":
            return /^[A-Z]+$/.test($pintu);
            break;
        case"smallenglish":
            return /^[a-z]+$/.test($pintu);
            break;
        case"color":
            return /^#[0-9a-fA-F]{6}$/.test($pintu);
            break;
        case"ascii":
            return /^[\x00-\xFF]+$/.test($pintu);
            break;
        case"md5":
            return /^([a-fA-F0-9]{32})$/.test($pintu);
            break;
        case"zip":
            return /(.*)\.(rar|zip|7zip|tgz)$/.test($pintu);
            break;
        case"img":
            return /(.*)\.(jpg|gif|ico|jpeg|png)$/.test($pintu);
            break;
        case"doc":
            return /(.*)\.(doc|xls|docx|xlsx|pdf)$/.test($pintu);
            break;
        case"mp3":
            return /(.*)\.(mp3)$/.test($pintu);
            break;
        case"video":
            return /(.*)\.(rm|rmvb|wmv|avi|mp4|3gp|mkv)$/.test($pintu);
            break;
        case"flash":
            return /(.*)\.(swf|fla|flv)$/.test($pintu);
            break;
        case"radio":
            var radio = element.closest("form").find('input[name="' + element.attr("name") + '"]:checked').length;
            return eval(radio == 1);
            break;
        default:
            var $test=type.split('#');
            if($test.length>1){
                switch($test[0]){
                    case "compare":
                        return eval(Number($pintu)+$test[1]);
                        break;
                    case "regexp":
                        return new RegExp($test[1],"gi").test($pintu);
                        break;
                    case "length":
                        var $length;
                        if(element.attr("type")=="checkbox"){
                            $length=element.closest('form').find('input[name="'+element.attr("name")+'"]:checked').length;
                        }else{
                            $length=$pintu.replace(/[\u4e00-\u9fa5]/g,"***").length;
                        }
                        return eval($length+$test[1]);
                        break;
                    case "ajax":
                        var $getdata;
                        var $url=$test[1]+$pintu;
                        $.ajaxSetup({async:false});
                        $.getJSON($url,function(data){
                            $getdata=data.status;
                        });
                        if($getdata=="1"){return true;}
                        break;
                    case "repeat":
                        return $pintu==jQuery('input[name="'+$test[1]+'"]').eq(0).val();
                        break;
                    default:return true;break;
                }
                break;
            }else{
                return true;
            }
    }
};

/***
 * 鍊掕鏃跺嚱鏁�
 * @type {{obj: number, time: number, dec_time: Function}}
 */
var DecTime = {
    obj:0,
    time:0,
    dec_time : function(){
        if(this.time > 0){
            this.obj.text(this.time--+'S')
            setTimeout("DecTime.dec_time()",1000)
        }else{
            this.obj.text("鑾峰彇楠岃瘉鐮�")
            this.obj.attr('disabled',false)
        }

    }
}



var baidumap = {
        showid : 'baidumap',
        points :'',
        map:'',
        show:function(){
            this.addMap();
        },
        clearOverlays:function(){
            //鍒犻櫎鎵€鏈夋敞閲婅妭鐐�
            this.map.clearOverlays();
        },
        addPoint:function(x,y){

            var point = new BMap.Point(x, y);//榛樿
            //鍒涘缓鏍囨敞瀵硅薄骞舵坊鍔犲埌鍦板浘
            var marker = new BMap.Marker(point);
            this.map.addOverlay(marker);

            marker.addEventListener("click",getAttr);
            function getAttr(){
                var p = this.getPosition();       //鑾峰彇marker鐨勪綅缃�
                //alert("marker鐨勪綅缃槸" + p.lng + "," + p.lat);
                console.log("marker鐨勪綅缃槸" + p.lng + "," + p.lat);
            }

            marker.setAnimation(BMAP_ANIMATION_BOUNCE); //璺冲姩鐨勫姩鐢�


        },
        addPoints:function(){

            this.addPoint();

        },

        addMap :function(){
            //---------------------------------------------鍩虹绀轰緥---------------------------------------------
            this.map = new BMap.Map(this.showid);            // 鍒涘缓Map瀹炰緥
            var map  = this.map;
            //map.centerAndZoom("鎴愰兘",12);                     // 鍒濆鍖栧湴鍥�,璁剧疆涓績鐐瑰潗鏍囧拰鍦板浘绾у埆銆�
            map.centerAndZoom(new BMap.Point(116.404, 39.915), 5);

            map.enableScrollWheelZoom(true);   //鍚敤婊氳疆鏀惧ぇ缂╁皬锛岄粯璁ょ鐢�
            map.addControl(new BMap.NavigationControl());        // 娣诲姞骞崇Щ缂╂斁鎺т欢

            map.addEventListener("click", function(e){

                //map.clearOverlays();
                //document.getElementById("r-result").innerHTML = e.point.lng + ", " + e.point.lat;
                //var point = new BMap.Point(e.point.lng, e.point.lat);//榛樿
                // 鍒涘缓鏍囨敞瀵硅薄骞舵坊鍔犲埌鍦板浘
                //var marker = new BMap.Marker(point);
                //map.addOverlay(marker);

            });

        },
        loadScript :function () {
            var head = document.head || document.getElementsByTagName('head')[0];
            var script = document.createElement("script");
            script.src = "http://api.map.baidu.com/api?v=1.4&callback=";//鍒犻櫎鍥炶皟鍑芥暟 initialize
            //document.body.appendChild(script);
            head.appendChild(script);

        },
        setCenter:function(x,y){

            this.map.setCenter(x,y);

        }
    }


;(function($, window, document,undefined) {



    $(function () {
        /**
         * 鍙戦€侀獙璇佺爜淇℃伅
         */
        $("[data-role='getVerify']").click(function () {

            var $this = $(this);
            var phone = $($this.attr('data-phone')).val();
            var verify =$($this.attr('data-verify')).val();
            var url = $this.attr('data-verify-send');
            var dec_time = $this.attr('data-verify-time');

            if(phone == ''){
                layer.msg('璇疯緭鎵嬫満鍙�');
                return false;
            }
            if(url == ''){
                url = xbui.sendVerify_url ;
            }

            /**鍙戠煭淇￠渶瑕佸浘鐗囬獙璇佺爜鏃跺紑鍚�, 浠ュ悗**/
            if( $($this.attr('data-verify')).length && verify == ''){
                layer.msg('璇疯緭鍏ュ浘鐗囬獙璇佺爜');
                return false;
            }

            $.post(url, {tel: phone,verify:verify}, function (res) {
                if (res.status) {
                    DecTime.obj = $this
                    DecTime.time = dec_time;
                    DecTime.dec_time();
                }
                layer.msg(res.info);

            })
        })


    })
    /**
     * 鎷艰鍐呭缁勭殑鏂规硶
     * @param conten
     * @returns {string}
     */
    function get_content(conten){

        var data_content_arr = conten.split('#');

        var content = '';

        $.each(data_content_arr,function(i,v){ // 鑾峰彇鏈変釜椤圭洰闇€瑕佸悎骞�

            var data_content_arr_2 = v.split(':');
            var arr_ii = data_content_arr_2[0] +":";
            $.each($("[data-group='"+ data_content_arr_2[1] +"']"),function(iii,vvv){
                arr_ii += $(vvv).val() ;
            });
            content += arr_ii + " " ;
        });

        return content;

    }

    /**
     * 灏忓叺鏍￠獙
     * @param options
     */
    $.fn.xbValidform = function(options) {
        var defaults = {
            'form': 'form',
            'formReset': 'form-reset',
            'fun_success':null
        };
        var settings = $.extend({},defaults, options);//灏嗕竴涓┖瀵硅薄鍋氫负绗竴涓弬鏁�

        $(settings.form + ' textarea, input, select').blur(function(){
            var e=$(this);

            if(e.attr("data-validate")){
                e.closest('.field').find(".input-help").remove();
                var $checkdata=e.attr("data-validate").split(',');
                var $checkvalue=e.val();
                var $checkstate=true;
                var $checktext="";
                if(e.attr("placeholder")==$checkvalue){  $checkvalue=""; }
                if($checkvalue!="" || e.attr("data-validate").indexOf("required")>=0){
                    for(var i=0;i<$checkdata.length;i++){
                        var $checktype=$checkdata[i].split(':');
                        if(! $pintuercheck(e,$checktype[0],$checkvalue)){
                            $checkstate=false;
                            $checktext= $checktext + $checktype[1] + '\r' ;
                            break ; //鏈変竴涓敊璇氨璺冲嚭
                        }
                    }
                };
                e.attr("data-validate-checkstate",$checkstate);
                if(!$checkstate){
                    //alert($checktext);
                    layer.msg($checktext);
                }
            }
        });

        $(settings.form).submit(function(){

            var $form =  $(this);

            //$form.find('input[data-validate],textarea[data-validate],select[data-validate]').trigger("blur");
            $form.find('input[data-validate],textarea[data-validate],select[data-validate]').each(function(index, domEle){
                $(domEle).trigger("blur");
                //濡傛灉閬囧埌閿欒,灏辨彁绀�,鐩存帴璺冲嚭
                if($(domEle).attr('data-validate-checkstate') == 'false'){
                    return false;
                }

            });

            var numError = $form.find('[data-validate-checkstate=false]').length;

            if(numError){
                return false;
            }

            //鑷姩 ajax-post 鎻愪氦琛ㄥ崟
            if($form.hasClass('ajax-post')){
                //alert('ajax-post');
                var actionUrl = $form.attr('action');
                var data_groups = $form.find('input[data-groups]');
                $.each(data_groups,function(){
                    var contnt = $(this).attr('data-groups');
                    contnt = get_content(contnt)
                    $(this).val(contnt);
                });

                var data = $form.serialize();
                console.log(data);

                $.post(actionUrl,$form.serialize(),function(data){
                    //{info: "鐣欒█鎴愬姛!", status: 1, url: ""}

                    if(data.status){
                        layer.msg(data.info);

                        //璋冪敤鑷畾涔夊嚱鏁�
                        var init = settings.fun_success ;
                        init && init.call($);

                        $form[0].reset(); //閲嶇疆琛ㄥ崟

                    }else{
                        layer.msg(data.info);
                    }

                    //todo 褰搖rl涓嶄负绌烘椂璺宠浆鎸囧畾椤甸潰
                    if (data.url) {
                        location.href=data.url;
                    }


                });


                return false;
            }else{
                layer.msg("POST鎻愪氦琛ㄥ崟澶辫触!");
                return false ;
            }


        });

        $(settings.formReset).click(function(){
            layer.msg('form-reset');
        });

        if($(this).attr('type') != 'submit'){

            $(this).click(function(){
                $(settings.form).submit();
            });

        }



    }

    /**璐墿杞︾鐞�**/
    $.fn.setAmount = function(options){
        var $this =  $(this);

        var defaults = {
            'numElement': '#buy-num',
            'minNum': 1,
            'maxNum': 99,
            'reduceElement':'#buy-reduce',
            'addElement':'#buy-add',
            'idElement':'#buy-id',
            'titleElement':'#buy-title',
            'coverElement':'#buy-cover',
            'priceElement':'#buy-price',
            'unitElement':'#buy-unit'


        };
        var settings = $.extend({},defaults, options);//灏嗕竴涓┖瀵硅薄鍋氫负绗竴涓弬鏁�


        $(settings.reduceElement).click(function(){
            var num = parseInt($(settings.numElement).val()) - 1;
            if(num <= settings.minNum) {
                num = settings.minNum ;
            }
            $(settings.numElement).val(num);
        });
        $(settings.addElement).click(function(){
            var num = parseInt($(settings.numElement).val()) + 1;
            if(num <= settings.minNum) {
                num = settings.minNum ;
            }
            $(settings.numElement).val(num);

        });


        $this.click(function(){
            $.cookie.json = true;


            var objes = new Array() ,new_objes = new Array() , obj = {
                'id':$(settings.idElement).val(),
                'title':$(settings.titleElement).val(),
                'cover':$(settings.coverElement).val(),
                'price':$(settings.priceElement).val(),
                'num':$(settings.numElement).val(),
                'unit':$(settings.unitElement).val()
            } ;

            objes = $.cookie('shoppingcart');
            if(objes == undefined)  objes = new Array();
            var length = objes.length ;
            for(var i = 0;i < length ; i++ ){
                if(objes[i].id != obj.id ){
                    new_objes.push(objes[i]);
                }
            }


            new_objes.push(obj);
            //alert(JSON.stringify(new_objes));

            $.cookie('shoppingcart', new_objes,{path: "/", domin:"*.6store.cn"});
            layer.msg('娣诲姞鎴愬姛');
        });



    }



})(jQuery, window, document);
