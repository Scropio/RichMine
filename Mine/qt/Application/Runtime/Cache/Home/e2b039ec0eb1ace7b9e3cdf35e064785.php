<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0"/>
    <meta name="format-detection" content="telephone=no,email=no,date=no,address=no">
    <link rel="stylesheet" type="text/css" href="/Public/app/css/aui.css" />
    <link rel="stylesheet" type="text/css" href="/Public/site/css/style.css">
    <title>名花</title>
    <style type="text/css">
        .grow-main1 img{width: 4.4rem;}
        .grow-main2 p{color: #fff; line-height: 2; }
        .order-list{background-color: rgba(100,100,115,0.5); padding: 2%; margin: 2% 0;}
        .order-main1 p{color: #fff;}
        .order-main2{margin-right: 1%;}
        .order-main2 p{color: #fff;}
    </style>
</head>
<!--<?php echo W('Body/Index');?>-->
<body>
<img src="/Public/site/images/bj.png" alt="" style="position: fixed;width: 100%;height: 100%;z-index: -1;">
<div class="aui-content" >
    <div class="user-top">
        <img src="/Public/site/images/user.png">
        <p>用户名：<span style="color: #55D591"><?php echo ($userInfo['data']['data']['username']); ?></span></p>
        <p>普通用户：<?php echo ($userInfo['data']['data']['aibi']); ?></p>
    </div>
    <div style="position: absolute;top: 20px;right: 30px;">
        <p style="color: white;" onclick="window.location.href='/index.php/home/index/zhuanchu'">转出</p>
    </div>
</div>

<div class="aui-content" style="overflow: scroll;height:76%">
    <div class="aui-row">
        <div class="aui-col-xs-12">
            <div class="list-box" id="box">
                <?php if(is_array($data['data']['data'])): foreach($data['data']['data'] as $key=>$item): ?><div class="aui-row order-list">
                        <div class="aui-col-xs-5">
                            <div class="aui-row order-main1">
                                <p>
                                    <?php if($item["out_userid"] == $userInfo['data']['data']['id']): ?>转账记录
                                        <?php else: ?>
                                        收款记录<?php endif; ?>
                                </p>
                                <p>
                                    <?php if($item["out_userid"] == $userInfo['data']['data']['id']): ?>收款方：<?php echo ($item["in_username"]); ?>
                                        <?php else: ?>
                                        转账方：<?php echo ($item["out_username"]); endif; ?>
                                </p>
                                <p>
                                    数量：<?php echo ($item["nums"]); ?>
                                </p>
                            </div>
                        </div>
                        <div class="aui-col-xs-7">
                            <div class="aui-row order-main2" style="text-align: right">
                                <p><?php echo ($item["createtime"]); ?></p>
                            </div>
                        </div>
                    </div><?php endforeach; endif; ?>
            </div>
        </div>
    </div>
</div>

<?php echo W('Tab/Index');?>
</body>
<script type="text/javascript" src="/Public/app/script/aui-scroll.js"></script>
<script src="/Public/app/script/jquery.min.js"></script>
<script type="text/javascript">
    var stop=true;//触发开关，防止多次调用事件

    var scroll = new auiScroll({
        listen:false, //是否监听滚动高度，开启后将实时返回滚动高度
        distance:0 //判断到达底部的距离，isToBottom为true
    },function(ret){
        // console.log(ret);
        if(ret.isToBottom){
            // 下一页
            p = getCookie('page');

            if(stop==true){
                stop=false;
                $.get("/index.php/home/index/zhuanzengjilu?page="+p,function(data){
                    $("#box").append(data);//把新的内容加载到内容的后面
                    if(data){
                        stop=true;
                    }else{
                        stop=false;
                    }
                })
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
</html>