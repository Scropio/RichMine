<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0"/>
    <meta name="format-detection" content="telephone=no,email=no,date=no,address=no">
    <title>名花记录</title>
    <link rel="stylesheet" type="text/css" href="/Public/app/css/aui.css" />
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
<div class="aui-tab order-tab" id="tab" style="overflow: scroll;height: 90%;">
    <div class="aui-tab-item <?php if(0 == $is_pay)echo 'aui-active'; ?>" onclick="window.location.href='/index.php/home/index/hulu_record'">转让中</div>
    <div class="aui-tab-item <?php if(1 == $is_pay)echo 'aui-active'; ?>" onclick="window.location.href='/index.php/home/index/hulu_record?is_pay=1'">已完成</div>
</div>

<div style="display: <?php if(0 == $is_pay)echo 'block'; else echo 'none'; ?>">

    <div class="aui-content" style="overflow: scroll;height: 82%">
        <div class="aui-row">
            <div class="aui-col-xs-12">
                <div class="list-box">

                    <?php if(is_array($data['data']['data'])): foreach($data['data']['data'] as $key=>$item): ?><div class="aui-row order-list">
                            <div class="aui-col-xs-4">
                                <div class="aui-row order-main1">
                                    <p>级别：<?php echo ($item["c_name"]); ?></p>
                                    <p>金额：<?php echo ($item["money"]); ?></p>
                                </div>
                            </div>
                            <div class="aui-col-xs-8">
                                <div class="aui-row order-main2" style="text-align: right">
                                    <p>转让时间：<?php echo ($item["create_time"]); ?></p>
                                    <p>转让中</p>
                                </div>
                            </div>
                        </div><?php endforeach; endif; ?>
                </div>

            </div>
        </div>
    </div>

</div>

<div style="display: <?php if(1 == $is_pay)echo 'block'; else echo 'none'; ?>">
    <div class="aui-content" style="overflow: scroll;height: 82%">
        <div class="aui-row">
            <div class="aui-col-xs-12">
                <div class="list-box">

                    <?php if(is_array($data['data']['data'])): foreach($data['data']['data'] as $key=>$item): ?><div class="aui-row order-list">
                            <div class="aui-col-xs-4">
                                <div class="aui-row order-main1">
                                    <p>级别：<?php echo ($item["c_name"]); ?></p>
                                    <p>金额：<?php echo ($item["money"]); ?></p>
                                </div>
                            </div>
                            <div class="aui-col-xs-8">
                                <div class="aui-row order-main2" style="text-align: right">
                                    <p>转让时间：<?php echo ($item["create_time"]); ?></p>
                                    <p>已完成</p>
                                </div>
                            </div>
                        </div><?php endforeach; endif; ?>
                </div>

            </div>
        </div>
    </div>
</div>

<?php echo W('Tab/Index');?>
</body>
</html>