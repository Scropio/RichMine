<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0"/>
    <meta name="format-detection" content="telephone=no,email=no,date=no,address=no">
    <link rel="stylesheet" type="text/css" href="/Public/app/css/aui.css" />
    <link rel="stylesheet" type="text/css" href="/Public/site/css/style.css">
    <title>添加银行卡</title>
    <style>
        .aq{background-color: transparent;margin-top: 5%;border: 0!important;}
        .aq:before,.aq:after{border: 0!important;}
        .aq li:before,.aq li:after{border: 0!important;}
        .aq li{background-color: rgb(115,115,115,0.5);border: 0!important;}
        .aq li:active{background-color: rgb(115,115,115,0.5)!important;}
        .aq input{color: #fff!important;}
        .aq select{background-color: transparent!important;color: #fff!important;}
        .info-tit{color: #fff!important;}
        .pwd-btn{background-color: #FF7F00; border: 0;}
        .pwd-btn:active{background-color: #FF7F00;}
        .file {
            position: relative;
            display: inline-block;
            overflow: hidden;
            text-decoration: none;
            text-indent: 0;
            line-height: 20px;
        }
        .file input {
            position: absolute;
            height: 100%;
            width: 100%;
            right: 0;
            top: 0;
            opacity: 0;
        }
        .file:hover {
            background-color: rgba(225,225,225,0.5);
            color: #ccc;
            text-decoration: none;
        }
    </style>

</head>
<?php echo W('Body/Index');?>
<div class="aui-content-padded" style="overflow: scroll;height:88%;">

    <form action="/index.php/home/index/add_dobankcard" method="post" onsubmit="return check()">

        <ul class="aui-list aui-list-in aq">
            <div class="aui-row info-tit">
                收款银行卡开户行
            </div>
            <li class="aui-list-item aui-list-item-middle aui-margin-b-15">
                <div class="aui-list-item-inner">
                    <div class="aui-list-item-input">
                        <select name="type" style="color: #44b85e!important;">
                            <option value="支付宝">支付宝</option>
                            <option value="微信">微信</option>
                            <option value="农业银行">农业银行</option>
                            <option value="中国银行">中国银行</option>
                        </select>
                    </div>
                </div>
            </li>
            <div class="aui-row info-tit">
                <span style="color: red;">*</span> 账号
            </div>
            <li class="aui-list-item aui-margin-b-15">
                <div class="aui-list-item-inner">
                    <div class="aui-list-item-input">
                        <input type="text" name="code" id="code" placeholder="请输入账号">
                    </div>
                </div>
            </li>
            <div class="aui-row info-tit">
                <span style="color: red;">*</span> 姓名
            </div>
            <li class="aui-list-item aui-margin-b-15">
                <div class="aui-list-item-inner">
                    <div class="aui-list-item-input">
                        <input type="text" name="name" id="name" placeholder="请输入姓名">
                    </div>
                </div>
            </li>
            <div class="aui-row info-tit">
                <span style="color: red;">*</span> 手机号 <span style="color:lightcyan">该手机号用来接收系统短信，必填</span>
            </div>
            <li class="aui-list-item aui-margin-b-15">
                <div class="aui-list-item-inner">
                    <div class="aui-list-item-input">
                        <input type="text" name="mobile" id="mobile" placeholder="请输入手机号">
                    </div>
                </div>
            </li>
            <li class="aui-list-item aui-margin-b-15">
            	<div class="aui-list-item-inner">
                    <div class="aui-list-item-input">
                       <input type="text" name="sendCode"  id="sendCode" placeholder="验证码" style="width: 50%;float: left;">
                        <button type="button" onclick="sendbankcardCode(this)"
		                       id="send-code" style="    height: 40px;" >发送验证码
		                </button>
                    </div>
                </div>         
           </li> 
           <li class="aui-list-item aui-margin-b-15">
                <div class="aui-list-item-inner">
                    <div class="aui-list-item-input">
                        <input type="text" name="pwd2" id="pwd2" placeholder="请输入支付密码">
                    </div>
                </div>
            </li>
            <div class="aui-row info-tit">
                收款二维码
            </div>
            <li class="aui-list-item aui-margin-b-15 file">
                <div class="aui-list-item-inner">
                    <div class="aui-list-item-input" style="color: #fff;">
                        点击上传收款二维码
                        <input type="file" onchange="uploadFile()" id="form1" placeholder="点击上传">
                    </div>
                </div>
            </li>
            <img src="" alt="" id="pizhengtu" />
            <input type="hidden" name="img" id="img1" value="" />
            <p><button type="submit" class="aui-btn aui-btn-success aui-btn-block pwd-btn">提交</button></p>
        </ul>

    </form>
</div>

<?php echo W('Tab/Index');?>

<script src="/Public/app/script/jquery.min.js"></script>
<script type="text/javascript" src="/Public/layui/layui.all.js"></script>
<script type="text/javascript" src="/Public/app/script/aui-toast.js" ></script>
<script>
    apiready = function(){
        api.parseTapmode();
    };
 
  var toast = new auiToast(); 
    if('<?php echo ($msg); ?>')
    {
        toast.fail({
            title:decodeURI('<?php echo ($msg); ?>'),
            duration:2000
        });
    }
    /*
        验证
     */
    function check(){
        var code = document.getElementById("code").value;
        var name = document.getElementById("name").value;
        var mobile = document.getElementById("mobile").value;
        var sendCode = document.getElementById("sendCode").value;
        var pwd2 = document.getElementById("pwd2").value;
        var myreg=/^[1][3,4,5,7,8][0-9]{9}$/;
        if(pwd2 == ""){
            toast.success({
                title:decodeURI('请输入支付密码'),
                duration:2000
            });
            return false;
        }   
        if(sendCode == ""){
            toast.success({
                title:decodeURI('请填验证码'),
                duration:2000
            });
            return false;
        }        
        if(code == ""){
            toast.success({
                title:decodeURI('请填写账号'),
                duration:2000
            });
            return false;
        }
        if(name == ""){
            toast.success({
                title:decodeURI('请填写姓名'),
                duration:2000
            });
            return false;
        }
        if(mobile == ""){
            toast.success({
                title:decodeURI('请填写手机号'),
                duration:2000
            });
            return false;
        }
        if (!myreg.test(mobile)) {
            toast.success({
                title:decodeURI('请填写正确的手机号'),
                duration:2000
            });
            return false;
        }
    }
    //上传文件
    function uploadFile(){
        var files = $('#form1')[0].files;
        var data = new FormData();
        if (files) {
            data.append('file',files[0]);
            data.append('token','<?php echo ($token); ?>')
        }
        $.ajax({
            cache : false,
            type : 'post',
            dataType: 'json',
            url : '<?php echo ($host_name); ?>/api.php/api/Match/upload',
            data :data,
            contentType : false,  //  不设置Content-type请求头
            processData : false,  //  不处理发送的数据，因为data值是Formdata对象，不需要对数据做处理
            success : function(data){
                //console.log(data);
                $('#pizhengtu').attr('src','<?php echo ($host_name); ?>'+data.data);
                $('#img1').val(data.data);
            }
        });
    }
    
    function sendbankcardCode(target) {
        var url ='/index.php/home/user/getbankcardCode';// $(target).attr('data-url');
        var mobile = $("#mobile").val();
        if (!mobile) {           
            toast.fail({
                title:'请填写手机号码',
                duration:2000
            });
            return false;
        }
      
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