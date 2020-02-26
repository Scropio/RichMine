<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0"/>
    <meta name="format-detection" content="telephone=no,email=no,date=no,address=no">
    <link rel="stylesheet" type="text/css" href="/Public/app/css/aui.css" />
    <link rel="stylesheet" type="text/css" href="/Public/site/css/style.css">
    <title>转出</title>
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
<div class="aui-content">
    <div class="user-top">
        <img src="/Public/site/images/user.png">
        <p>用户名：<span style="color: #55D591"><?php echo ($userInfo['data']['data']['username']); ?></span></p>
        <p>普通用户：<?php echo ($userInfo['data']['data']['aibi']); ?></p>
    </div>
    <div style="position: absolute;top: 20px;right: 30px;">
        <p style="color: white;" onclick="window.location.href='/index.php/home/index/zhuanzengjilu'">转增记录</p>
    </div>
</div>

<div class="aui-content-padded" >
    <div class="aui-row" style="margin-bottom: 10px;">
        <form action="/index.php/home/index/dozhuanchu" method="post" onsubmit="return check()">
            <input type="hidden" id="aibi" name="aibi" value="<?php echo ($userInfo['data']['data']['aibi']); ?>">
            <div class="aui-col-xs-12 aui-list aui-form-list" style="margin-top:20px;margin-bottom: 10px;background-color: rgba(0, 0, 0, .55);">
                <div class="aui-list-item-inner" style="padding-left: 10px;">
                    <div class="aui-list-item-label-icon">
                        <i class="aui-iconfont aui-icon-my" style="color: white;"></i>
                    </div>
                    <div class="aui-list-item-input">
                        <input type="text" id="nums" name="nums" placeholder="请输入转出数量">
                    </div>
                </div>
            </div>

            <div class="aui-col-xs-12 aui-list aui-form-list" style="margin-bottom: 10px;background-color: rgba(0, 0, 0, .55);">
                <div class="aui-list-item-inner" style="padding-left: 10px;">
                    <div class="aui-list-item-label-icon">
                        <i class="aui-iconfont aui-icon-my" style="color: white;"></i>
                    </div>
                    <div class="aui-list-item-input">
                        <input type="text" id="username" name="username" placeholder="请输入对方编号">
                    </div>
                </div>
            </div>

            <div class="aui-col-xs-12 aui-list aui-form-list" style="margin-bottom: 10px;background-color: rgba(0, 0, 0, .55);">
                <div class="aui-list-item-inner" style="padding-left: 10px;">
                    <div class="aui-list-item-label-icon">
                        <i class="aui-iconfont aui-icon-my" style="color: white;"></i>
                    </div>
                    <div class="aui-list-item-input">
                        <input type="password" id="paypassword" name="paypassword" placeholder="请输入二级密码">
                    </div>
                </div>
            </div>

            <p><input type="submit" value="确认" class="aui-btn aui-btn-block aui-btn-sm" style="background: #FF7F00;color: white" /></p>
        </form>
    </div>
</div>

<?php echo W('Tab/Index');?>
</body>

<script src="/Public/app/script/jquery.min.js"></script>
<script type="text/javascript" src="/Public/app/script/aui-toast.js" ></script>

<script>
    apiready = function(){
        api.parseTapmode();
    };

    var toast = new auiToast();

    if('<?php echo ($msg); ?>')
    {
        toast.success({
            title:decodeURI('<?php echo ($msg); ?>'),
            duration:2000
        });
    }

    function check(){
        var nums = document.getElementById("nums").value;
        var username = document.getElementById("username").value;
        var paypassword = document.getElementById("paypassword").value;

        var aibi = document.getElementById("aibi").value;

        if(nums == ""){
            toast.success({
                title:decodeURI('请输入转出数量'),
                duration:2000
            });
            return false;
        }
        if(username == ""){
            toast.success({
                title:decodeURI('请输入对方编号'),
                duration:2000
            });
            return false;
        }
        if(paypassword == ""){
            toast.success({
                title:decodeURI('请输入二级密码'),
                duration:2000
            });
            return false;
        }
    }
</script>
</html>