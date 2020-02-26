<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0"/>
    <meta name="format-detection" content="telephone=no,email=no,date=no,address=no">
    <link rel="stylesheet" type="text/css" href="/Public/app/css/aui.css" />
    <link rel="stylesheet" type="text/css" href="/Public/site/css/style.css">
    <title>修改登录密码</title>
    <style>
        .aq{background-color: transparent;margin-top: 5%;border: 0!important;}
        .aq:before,.aq:after{border: 0!important;}
        .aq li:before,.aq li:after{border: 0!important;}
        .aq li{background-color: rgb(115,115,115,0.5);border: 0!important;}
        .aq li:active{background-color: rgb(115,115,115,0.5)!important;}
        .aq input{color: #fff!important;}
        .pwd-btn{background-color: #FF7F00;border: 0;}
        .pwd-btn:active{background-color: #FF7F00;}
    </style>
</head>
<?php echo W('Body/Index');?>
<div class="aui-content-padded" style="overflow: scroll;height: 90%;">

    <form action="/index.php/home/index/dologinpwd" method="post">
    <ul class="aui-list aui-list-in aq">
        <li class="aui-list-item aui-list-item-middle aui-margin-b-15">
            <div class="aui-list-item-inner">
                <div class="aui-list-item-input">
                    <input type="password" name="oldpassword" placeholder="请输入原密码">
                </div>
            </div>
        </li>
        <li class="aui-list-item aui-margin-b-15">
            <div class="aui-list-item-inner">
                <div class="aui-list-item-input">
                    <input type="password" name="newpassword" placeholder="新密码为数字、英文的组合">
                </div>
            </div>
        </li>
        <li class="aui-list-item aui-margin-b-15">
            <div class="aui-list-item-inner">
                <div class="aui-list-item-input" style="color: #f00">
                    <input type="password" name="newpassword2" placeholder="确认新密码" >
                </div>
            </div>
        </li>       
        <li class="aui-list-item aui-margin-b-15">
            <div class="aui-list-item-inner">
                <div class="aui-list-item-input" style="color: #f00">
                    <input type="text" name="sendCode"  id="sendCode" placeholder="验证码" style="width: 50%;float: left;">
                        <button type="button" onclick="senduploginCode(this)"
		                       id="send-code" style="    height: 40px;" >发送验证码
		                </button>
                </div>
            </div>
        </li>
        <p><button type="submit" class="aui-btn aui-btn-success aui-btn-block pwd-btn">修改登录密码</button></p>
    </ul>

    </form>

</div>

<?php echo W('Tab/Index');?>
<script src="/Public/app/script/jquery.min.js"></script>
<script type="text/javascript" src="/Public/app/script/aui-toast.js" ></script>
<script type="text/javascript">
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
    
    function senduploginCode(target) {
        var url ='/index.php/home/user/getuploginCode';// $(target).attr('data-url');
        var mobile = ''; 
        $.post(url, {mobile: mobile}, function (data) {            
            if (data.code == 1) {              
            	 toast.success({
                     title:'短信发送成功',
                     duration:2000
                 });
            }else{
            	toast.fail({
                    title:'短信发送失败',
                    duration:2000
                });
            	return false;
            }
        }, 'json')
    }
</script>
</body>
</html>