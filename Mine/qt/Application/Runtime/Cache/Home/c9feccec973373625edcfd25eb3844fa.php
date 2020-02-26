<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0"/>
    <meta name="format-detection" content="telephone=no,email=no,date=no,address=no">
    <title>订单处理</title>
    <link rel="stylesheet" type="text/css" href="/Public/app/css/aui.css" />
    <link rel="stylesheet" type="text/css" href="/Public/layui/css/layui.css" />
    <style type="text/css">
        .order-tab{background-color: transparent;}
        .aui-active{color: #FF9326!important;border: 0!important;}
        .aui-tab-item{color: #fff;}
        .order-list{background-color: rgba(100,100,115,0.5); padding: 2%; margin: 2% 0;}
        .order-btn{padding: 0;font-size: 0.6rem;width: 100%;height: 1rem; line-height: 1rem; margin: 5% 0;}
        .order-main1 p{color: #fff; line-height: 2.5;}
        .order-main2{margin-right: 1%;}
        .order-main2 p{color: #fff; line-height: 3; font-size: .6rem;}
        .btn-orange{background-color: #FF9326;color: #fff;}
        .btn-green{background-color: #308E35;color: #fff;}
        .list-box{display: none;}
        .active{display: block;}
        .demo-class .layui-layer-title{background:#000; color:#fff; border: none;}
        .popbox{width: 100%;left: 0;bottom: 0; margin: 0;text-align: center;}
        .popbox2{border-radius: 0;}
        .poptit{padding: 2% 0;}

    </style>

</head>
<!--<?php echo W('Body/Index');?>-->
<!--<?php echo W('Head/Index');?>-->

<style>
    html{width: 100%;height: 100%; }
</style>
<?php echo W('Body/Index');?>
<!--<img src="/Public/site/images/bj.png" alt="" style="position: fixed;width: 100%;height: 100%;z-index: -1;">-->
<header class="aui-bar aui-bar-nav"><img src="/Public/site/images/header.png" style="margin: 0.8rem auto;  display: block; width:28%;"> </header>
<div class="aui-tab order-tab" id="tab">
    <div class="aui-tab-item aui-active">买入</div>
    <div class="aui-tab-item">卖出</div>
</div>

<div class="aui-content" style="overflow: scroll;height: 82%">
    <div class="aui-row">
        <div class="aui-col-xs-12">
            <div class="list-box active" id="active">
                <?php if(is_array($data['data']['data'])): foreach($data['data']['data'] as $key=>$item): ?><div class="aui-row order-list">
                        <div class="aui-col-xs-4">
                            <div class="aui-row order-main1">
                                <p>级别：<?php echo ($item["c_name"]); ?></p>
                                <p>金额：<?php echo ($item["money"]); ?></p>
                            </div>
                        </div>
                        <div class="aui-col-xs-6">
                            <div class="aui-row order-main2">
                                <p>下单时间：<?php echo ($item["create_time"]); ?></p>
                                <p>打款时间：<?php echo ($item["pay_time"]); ?></p>
                                <p>收款时间：<?php echo ($item["shou_time"]); ?></p>
                            </div>
                        </div>
                        <div class="aui-col-xs-2">
                            <div class="aui-row order-main3">
                                <p><div class="aui-btn order-btn btn-orange big-link" aui-popup-for="bottom" onclick="getImage('<?php echo ($item["id"]); ?>')">打款方式</div></p>
                                <p><div class="aui-btn order-btn btn-green"><?php echo ($item["match_status"]); ?></div></p>
                                <p><div class="aui-btn order-btn btn-green" onclick="window.location.href='/index.php/home/index/shensu?order_id=<?php echo ($item["order_id"]); ?>'">申诉</div></p>
                                <p><div class="aui-btn order-btn btn-orange" onclick="window.location.href='/index.php/home/index/pipeixiangqing?match_time=<?php echo ($item["match_time"]); ?>&id=<?php echo ($item["id"]); ?>&order_type=0'">查看详情</div></p>
                            </div>
                        </div>
                    </div><?php endforeach; endif; ?>

                <!--page2-->



            </div>
            <div class="list-box maichu" id="maichu">
                <?php if(is_array($data['data']['data2'])): foreach($data['data']['data2'] as $key=>$item): ?><div class="aui-row order-list">
                        <div class="aui-col-xs-4">
                            <div class="aui-row order-main1">
                                <p>级别：<?php echo ($item["c_name"]); ?></p>
                                <p>金额：<?php echo ($item["money"]); ?></p>
                            </div>
                        </div>
                        <div class="aui-col-xs-6">
                            <div class="aui-row order-main2">
                                <p>下单时间：<?php echo ($item["create_time"]); ?></p>
                                <p>打款时间：<?php echo ($item["pay_time"]); ?></p>
                                <p>收款时间：<?php echo ($item["shou_time"]); ?></p>
                            </div>
                        </div>
                        <div class="aui-col-xs-2">
                            <div class="aui-row order-main3">
                                <p><div class="aui-btn order-btn btn-orange" onclick="getImage('<?php echo ($item["id"]); ?>')">打款方式</div></p>
                                <p><div class="aui-btn order-btn btn-green"><?php echo ($item["match_status"]); ?></div></p>
                                <p><div class="aui-btn order-btn btn-green" onclick="window.location.href='/index.php/home/index/shensu?order_id=<?php echo ($item["order_id"]); ?>'">申诉</div></p>
                                <p><div class="aui-btn order-btn btn-orange" onclick="window.location.href='/index.php/home/index/pipeixiangqing?match_time=<?php echo ($item["match_time"]); ?>&id=<?php echo ($item["id"]); ?>&order_type=1'">查看详情</div></p>
                            </div>
                        </div>
                    </div><?php endforeach; endif; ?>
            </div>

        </div>
    </div>




</div>
<div class="" id="box1" style="display: none;">
    <img src="/Public/site/images/header.png" id="dkimg" alt="" style="display: block; margin: 0 auto; width: 80%; height: 50%; padding: 10%;">
</div>
<script type="text/javascript" src="/Public/app/script/aui-tab.js" ></script>
<script src="/Public/app/script/jquery.min.js"></script>
<script type="text/javascript" src="/Public/app/script/aui-popup.js" ></script>
<script type="text/javascript" src="/Public/layui/layui.all.js"></script>
<script type="text/javascript" src="/Public/app/script/aui-scroll.js"></script>
<script type="text/javascript" src="/Public/app/script/template-web.js"></script>

<script type="text/javascript">
    var stop1=true;//触发开关，防止多次调用事件
    var stop2=true;//触发开关，防止多次调用事件

    var scroll = new auiScroll({
        listen:false, //是否监听滚动高度，开启后将实时返回滚动高度
        distance:0 //判断到达底部的距离，isToBottom为true
    },function(ret){
        // console.log(ret);
        if(ret.isToBottom){
            // 下一页
            b = $(".aui-active").attr('data-item-order');
            if(b == 1){
                p = getCookie('next2');

                if(stop2==true){
                    stop2=false;
                    $.get("/index.php/home/index/trade?page="+p+"&b="+b,function(data){

                        $("#maichu").append(data);//把新的内容加载到内容的后面

                        if(data){
                            stop2=true;
                        }else{
                            stop2=false;
                        }
                    })
                }
            }else{
                p = getCookie('next1');

                if(stop1==true){
                    stop1=false;
                    $.get("/index.php/home/index/trade?page="+p+"&b="+b,function(data){

                        $("#active").append(data);//把新的内容加载到内容的后面

                        if(data){
                            stop1=true;
                        }else{
                            stop1=false;
                        }
                    })
                }
            }
        }
    });

    //读取cookies
    function getCookie(name){
        var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");

        if(arr=document.cookie.match(reg))
            return unescape(arr[2]);
        else
            return null;
    }

</script>

<script>
    //一般直接写在一个js文件中
    var getImage = function (id) {

        layui.use('layer', function(){
            var layer = layui.layer;

            //console.log(id);

            $.ajax({
                cache : false,
                type : 'get',
                dataType: 'json',
                //url : '<?php echo ($host_name); ?>/api.php/api/Match/images',
                url : '/index.php/home/index/getdkimg?id='+id,
                success : function(data){

                    $('#dkimg').attr('src',data.host_name+'/'+data.data.data.data.image);
                    layer.open({
                        type: 1,
                        closeBtn: 1,
                        shift: 2,
                        offset: 'b',
                        title:'打款凭证',
                        shadeClose: true,
                        content: $("#box1"),
                        area:['100%','100%'],
                        skin:'layui-layer-lan',
                    });
                }
            });
        });
    }

</script>

<script type="text/javascript">
    var tab = new auiTab({
        element:document.getElementById("tab"),
        index:1,
        repeatClick:false
    },function(ret){
        //console.log(ret);
    });

    //tab切换
    $(function(){
        $(".aui-tab-item").off("click").on("click",function(){
            var index = $(this).index();
            //$(this).addClass("on").siblings().removeClass("on");
            $(".list-box").eq(index).addClass("active").siblings().removeClass("active");
        });
    });
</script>

<?php echo W('Tab/Index');?>

</body>

</html>