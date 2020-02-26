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
    html{width: 100%;height: 100%; padding: 0; margin: 0; }
    .forma{color:#fff; font-size:0.8rem; text-align:left; width:90%; border-top:2px solid #fff; margin: 0 auto; padding-top:0.6rem; margin-top:1.2rem;}
    input::-webkit-input-placeholder,textarea::-webkit-input-placeholder{
        color:#fff;
        font-size:0.7rem;
    }

    input:-moz-placeholder,textarea:-moz-placeholder{
        color:#666;
        font-size:0.7rem;
    }

    input::-moz-placeholder,textarea::-moz-placeholder{
        color:#fff;
        font-size:0.7rem;
    }
    input:-ms-input-placeholder,textarea:-ms-input-placeholder{
        color:#fff;
        font-size:0.7rem;
    }
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
<?php echo W('Body/Index');?>
<?php echo W('Head/Index');?>
<div class="aui-content bj" style="overflow: scroll;height: 90%;">

    <center>
        <div class="aui-card-list-content file">
            <img src="/Public/site/images/shensu.png" alt=""  style="width:40%; margin:0 auto; display: block; margin-top:2rem;">
            <input type="file" onchange="uploadFile()" id="form1" placeholder="点击上传">
        </div>
    </center>
    <img src="" alt="" id="pizhengtu1" />


    <form action="/index.php/home/index/doshensu" method="post" onsubmit="return check()">
        <input type="hidden" name="order_id" id="order_id" value="<?php echo ($order_id); ?>">
        <input type="hidden" name="IDcardimg1" id="IDcardimg1" value="" />

        <h1 style="color:#fff; font-size:0.8rem; text-align:left; width:90%; border-top:2px solid #fff; margin: 0 auto; padding-top:0.6rem; margin-top:1.2rem;" >申诉内容：</h1>
        <textarea name="content" id="content" cols="20" rows="3" placeholder="请输入申诉内容" style="width:90%; border-bottom:2px solid #fff; margin: 0 auto; margin-bottom: 1.5rem;"></textarea>
        <center><input type="submit" value="提交" style="width: 80%; padding:0.5rem 5rem; text-align: center; color:#fff; background-color:#FF9326; border-radius:6px; margin: 0 auto;" /></center>
    </form>


</div>


<?php echo W('Tab/Index');?>
</body>

<script src="/Public/app/script/jquery.min.js"></script>
<script type="text/javascript" src="/Public/app/script/aui-toast.js" ></script>

<!--上传图片-->
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
        var content = document.getElementById("content").value;
        var IDcardimg1 = document.getElementById("IDcardimg1").value;
        var order_id = document.getElementById("order_id").value;

        if(content == ""){
            toast.success({
                title:decodeURI('请输入申诉内容'),
                duration:2000
            });
            return false;
        }
        if(IDcardimg1 == ""){
            toast.success({
                title:decodeURI('请上传凭证'),
                duration:2000
            });
            return false;
        }
        if(order_id == ""){
            toast.success({
                title:decodeURI('请重新选择需要申诉的订单'),
                duration:2000
            });
            return false;
        }
    }

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
                $('#pizhengtu1').attr('src','<?php echo ($host_name); ?>'+data.data);
                $('#IDcardimg1').val(data.data);
            }
        });
    }
</script>
<!--end上传图片-->
</html>