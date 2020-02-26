<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0"/>
    <meta name="format-detection" content="telephone=no,email=no,date=no,address=no">
    <link rel="stylesheet" type="text/css" href="/Public/app/css/aui.css" />
    <link rel="stylesheet" type="text/css" href="/Public/site/css/style.css">
    <title>实名认证</title>
    <style>
        .aq{background-color: transparent;margin-top: 5%;border: 0!important;}
        .aq:before,.aq:after{border: 0!important;}
        .aq li:before,.aq li:after{border: 0!important;}
        .aq li{background-color: rgb(115,115,115,0.5);border: 0!important;}
        .aq li:active{background-color: rgb(115,115,115,0.5)!important;}
        .aq input{color: #fff!important;}
        .aq select{background-color: transparent!important;color: #fff!important;}
        .info-tit{color: #fff!important;}
        .pwd-btn{background-color: #FF7F00;border: 0;}
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
<?php echo W('Head/Index');?>
<div class="aui-content-padded" style="overflow: scroll;height: 90%;">

    <form action="/index.php/home/index/doshimingrenzheng" method="post">

        <ul class="aui-list aui-list-in aq">
            <div class="aui-row info-tit" >
                姓名
            </div>
            <li class="aui-list-item aui-margin-b-15">
                <div class="aui-list-item-inner">
                    <div class="aui-list-item-input">
                        <input type="text" name="realname" placeholder="请输入姓名">
                    </div>
                </div>
            </li>
            <div class="aui-row info-tit">
                手机号
            </div>
            <li class="aui-list-item aui-margin-b-15">
                <div class="aui-list-item-inner">
                    <div class="aui-list-item-input">
                        <input type="text" name="mobile" placeholder="请输入手机号">
                    </div>
                </div>
            </li>
            <div class="aui-row info-tit">
                身份证号码
            </div>
            <li class="aui-list-item aui-margin-b-15">
                <div class="aui-list-item-inner">
                    <div class="aui-list-item-input">
                        <input type="text" name="IDcard" placeholder="请输入身份证号码">
                    </div>
                </div>
            </li>
<!--            <div class="aui-row info-tit">-->
<!--                请上传证件正面照-->
<!--            </div>-->
<!--            <li class="aui-list-item aui-margin-b-15 file">-->
<!--                <div class="aui-list-item-inner">-->
<!--                    <div class="aui-list-item-input"  style="color:#fff;">-->
<!--                        点击上传身份证正面-->
<!--                        <input type="file" onchange="uploadFile1()" id="form1" placeholder="点击上传">-->
<!--                        <img src="/Public/site/images/zf" alt="">-->
<!--                    </div>-->
<!--                </div>-->
<!--            </li>-->
<!--            <input type="hidden" name="IDcardimg1" id="IDcardimg1" value="" />-->
<!--            <img src="" alt="" id="pizhengtu1" />-->
<!--            <div class="aui-row info-tit">-->
<!--                请上传身份证件反面照-->
<!--            </div>-->
<!--            <li class="aui-list-item aui-margin-b-15 file">-->
<!--                <div class="aui-list-item-inner">-->
<!--                    <div class="aui-list-item-input" style="color:#fff;">-->
<!--                        点击上传身份证反面-->
<!--                        <input type="file" onchange="uploadFile2()" id="form2" placeholder="点击上传">-->
<!--                    </div>-->
<!--                </div>-->
<!--            </li>-->
<!--            <input type="hidden" name="IDcardimg2" id="IDcardimg2" value="" />-->
<!--            <img src="" alt="" id="pizhengtu2" />-->
            <p><button type="submit" class="aui-btn aui-btn-success aui-btn-block pwd-btn">提交</button></p>
        </ul>

    </form>
</div>

<?php echo W('Tab/Index');?>


<script src="/Public/app/script/jquery.min.js"></script>
<script type="text/javascript" src="/Public/app/script/aui-toast.js" ></script>
<script>
    //上传文件
    function uploadFile1(){
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


    function uploadFile2(){
        var files = $('#form2')[0].files;
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
                $('#pizhengtu2').attr('src','<?php echo ($host_name); ?>'+data.data);
                $('#IDcardimg2').val(data.data);
            }
        });
    }


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
</script>


</body>
</html>