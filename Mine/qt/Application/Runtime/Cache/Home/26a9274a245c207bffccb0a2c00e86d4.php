<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0"/>
    <meta name="format-detection" content="telephone=no,email=no,date=no,address=no">
    <link rel="stylesheet" type="text/css" href="/Public/app/css/aui.css" />
    <link rel="stylesheet" type="text/css" href="/Public/site/css/style.css">
    <title>名花</title>
</head>
<?php echo W('Body/Index');?>

<div class="aui-content" style="overflow: scroll;height: 90%;">

    <?php if(is_array($data['data']['data'])): foreach($data['data']['data'] as $key=>$item): ?><div class="aui-row" style="background-color: rgba(100,100,115,0.5);margin-top: 10px;">
            <div class="aui-col-xs-3" style="padding: 3%;">
                <img src="/Public/site/images/2.png" alt="">
            </div>
            <div class="aui-col-xs-6" style="text-align: center;">
                <div class="aui-row">
                    <div class="aui-col-xs-12" style="margin-top: 20px;"><span style="color: white">花团<?php echo ($key+1); ?></span></div>
                    <div class="aui-col-xs-12"><span style="color: white">用户名：<?php echo ($item["username"]); ?></span></div>
                </div>
            </div>
            <div class="aui-col-xs-3">
                <?php if(1 == $item['active']): ?><div class="aui-btn" style="margin-top: 20px;color: black;">已激活</div>
                <?php else: ?>
                    <div class="aui-btn" style="margin-top: 20px;background: #FF7F00;color: white;" onclick="openDialog('callback','<?php echo ($item["id"]); ?>')">激活</div><?php endif; ?>
            </div>
        </div><?php endforeach; endif; ?>

</div>

<script type="text/javascript" src="/Public/app/script/aui-dialog.js" ></script>
<script type="text/javascript">
    var dialog = new auiDialog({});
    function openDialog(type,id){
        switch (type) {
            case "callback":
                dialog.alert({
                    title:"确认激活吗",
                    buttons:['取消','确定']
                },function(ret){

                    if(2 == ret.buttonIndex)
                    {
                        //向服务器发送请求，激活队友
                        window.location.href = '/index.php/home/index/active_dy?id='+id;
                    }

                });
                break;
            default:
                break;
        }
    }
</script>


<?php echo W('Tab/Index');?>
</body>
</html>