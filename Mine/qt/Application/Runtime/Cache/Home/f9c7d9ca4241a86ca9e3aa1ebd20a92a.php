<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0"/>
    <meta name="format-detection" content="telephone=no,email=no,date=no,address=no">
    <link rel="stylesheet" type="text/css" href="/Public/app/css/aui.css" />
    <link rel="stylesheet" type="text/css" href="/Public/site/css/style.css">
    <title>银行卡</title>
    <style>
        .bank-list{background-color:transparent;}
        .bank-list li{background-color: rgb(115,115,115,0.5); margin: 4% 0!important;}
        .bank-list li:active{background-color: rgb(115,115,115,0.5)!important;}
        .order-btn{font-size: 0.6rem;width: 100%;height: 1rem; line-height: 1rem; margin: 5% 0;}
        .btn-red{background-color: #FF7F00;color: #fff;}
        .btn-green{background-color: #308E35;color: #fff;}
        .btn-ccc{background: rgb(102, 102, 102);color: #fff;}
        .bank-tit p{color: #fff;}
    </style>
</head>
<?php echo W('Body/Index');?>
<div class="aui-content" style="overflow: scroll;height: 90%;"  >
    <div class="aui-content-padded" onclick="window.location.href='/index.php/home/index/add_bankcard'"><p><div class="aui-btn aui-btn-success aui-btn-block aui-btn-outlined">添加银行卡</div></p></div>
    <ul class="aui-list aui-media-list bank-list">
        <?php if(is_array($data['data']['data'])): foreach($data['data']['data'] as $key=>$item): ?><li class="aui-list-item">
            <div class="aui-media-list-item-inner">
                <div class="aui-list-item-media">
                    <img src="<?php echo ($host_name); echo ($item["img"]); ?>">
                </div>
                <div class="aui-list-item-inner">
                    <div class="aui-list-item-text">
                        <div class="aui-list-item-title bank-tit">
                            <p>账户名称：<?php echo ($item["name"]); ?></p>
                            <p>账号：<?php echo ($item["mobile"]); ?></p>
                            <p>账户类型：<?php echo ($item["type"]); ?></p>
                        </div>
                        <div class="aui-list-item-right">

                            <?php if(($item['moren']) == "1"): ?><p><div class="aui-btn order-btn" style="color: white;">默认卡</div></p>
                            <?php else: ?>
                                <p><div class="aui-btn order-btn" style="background: #FF7F00;color: white;" onclick="window.location.href='/index.php/home/index/moren?id=<?php echo ($item["id"]); ?>'">默认卡</div></p><?php endif; ?>

 <!-- <p><div class="aui-btn order-btn btn-red" onclick="window.location.href='/index.php/home/index/del_bankcard?id=<?php echo ($item["id"]); ?>'">删除</div></p> -->
                            <p><div class="aui-btn order-btn btn-red" onclick="delfanzhi(<?php echo ($item["id"]); ?>)">删除</div></p>

                        </div>
                    </div>
                </div>
            </div>
        </li><?php endforeach; endif; ?>


    </ul>
</div>

<?php echo W('Tab/Index');?>

<script src="/Public/app/script/jquery.min.js"></script>
<script type="text/javascript" src="/Public/layui/layui.all.js"></script>

<script type="text/javascript" src="/Public/app/script/aui-toast.js" ></script>
<script type="text/javascript">
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
    
    var delfanzhi = function (id) {
        layer.prompt({
            title: '请输入支付密码',
            formType: 1,
            //maxlength:6
        },function(pass, index){
            layer.close(index);
            window.location.href="/index.php/home/index/del_bankcard?id="+id+"&password="+pass;
           // window.location.href="/index.php/home/index/hulu_shouyi_fanzhi?cid="+cid+"&title="+title+"&password="+pass;
        });

    };

    </script>
</body>
</html>