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
<?php echo W('Body/Index');?>
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
            <div class="list-box">

                <?php if(is_array($data['data']['data'])): foreach($data['data']['data'] as $key=>$item): ?><div class="aui-row order-list">
                        <div class="aui-col-xs-5">
                            <div class="aui-row order-main1">
                                <p>级别：<?php echo ($item["c_name"]); ?></p>
                                <p>消耗花粉：<?php echo ($item["money"]); ?></p>
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
</html>