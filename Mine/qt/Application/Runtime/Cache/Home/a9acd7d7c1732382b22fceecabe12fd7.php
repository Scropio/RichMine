<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0"/>
    <meta name="format-detection" content="telephone=no,email=no,date=no,address=no">
    <title>名花生长</title>
    <link rel="stylesheet" type="text/css" href="/Public/app/css/aui.css" />
    <style type="text/css">
        .order-tab{background-color: transparent;}
        .aui-active{color: #FF9326!important;border: 0!important;}
        .aui-tab-item{color: #fff;}

        .yellow-con{color: #FCBD01;}
        .grow-list{background-color: rgba(100,100,115,0.5); padding: 2% 3%; margin: 2% 0;}
        .grow-main1 img{width: 4.2rem;}
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
        .list-box{display: none;}
        .active{display: block;}
      .time_bj{background-color: #fff;color: #333; padding: 2px;border-radius: 3px}
    </style>
</head>
<?php echo W('Body/Index');?>
<?php echo W('Head/Index');?>
<div class="aui-content" style="overflow: scroll;height: 82%" >
<div class="aui-tab order-tab" id="tab">
    <div class="aui-tab-item <?php if(0 == $is_pay)echo 'aui-active'; ?>" onclick="window.location.href='/index.php/home/index/hulu_shengzhang'">生长中</div>
    <div class="aui-tab-item <?php if(1 == $is_pay)echo 'aui-active'; ?>" onclick="window.location.href='/index.php/home/index/hulu_shengzhang?is_pay=1'">已收益</div>
</div>
<div style="display: <?php if(0 == $is_pay)echo 'block'; else echo 'none'; ?>" class="autore">

    <?php if(is_array($data['data']['data'])): foreach($data['data']['data'] as $key=>$item): ?><div class="aui-row grow-list">
        <div class="aui-col-xs-4">
            <div class="aui-row grow-main1">
                <img src="<?php echo ($host_name); echo ($item["thumb"]); ?>" alt="" style="width: 100%; margin-top: 1.4rem">
            </div>
        </div>
        <div class="aui-col-xs-8">
            <div class="aui-row grow-main2">
                <p>领养时间：<span class="yellow-con"><?php echo ($item["jiedong_time"]); ?></span></p>
                <p>领养收益：<span class="yellow-con"><?php echo ($item["gains"]); ?>%/<?php echo ($item["grow_day"]); ?>天</span></p>
                <p>价值：<span class="yellow-con"><?php echo ($item["money"]); ?></span></p>
                <p>开始时间：<span class="yellow-con"><?php echo ($item["create_time"]); ?></span></p>
<!--                <p id="now_time_<?php echo ($key+1); ?>">成长倒计时：<span class="grow-time" id="now_time_day_<?php echo ($key+1); ?>">00</span>天<span class="grow-time" id="now_time_hour_<?php echo ($key+1); ?>">23</span>:<span class="grow-time" id="now_time_min_<?php echo ($key+1); ?>">00</span>:<span class="grow-time" id="now_time_sec_<?php echo ($key+1); ?>">00</span></p>-->
<!--                <p id="now_time_<?php echo ($key+1); ?>"></p>-->
<!--                <p id="rtime_<?php echo ($key+1); ?>" style="display: none"><?php echo ($item["r_time"]); ?></p>-->
                    
                   <p style="font-size: 0.65rem;">成长时间截止：
                       <span class="time_bj"><?php echo ($item["t"]); ?></span> 天
                       <span class="time_bj"><?php echo ($item["h"]); ?></span> 小时
                       <span class="time_bj"> <?php echo ($item["f"]); ?></span> 分钟
                       <span class="time_bj"><?php echo ($item["m"]); ?></span> 秒</p>
            </div>
        </div>

    </div><?php endforeach; endif; ?>

    <script src="/Public/app/script/jquery.min.js"></script>
	<script>

        $(function () {
            setInterval(function () {
                $(".autore").load(location.href + " .autore");//注意后面DIV的ID前面的空格，很重要！没有空格的话，会出双眼皮！（也可以使用类名）
            }, 1000);
        })
    </script>

</div>
<div style="display: <?php if(1 == $is_pay)echo 'block'; else echo 'none'; ?>">


    <div class="aui-content" style="overflow: scroll;height: 82%">
        <div class="aui-row">
            <div class="aui-col-xs-12">
                <div class="list-box active">

                    <?php if(is_array($data['data']['data'])): foreach($data['data']['data'] as $key=>$item): ?><div class="aui-row order-list" style="padding-top: 4.2%;">
                            <div class="aui-col-xs-3" style="width: 22%; line-height: 1.3rem">
                                <div class="aui-row order-main1">
                                    <p style=" font-size: 0.68rem">级别：<?php echo ($item["c_name"]); ?></p>
                                    <p style=" font-size: 0.68rem">金额：<?php echo ($item["moneyint"]); ?></p>
                                </div>
                            </div>
                            <div class="aui-col-xs-7" style="width: 62%; line-height: 1.3rem; ">
                                <div class="aui-row order-main2">
                                    <p style="font-size: 0.68rem;">领养时间：<?php echo ($item["create_time"]); ?></p>
                                    <p style="font-size: 0.68rem;">成长倒计时：<?php echo ($item["jiedong_time"]); ?></p>
                                </div>
                            </div>
                            <div class="aui-col-xs-2"style="width: 16%"`>
                                <div class="aui-row order-main3" >
                                    <p><div class="aui-btn order-btn btn-orange big-link" aui-popup-for="bottom">挂卖</div></p>
                                    <p><div class="aui-btn order-btn btn-green">已售</div></p>
                                </div>
                            </div>
                        </div><?php endforeach; endif; ?>
                </div>

            </div>
        </div>
    </div>

</div>
</div>
<?php echo W('Tab/Index');?>
</body>
</html>