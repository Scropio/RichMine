<?php /*a:3:{s:75:"/www/wwwroot/ht.zzhr168.cn/application/admin/view/system/system_config.html";i:1564236896;s:66:"/www/wwwroot/ht.zzhr168.cn/application/admin/view/common/head.html";i:1564236899;s:66:"/www/wwwroot/ht.zzhr168.cn/application/admin/view/common/foot.html";i:1564236899;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo config('sys_name'); ?>后台管理</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" href="/static/plugins/layui/css/layui.css" media="all" />
    <link rel="stylesheet" href="/static/admin/css/global.css" media="all">
    <link rel="stylesheet" href="/static/common/css/font.css" media="all">
</head>
<body class="skin-<?php if(!empty($_COOKIE['skin'])){echo $_COOKIE['skin'];}else{echo '0';setcookie('skin','0');}?>">
<script src="/static/common/js/jquery.2.1.1.min.js"></script>
<script src="/static/plugins/layui/layui.all.js"></script>
<link rel="stylesheet" href="/static/plugins/layui/css/layui.css">

<div class="admin-main layui-anim layui-anim-upbit">
    <fieldset class="layui-elem-field layui-field-title">
        <legend>参数配置</legend>
    </fieldset>
    <form class="layui-form layui-form-pane" lay-filter="form-email">

        <?php if(is_array($config) || $config instanceof \think\Collection || $config instanceof \think\Paginator): $i = 0; $__LIST__ = $config;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
        <div class="layui-form-item">
            <label class="layui-form-label" style="width: 150px"><?php echo htmlentities($vo['title']); ?></label>
            <div class="layui-input-4">
                <input type="text" lay-verify="required" name="pay_rang" placeholder="" class="layui-input newFee" value="<?php echo htmlentities($vo['value']); ?>" id="jqCheck<?php echo htmlentities($vo['id']); ?>">
                <div><?php echo htmlentities($vo['remark']); ?></div>
            </div>

            <div style="float: left">
                <button type="button" class="layui-btn layui-btn-sm layui-btn-normal" onclick="changeLayerFee(<?php echo htmlentities($vo['id']); ?>,this)">修改</button>

            </div>


        </div>
        <?php endforeach; endif; else: echo "" ;endif; ?>
    </form>
</div>
<script type="text/javascript" src="/static/plugins/layui/layui.js"></script>


<script>
    function changeLayerFee(id,obj) {
        var newFee = $('#jqCheck'+id).val();
        $.ajax({
            type : "POST",
            url : "<?php echo url('system_config'); ?>",
            data: {
                newFee:newFee,
                id:id,
            },
            dataType : "json",
            success : function(result){
                layer.msg(result.msg,{time:500},function () {
                    if (result.status)window.location.reload();
                });
            },
            error:function(){
                layer.msg("系统繁忙！");
            }

        });
    }
</script>
</body>
</html>