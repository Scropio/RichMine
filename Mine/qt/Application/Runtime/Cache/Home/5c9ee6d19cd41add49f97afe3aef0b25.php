<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0"/>
    <meta name="format-detection" content="telephone=no,email=no,date=no,address=no">
    <title>用户登录</title>
    <link rel="stylesheet" type="text/css" href="/Public/app/css/aui.css" />
    <script src="/Public/app/script/jquery.min.js"></script>
    <style>
        html{width: 100%;height: 100%; }
        .loginBtn{background-color: #F48EB6;text-align: center;border: solid 1px #F27BB2;color: #fff;box-shadow: 3px 3px 5px #ADACA4;}
    </style>
</head>
<body style='background-image: url("/Public/site/images/login-bg.png");background-repeat: no-repeat ;-webkit-background-size: cover;
 background-size: cover;background-position:center;background-attachment:fixed;'>

    <div class="aui-content-padded">
        <div style="position: fixed;bottom:31%;right:15%;left: 15%;">

            <div class="aui-row" style="margin-bottom: 10px;">
                <div class="aui-col-xs-12 aui-list aui-form-list" style="margin-bottom: 10px;background-color: rgba(255, 255, 255, .55); border: 1px solid #94DAFB; height:2.1rem;">
                    <div class="aui-list-item-inner" style="padding-left: 10px;">
                        <div class="aui-list-item-label-icon">
                            <i class="aui-iconfont aui-icon-my" style="color: #333;"></i>
                        </div>
                        <div class="aui-list-item-input">
                            <input type="text" id="username" value="<?php echo ($username); ?>" placeholder="请输入账号" style="color: #333;">
                        </div>
                    </div>
                </div>
                <div class="aui-col-xs-12 aui-list aui-form-list" style="margin-bottom:0px;background-color: rgba(255, 255, 255, .55); border: 1px solid #94DAFB; height:2.1rem; ">
                    <div class="aui-list-item-inner" style="padding-left: 10px;">
                        <div class="aui-list-item-label-icon">
                            <i class="aui-iconfont aui-icon-lock" style="color: #333;"></i>
                        </div>
                        <div class="aui-list-item-input">
                            <input type="password" id="password" value="<?php echo ($password); ?>" placeholder="请输入密码" style="color: #333;">
                        </div>
                    </div>
                </div>
            </div>

            <div class="aui-row" style="margin-bottom:0px; ">
                <div class="aui-col-xs-6" style="height:1rem; color: white; text-align: center; width: 100%; text-indent: 1rem;" onclick="window.location.href='/index.php/home/user/register'">
                    <span style="font-size: 0.8rem;  text-align:center;color: #18B0F5; ">账号注册</span>
                    <label style="color: #18B0F5;"><input type="checkbox" id="remeber" value="1" <?php if($username) echo checked; ?>> 记住密码</label>
                </div>
<!--                <div class="aui-col-xs-6" style="text-align: left;color: white;padding-left: 10px;">-->
<!--                    <span style="font-size: 0.6rem; float: left; " >忘记密码</span>-->
<!--                </div>-->
            </div>

<!--            <div style=" text-align: center; color: #94DAFB; width: 100%; line-height: 2rem;">-->
<!--                <label><input type="checkbox" id="remeber" value="1" <?php if($username) echo checked; ?>> 记住密码</label>-->
<!--            </div>-->

            <div class="aui-row">
                <div class="aui-col-xs-4">&nbsp;</div>
                <div class="aui-col-xs-4" style="margin-top: 0.5rem; padding-bottom: 0.2rem;">
                    <button class="loginBtn" onclick="window.location.href='/index.php/home/user/doLogin?username='+$('#username').val() +'&password='+$('#password').val()+'&remeber='+$('#remeber').val()">立即登录</button>
                </div>
                <div class="aui-col-xs-4">&nbsp;</div>
            </div>
        </div>

    </div>

</body>

<script type="text/javascript" src="/Public/app/script/aui-toast.js"></script>
<script>

    // window.onload = function()
    // {
    //     alert('公告：亲爱的葫芦兄弟的家人们大家好，由于葫芦兄弟在上线内测期间产生的部分问题，现问题已经查明，隐身娃脚本出现故障，现平台回收隐身娃并且销毁，给用户造成不便，现平台决定补偿用户每人50葫芦，并且开放注册赠送葫芦2天截止日期2019年7月17日。--葫芦兄弟运营团队');
    // }

    apiready = function(){
            api.parseTapmode();
    };

    var toast = new auiToast();

    if('<?php echo ($err_msg); ?>')
    {
        toast.fail({
            title:decodeURI('<?php echo ($err_msg); ?>'),
            duration:2000
        });
    }
</script>
</html>