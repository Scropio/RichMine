<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0"/>
    <meta name="format-detection" content="telephone=no,email=no,date=no,address=no">
    <title>用户注册</title>
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
    <div style="margin-top: 7.2rem;">

        <div class="aui-row" style="margin-bottom: 10px;">
            <div class="aui-col-xs-12 aui-list aui-form-list" style="margin-bottom: 10px;background-color: rgba(0, 0, 0, .55);">
                <div class="aui-list-item-inner" style="padding-left: 10px;">
                    <div class="aui-list-item-label-icon">
                        <i class="aui-iconfont aui-icon-my" style="color: white;"></i>
                    </div>
                    <div class="aui-list-item-input">
                        <input type="text" id="username" placeholder="请输入账号">
                    </div>
                </div>
            </div>
            <div class="aui-col-xs-12 aui-list aui-form-list" style="margin-bottom: 10px;background-color: rgba(0, 0, 0, .55);">
                <div class="aui-list-item-inner" style="padding-left: 10px;">
                    <div class="aui-list-item-label-icon">
                        <i class="aui-iconfont aui-icon-mobile" style="color: white;"></i>
                    </div>
                    <div class="aui-list-item-input">
                        <input type="text" id="mobile" placeholder="请输入手机号码">
                    </div>
                </div>
            </div>
            
             <div class="aui-col-xs-12 aui-list aui-form-list" style="margin-bottom: 10px;background-color: rgba(0, 0, 0, .55);">
                <div class="aui-list-item-inner" style="padding-left: 10px;">
                    <div class="aui-list-item-label-icon">
                        <i class="aui-iconfont aui-icon-my" style="color: white;"></i>
                    </div>
                    <div class="aui-list-item-input">                        
                        <input type="text" name="sendCode"  id="sendCode" placeholder="验证码" style="width: 50%;float: left;">
                        <button type="button" onclick="sendCode(this)"
		                       id="send-code" style="    height: 40px;" >发送验证码
		                </button>
                    </div>
                </div>
            </div>
            <div class="aui-col-xs-12 aui-list aui-form-list" style="margin-bottom: 10px;background-color: rgba(0, 0, 0, .55);">
                <div class="aui-list-item-inner" style="padding-left: 10px;">
                    <div class="aui-list-item-label-icon">
                        <i class="aui-iconfont aui-icon-lock" style="color: white;"></i>
                    </div>
                    <div class="aui-list-item-input">
                        <input type="password" id="password" placeholder="请输入登录密码">
                    </div>
                </div>
            </div>
            <div class="aui-col-xs-12 aui-list aui-form-list" style="margin-bottom: 10px;background-color: rgba(0, 0, 0, .55);">
                <div class="aui-list-item-inner" style="padding-left: 10px;">
                    <div class="aui-list-item-label-icon">
                        <i class="aui-iconfont aui-icon-lock" style="color: white;"></i>
                    </div>
                    <div class="aui-list-item-input">
                        <input type="password" id="repassword" placeholder="确认登录密码">
                    </div>
                </div>
            </div>
            <div class="aui-col-xs-12 aui-list aui-form-list" style="margin-bottom: 10px;background-color: rgba(0, 0, 0, .55);">
                <div class="aui-list-item-inner" style="padding-left: 10px;">
                    <div class="aui-list-item-label-icon">
                        <i class="aui-iconfont aui-icon-my" style="color: white;"></i>
                    </div>
                    <div class="aui-list-item-input">
                        <input type="password" id="paypassword" placeholder="请输入二级密码">
                    </div>
                </div>
            </div>
            <div class="aui-col-xs-12 aui-list aui-form-list" style="margin-bottom: 10px;background-color: rgba(0, 0, 0, .55);">
                <div class="aui-list-item-inner" style="padding-left: 10px;">
                    <div class="aui-list-item-label-icon">
                        <i class="aui-iconfont aui-icon-my" style="color: white;"></i>
                    </div>
                    <div class="aui-list-item-input">
                        <input type="password" id="repaypassword" placeholder="确认二级密码">
                    </div>
                </div>
            </div>
            <div class="aui-col-xs-12 aui-list aui-form-list" style="margin-bottom: 20px;background-color: rgba(0, 0, 0, .55);">
                <div class="aui-list-item-inner" style="padding-left: 10px;">
                    <div class="aui-list-item-label-icon">
                        <i class="aui-iconfont aui-icon-my" style="color: white;"></i>
                    </div>
                    <div class="aui-list-item-input">
                        <input type="text" id="rename" value="<?php echo ($code); ?>" placeholder="请输入推荐人账号">
                    </div>
                </div>
            </div>
        </div>

        <div class="aui-row">
            <div class="aui-col-xs-4">&nbsp;</div>
            <div class="aui-col-xs-4" style="text-align: center;">
                <button class="loginBtn" onclick="register()">立即登录</button>
            </div>
            <div class="aui-col-xs-4">&nbsp;</div>
        </div>
    </div>

</div>
<script type="text/javascript" src="/Public/app/script/aui-toast.js" ></script>
<script>

    apiready = function(){
        api.parseTapmode();
    }

    var toast = new auiToast();

    var register = function() {
  
    	 var sendCode = $("#sendCode").val();
         if (!sendCode) {           
             toast.fail({
                 title:'请填写验证码',
                 duration:2000
             });
             return false;
         }      
         var username_temp = document.getElementById('username').value;
         if(!(/^1[34578]\d{9}$/.test(username_temp))){  
             toast.fail({
                 title:'账号必须是手机号',
                 duration:2000
             });
             return false; 

         } 
        
        //验证两次密码是否一致
        if($('#password').val() != $('#repassword').val())
        {
            toast.fail({
                title:'两次登录密码不一致',
                duration:2000
            });
        }else
        {
            //判断两次二级密码不一致
            if($('#paypassword').val() != $('#repaypassword').val())
            {
                toast.fail({
                    title:'两次二级密码不一致',
                    duration:2000
                });
            }else
            {
                $.ajax({

                    url:'/index.php/home/user/doRegister',
                    dataType:'',
                    data:{'username':$('#username').val(),'mobile':$('#mobile').val(),'password':$('#password').val(),'paypassword':$('#paypassword').val(),'rename':$('#rename').val(),'code':$('#code').val(),'sendCode':$('#sendCode').val()},
                    type:"POST",
                    beforeSend:function()
                    {
                        toast.loading({
                            title:"请求中...",
                            duration:2000
                        },function(ret){
                            console.log(ret);
                            setTimeout(function(){
                                toast.hide();
                            }, 5000)
                        });
                    },
                    success:function (result) {

                        toast.hide();

                        if(result.code)
                        {
                            toast.success({
                                title:result.msg,
                                duration:2000
                            });

                           // window.location.href = '/index.php/home/user/login';
                            window.location.href="http://app.inspeed.com.cn";

                        }else
                        {
                            toast.fail({
                                title:result.msg,
                                duration:2000
                            });
                        }

                    }

                });
            }
        }

    }

    function sendCode(target) {
        var url ='/index.php/home/user/getCode';// $(target).attr('data-url');
        var mobile = $("#mobile").val();
        if (!mobile) {           
            toast.fail({
                title:'请填写手机号码',
                duration:2000
            });
            return false;
        }
        //mui.showLoading("发送中..", "div");
        $.post(url, {mobile: mobile}, function (data) {            
            if (data.code == 1) {
               // $("#send-code").html(120);               
              //  $("#send-code").attr('disabled', true); 
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