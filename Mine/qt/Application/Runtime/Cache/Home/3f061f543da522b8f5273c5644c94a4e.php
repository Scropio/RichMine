<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0"/>
    <meta name="format-detection" content="telephone=no,email=no,date=no,address=no">
    <link rel="stylesheet" type="text/css" href="/Public/app/css/aui.css" />
    <link rel="stylesheet" type="text/css" href="/Public/site/css/style.css">
    <title>系统消息</title>
    <style>
        .news{background-color:transparent;}
        .news li{background-color: rgb(115,115,115,0.5)!important;border: 0!important; margin: 4% auto!important;}
        .news li:active{background-color: rgb(115,115,115,0.5)!important;border: 0!important;}
        .info-tit{color: #fff!important;}
        .info-tit p{color: #fff!important;}
    </style>
</head>
<?php echo W('Body/Index');?>
<div class="aui-content" style="overflow: scroll;height: 90%;" >
    <ul class="aui-list aui-media-list news">
        <?php if(is_array($data['data']['data'])): foreach($data['data']['data'] as $key=>$item): ?><li class="aui-list-item">
            <div class="aui-media-list-item-inner">
                <div class="aui-list-item-inner">
                    <div class="aui-list-item-text">
                        <div class="aui-list-item-title info-tit"><?php echo ($item["title"]); ?></div>
                        <div class="aui-list-item-right info-tit"><?php echo ($item["createtime"]); ?></div>
                    </div>
                    <div class="aui-list-item-text aui-ellipsis-2 info-tit">
                        <?php echo ($item["content"]); ?>
                    </div>
                </div>
            </div>
        </li><?php endforeach; endif; ?>
    </ul>
</div>
<?php echo W('Tab/Index');?>
</body>
</html>