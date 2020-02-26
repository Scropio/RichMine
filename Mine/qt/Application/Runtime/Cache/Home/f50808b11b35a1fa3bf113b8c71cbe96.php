<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0"/>
    <meta name="format-detection" content="telephone=no,email=no,date=no,address=no">
    <title>名花收益</title>
    <link rel="stylesheet" type="text/css" href="/Public/app/css/aui.css" />
    <link rel="stylesheet" type="text/css" href="/Public/layui/css/layui.css" />
    <style type="text/css">
        .order-tab{background-color: transparent;}
        .aui-active{color: #FF9326!important;border: 0!important;}
        .aui-tab-item{color: #fff;}

        .yellow-con{color: #FCBD01;}
        .grow-list{background-color: rgba(100,100,115,0.5); padding: 2% 4%; margin: 2% 0;}
        .grow-main1 img{width: 4.4rem;}
        .grow-main2{margin-top: 5%;}
        .grow-main2 p{color: #fff; line-height: 2; }
        .grow-time{background-color: #fff; color: #333; padding: .1rem; margin: .1rem; border-radius: .1rem;}

        .order-list{background-color: rgba(100,100,115,0.5); padding: 2%; margin: 2% 0;}
        .order-btn{padding: 0;font-size: 0.6rem;width: 100%;height: 1rem; line-height: 1rem; margin: 5% 0;}
        .order-main1 p{color: #fff;}
        .order-main2{margin-right: 1%;}
        .order-main2 p{color: #fff;}
        .btn-orange{background-color: #FF9326;color: #fff;}
        .btn-green{background-color: #308E35;color: #fff;}
    </style>
</head>
<?php echo W('Body/Index');?>
<div class="aui-tab order-tab" id="tab">
<!--    <div class="aui-tab-item <?php if('yeji' == $type)echo 'aui-active'; ?>" onclick="window.location.href='/index.php/home/index/hulu_shouyi?type=yeji'">市场奖励</div>-->
    <div class="aui-tab-item <?php if('iten' == $type)echo 'aui-active'; ?>" onclick="window.location.href='/index.php/home/index/hulu_shouyi?type=iten'">团队奖励</div>
    <div class="aui-tab-item <?php if('fanzhi' == $type)echo 'aui-active'; ?>" onclick="window.location.href='/index.php/home/index/hulu_shouyi?type=fanzhi'">繁殖</div>
</div>


<?php if($type == 'fanzhi'): ?><div class="aui-content" style="overflow: scroll;height: 82%">
        <div class="aui-row">
            <div class="aui-col-xs-12">
                <div class="list-box">

                    <?php if(is_array($data['data']['data'])): foreach($data['data']['data'] as $key=>$item): ?><div class="aui-row order-list">
                            <div class="aui-col-xs-4">
                                <div class="aui-row order-main1">
                                    <img src="<?php echo ($host_name); echo ($item["thumb"]); ?>" alt="">
                                </div>
                            </div>
                            <div class="aui-col-xs-5" style="margin: 1rem 0 0 0.3rem;">
                                <div class="aui-row order-main1">
                                    <p><?php echo ($item["title"]); ?></p>
                                </div>
                                <div class="aui-row order-main1">
                                    <p>价值：<?php echo ($item["price"]); ?></p>
                                </div>
                            </div>
<!--                            <div class="aui-col-xs-4" style="margin-top: 2.5rem;">-->
<!--                                <div class="aui-row order-main1">-->
<!--                                    <p>价值：<?php echo ($item["price"]); ?></p>-->
<!--                                </div>-->
<!--                            </div>-->
                            <div class="aui-col-xs-2" style="margin-top: 1rem;">
                                <div class="aui-row order-main1">
                                    <?php if(($item['tixian']) == "1"): ?><div class="aui-btn aui-btn-block aui-btn-sm" style="background: #666666;color: white;">繁殖</div>
                                    <?php else: ?>
                                        <div class="aui-btn aui-btn-block aui-btn-sm fz-btn" style="background: #FF7F00;color: white;" onclick="fanzhi('<?php echo ($item["id"]); ?>','<?php echo ($item["title"]); ?>')">繁殖</div><?php endif; ?>
                                </div>
                            </div>
                        </div><?php endforeach; endif; ?>

                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="aui-content" style="overflow: scroll;height: 82%">
        <div class="aui-row">
            <div class="aui-col-xs-12">
                <div class="list-box">

                    <?php if(is_array($data['data']['data'])): foreach($data['data']['data'] as $key=>$item): ?><div class="aui-row order-list">
                            <div class="aui-col-xs-4">
                                <div class="aui-row order-main1">
                                    <p style="margin-top: 0.3rem"><?php echo ($item["money"]); ?></p>
                                    <p style="margin-top: 0.5rem"><?php echo ($item["remark"]); ?></p>
                                </div>
                            </div>
                            <div class="aui-col-xs-8">
                                <div class="aui-row order-main2" style="text-align: right">
                                    <p style="margin-top: 0.3rem">时间：<?php echo ($item["createtime"]); ?></p>
                                </div>
                            </div>
                        </div><?php endforeach; endif; ?>

                </div>

            </div>
        </div>
    </div><?php endif; ?>

<?php echo W('Tab/Index');?>
<script src="/Public/app/script/jquery.min.js"></script>
<script type="text/javascript" src="/Public/layui/layui.all.js"></script>
<script type="text/javascript" src="/Public/app/script/aui-toast.js"></script>
<script>
    // //prompt层
    var fanzhi = function (cid,title) {
        layer.prompt({
            title: '请输入支付密码',
            formType: 1,
            //maxlength:6
        },function(pass, index){
            layer.close(index);
            window.location.href="/index.php/home/index/hulu_shouyi_fanzhi?cid="+cid+"&title="+title+"&password="+pass;
        });

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