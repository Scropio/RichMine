<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0"/>
    <meta name="format-detection" content="telephone=no,email=no,date=no,address=no">
    <link rel="stylesheet" type="text/css" href="/Public/app/css/aui.css" />
    <link rel="stylesheet" type="text/css" href="/Public/site/css/style.css">
</head>
<style>
    html{width: 100%;height: 100%; }
</style>
<?php echo W('Body/Index');?>
<div class="aui-content bj" style="overflow: scroll;height: 90%;">
    <div class="user-top">
        <img src="/Public/site/images/user.png">
        <p>名花有主</p>
        <p>用户名：<span style="color: #55D591"><?php echo ($data['data']['data']['username']); ?></span></p>
        <p>激活状态：
            <?php if(($data['data']['data']['active']) == "1"): ?><span style="color: #55D591">已激活</span>
            <?php else: ?>
                <span style="color: #55D591">未激活</span><?php endif; ?>
        </p>
      	<p><?php echo ($data['data']['data']['dai']); ?></p>
    </div>
    <div style="position: absolute;top: 20px;right: 30px;">
<!--        <p style="color: white;" onclick="window.location.href='/index.php/home/user/logout'">退出登录</p>-->
        <p style="color: white;" onclick="openDialog('callback')">退出登录</p>

    </div>

    <div class="user-main user-mains">
        <dl class="flex">
<!--            <dd onclick="window.location.href='/index.php/home/index/pgc'">-->
<!--                <p class="main-tit"><?php echo ($data['data']['data']['pgc']); ?></p>-->
<!--                <p class="main-con">CBC</p>-->
<!--            </dd>-->
            <dd onclick="window.location.href='/index.php/home/index/hulu'">
                <p class="main-tit"><?php echo ($data['data']['data']['aibi']); ?></p>
                <p class="main-con">花粉</p>
            </dd>
            <dd onclick="window.location.href='/index.php/home/index/huluwa'">
                <p class="main-tit"><?php echo ($data['data']['data']['staticmoney']); ?></p>
                <p class="main-con">名花</p>
            </dd>
        </dl>
        <dl class="flex">

            <dd onclick="window.location.href='/index.php/home/index/hulu_shouyi'">
                <p class="main-tit"><?php echo ($data['data']['data']['dynamic_wallet']); ?></p>
                <p class="main-con">名花收益</p>
            </dd>
            <dd onclick="window.location.href='/index.php/home/index/hulu_zongshouyi'">
                <p class="main-tit"><?php echo ($data['data']['data']['dynamic']); ?></p>
                <p class="main-con">名花总收益</p>
            </dd>
        </dl>
        
        <dl class="flex">

            <dd onclick="window.location.href='/index.php/home/index/hulu_shouyi'">
                <p class="main-tit"><?php echo ($data['data']['data']['re_accounts']); ?></p>
                <p class="main-con">直推人数</p>
            </dd>
            <dd onclick="window.location.href='/index.php/home/index/hulu_zongshouyi'">
                <p class="main-tit"><?php echo ($data['data']['data']['re_myteams']); ?></p>
                <p class="main-con">团队人数</p>
            </dd>
        </dl>
    </div>
    <div class="user-main2 user-mains">
        <dl class="flex">
            <dd onclick="window.location.href='/index.php/home/index/hulu_shengzhang'">
                <img src="/Public/site/images/user-icon1.png" >
                <p>名花生长</p>
            </dd>
            <dd onclick="window.location.href='/index.php/home/index/hulu_record'">
                <img src="/Public/site/images/user-icon2.png" >
                <p>名花记录</p>
            </dd>
            <dd onclick="window.location.href='/index.php/home/index/yuyue_chaxun'">
                <img src="/Public/site/images/user-icon3.png" >
                <p>预约查询</p>
            </dd>
            <dd onclick="window.location.href='/index.php/home/index/trade'">
                <img src="/Public/site/images/user-icon4.png" >
                <p>订单处理</p>
            </dd>
        </dl>
    </div>
    <div class="user-main3 user-mains">
        <dl class="flex">
            <dd onclick="window.location.href='/index.php/home/index/anquanzhongxin'">
                <img src="/Public/site/images/user-icon5.png" >
                <p>安全中心</p>
            </dd>
            <dd onclick="window.location.href='/index.php/home/index/shimingrenzheng'">
                <img src="/Public/site/images/user-icon6.png" >
                <p>实名认证</p>
            </dd>
            <dd onclick="window.location.href='/index.php/home/index/yinhangka'">
                <img src="/Public/site/images/user-icon7.png" >
                <p>银行卡</p>
            </dd>
        </dl>
        <dl class="flex">
            <dd onclick="window.location.href='/index.php/home/index/jiu_ye'">
                <img src="/Public/site/images/user-icon8.png" >
                <p>我的花团</p>
            </dd>
            <dd onclick="window.location.href='/index.php/home/index/invite_dy'">
                <img src="/Public/site/images/user-icon9.png" >
                <p>邀请好友</p>
            </dd>
            <dd onclick="window.location.href='/index.php/home/index/xitongxiaoxi'">
                <img src="/Public/site/images/user-icon10.png" >
                <p>系统消息</p>
            </dd>

        </dl>
    </div>
</div>
<script type="text/javascript" src="/Public/app/script/aui-dialog.js" ></script>
<script type="text/javascript">
    var dialog = new auiDialog({});
    function openDialog(type){
        switch (type) {
            case "callback":
                dialog.alert({
                    title:"确认退出吗",
                    buttons:['取消','确定']
                },function(ret){

                    if(2 == ret.buttonIndex)
                    {
                        //向服务器发送请求，开始预约葫芦娃
                        window.location.href = '/index.php/home/user/logout';
                    }

                });
                break;
            default:
                break;
        }
    }
</script>
<?php echo W('Tab/Index');?>
</body>
</html>