<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0"/>
    <meta name="format-detection" content="telephone=no,email=no,date=no,address=no">
    <link rel="stylesheet" type="text/css" href="/Public/app/css/aui.css" />
    <link rel="stylesheet" type="text/css" href="/Public/site/css/style.css">
    <title>安全中心</title>
    <style>
        *{border: 0!important;}
    .aq{background-color: transparent;margin-top: 5%;border: 0!important;}
    .aq li{background-color: rgb(115,115,115,0.5);border: 0!important;}
    .aq:before,.aq:after{border: 0!important;}
    .aq li:before,.aq li:after{border: 0!important;}
    .aq li:active{background-color: rgb(115,115,115,0.5)!important;}
    .aq-cont{color: #fff!important;}
    </style>
</head>
<?php echo W('Body/Index');?>
<div class="aui-content" style="overflow: scroll;height: 90%;">
    <ul class="aui-list aui-list-in aq">
        <li class="aui-list-item aui-list-item-middle aui-margin-b-15" onclick="window.location.href='/index.php/home/index/uploginpwd'">
            <div class="aui-list-item-inner aui-list-item-arrow">
                <div class="aui-list-item-title aq-cont">修改登录密码</div>
        </li>
        <li class="aui-list-item" onclick="window.location.href='/index.php/home/index/uptwopwd'">
            <div class="aui-list-item-inner aui-list-item-arrow">
                <div class="aui-list-item-title aq-cont">修改二级密码</div>
            </div>
        </li>
    </ul>
</div>

<?php echo W('Tab/Index');?>
</body>
</html>