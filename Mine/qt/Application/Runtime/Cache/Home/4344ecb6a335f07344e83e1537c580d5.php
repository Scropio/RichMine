<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0"/>
    <meta name="format-detection" content="telephone=no,email=no,date=no,address=no">
    <link rel="stylesheet" type="text/css" href="/Public/app/css/aui.css" />
    <link rel="stylesheet" type="text/css" href="/Public/site/css/style.css">
    <title>邀请花团</title>
</head>
<?php echo W('Body/Index');?>

<div class="aui-content" style="background:url('/Public/app/image/wx2.png') no-repeat; background-repeat: no-repeat ;-webkit-background-size: cover;
 background-size: cover;background-position:center; height: 100%;">
    <div class="aui-row">
        <div class="aui-col-xs-12">
            <img src="<?php echo ($data['data']['data']); ?>" alt="" style="margin: 0 auto;margin-top: 65%;">
        </div>
    </div>
</div>

<?php echo W('Tab/Index');?>
</body>
</html>