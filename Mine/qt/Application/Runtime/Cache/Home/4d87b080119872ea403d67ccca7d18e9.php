<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
    <?php echo W('Head/Index');?>
    <meta charset="utf-8">
    <meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0"/>
    <meta name="format-detection" content="telephone=no,email=no,date=no,address=no">
    <link rel="stylesheet" type="text/css" href="/Public/app/css/aui.css" />
    <link rel="stylesheet" type="text/css" href="/Public/site/css/style.css">
    <title>匹配详情</title>
    <style>
        .xq-info{background-color: rgba(115,115,100,0.5)!important;margin: 0%!important;padding: 4% 8%!important;}
        .fff{color:#fff!important;}
        .xq-list{margin:2.5% 0!important;}
        .xq-no{background-color: rgba(115,115,100,0.5)!important;margin: 0%!important;padding: 4% 8%!important;}
        .file {
            position: relative;
            display: inline-block;
            overflow: hidden;
            text-decoration: none;
            text-indent: 0;
            line-height: 20px;
            background-color: rgba(225,225,225,0.5);
            color: #ccc;
            text-decoration: none;
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

<?php if(0 != $match_time): ?><div class="aui-content-padded xq-info" style="overflow: scroll;height:88%;">
        <div class="aui-row"  >
            <div class="aui-col-xs-12">
                <div class="aui-text-left xq-list"><span class="fff">订单编号：</span><span class="aui-text-success"><?php echo ($data['data']['data'][0]['order_id']); ?></span></div>
                <div class="aui-text-left xq-list"><span class="fff">花粉：</span><span class="aui-text-success"><?php echo ($data['data']['data'][0]['c_name']); ?></span></div>
                <div class="aui-text-left xq-list"><span class="fff">区块金额：</span><span class="aui-text-success"><?php echo ($data['data']['data'][0]['money']); ?></span></div>
                <div class="aui-text-left xq-list"><span class="fff">领养收益：</span><span class="aui-text-success"><?php echo ($data['data']['data'][0]['grow_day']); ?>天/<?php echo ($data['data']['data'][0]['gains']); ?>%</span></div>
                <div class="aui-text-left xq-list"><span class="fff">转让时间：</span><span class="aui-text-success"><?php echo ($data['data']['data'][0]['create_time']); ?></span></div>
                <div class="aui-text-left xq-list"><span class="fff">转让方：</span><span class="aui-text-success"><?php echo ($data['data']['data'][0]['busername']); ?></span></div>
                <div class="aui-text-left xq-list"><span class="fff">转让方联系电话：</span><span class="aui-text-success"><?php echo ($data['data']['data'][0]['mobile']); ?></span></div>
                <div class="aui-text-left xq-list"><span class="fff">领养方：</span><span class="aui-text-success"><?php echo ($data['data']['data'][0]['username']); ?></span></div>
                <div class="aui-text-left xq-list"><span class="fff">领养方联系电话：</span><span class="aui-text-success"><?php echo ($data['data']['data'][0]['u_mobile']); ?></span></div>
<!--                <div class="aui-text-left xq-list"><span class="fff">区块状态：</span><span class="aui-text-success">1111</span></div>-->
<!--                <div class="aui-text-left xq-list"><span class="fff">收益状态：</span><span class="aui-text-success">1111</span></div>-->
<!--                <div class="aui-text-left xq-list"><span class="fff">申诉状态：</span><span class="aui-text-success">1111</span></div>-->
                <div class="aui-text-left xq-list"><span class="fff">已完成转让方收款账号：</span></div>

                <div class="aui-row">
                    <div class="aui-col-xs-6">
                        <img src="<?php echo ($host_name); echo ($data['data']['data'][0]['img']); ?>" alt="">
                    </div>
                    <div class="aui-col-xs-6">
                        <div style="color: #fff; line-height: 1.5rem; font-size: 0.75rem ">账户名称：<?php echo ($data['data']['data'][0]['bname']); ?></div>
                        <div style="color: #fff; line-height: 1.5rem; font-size: 0.75rem" >账号：<?php echo ($data['data']['data'][0]['bcode']); ?></div>
                        <div style="color: #fff; line-height: 1.5rem; font-size: 0.75rem " >账户类型：<?php echo ($data['data']['data'][0]['btype']); ?></div>
                    </div>
                </div>
                <br />

                <?php if(($data['data']['data'][0]['pay_status']) != "0"): ?><p style="color: white;">付款凭证</p>
                    <img src="<?php echo ($data['data']['data'][0]['image']); ?>" alt="">

                    <?php if(($order_type) == "1"): if(($data['data']['data'][0]['is_pay']) != "1"): ?><button style="width: 100%; height:auto; background-color:#FF9326; border: none;  border-radius:0; margin-top: 1rem; color: #fff; font-size: 0.8rem; line-height: 1.8rem" onclick="window.location.href='/index.php/home/index/lijishoukuan?match_time=<?php echo ($match_time); ?>&id=<?php echo ($id); ?>&match_id=<?php echo ($data["data"]["data"][0]["id"]); ?>'">确认收款</button><?php endif; endif; ?>

                <?php else: ?>

                    <?php if(($order_type) == "0"): ?><div class="aui-text-center xq-list file" style="width:98%; padding: 2%; color: #fff; " >点击上传打款凭证<input type="file" onchange="uploadFile()" id="form1" class="" /></div>
                        <img src="" alt="" id="pizhengtu" />
                        <!--                <div class="aui-text-center xq-list"><p><div class="aui-btn aui-btn-success aui-btn-block">上传凭证</div></p></div>-->
                        <div class="aui-text-center xq-list"><p><div class="aui-btn aui-btn-success aui-btn-block" onclick="window.location.href='/index.php/home/index/dakuan?match_time=<?php echo ($match_time); ?>&id=<?php echo ($id); ?>&match_id=<?php echo ($data["data"]["data"][0]["id"]); ?>'">立即上传</div></p></div><?php endif; endif; ?>

            </div>
        </div>
    </div>
<?php else: ?>
    <div class="aui-content" style="margin-top: 60%;">
        <div class="aui-row xq-no">
            <div class="aui-col-xs-12" style="text-align: center">
                <span class="fff" >未匹配~</span>
            </div>
        </div>
    </div><?php endif; ?>

<?php echo W('Tab/Index');?>

<script src="/Public/app/script/jquery.min.js"></script>
<script>
    //上传文件
    function uploadFile(){
        var files = $('#form1')[0].files;
        var data = new FormData();
        if (files) {
            data.append('file',files[0]);
            data.append('oid','<?php echo ($data["data"]["data"][0]["id"]); ?>');
            data.append('token','<?php echo ($token); ?>')
        }
        $.ajax({
            cache : false,
            type : 'post',
            dataType: 'json',
            url : '<?php echo ($host_name); ?>/api.php/api/Match/uploadVoucher',
            data :data,
            contentType : false,  //  不设置Content-type请求头
            processData : false,  //  不处理发送的数据，因为data值是Formdata对象，不需要对数据做处理
            success : function(data){
                //console.log(data);
                $('#pizhengtu').attr('src',data.data.data);
            }
        });
    }
</script>

</body>
</html>