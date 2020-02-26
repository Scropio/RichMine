<?php /*a:3:{s:66:"/www/wwwroot/ht.qy-315.cn/application/admin/view/appeal/index.html";i:1564236900;s:65:"/www/wwwroot/ht.qy-315.cn/application/admin/view/common/head.html";i:1564236899;s:65:"/www/wwwroot/ht.qy-315.cn/application/admin/view/common/foot.html";i:1564236899;}*/ ?>
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
<div class="admin-main layui-anim layui-anim-upbit">
    <fieldset class="layui-elem-field layui-field-title">
        <legend>申诉列表</legend>
    </fieldset>
    <div>
        <div class="table-responsive">
            <table class="layui-table table-hover">
                <thead>
                <tr>
                    <th>订单编号</th>
                    <th style="width: 20%">申诉内容</th>
                    <th>申诉用户</th>
                    <th>申诉时间</th>
                    <th>申诉状态</th>
                    <th>管理操作</th>
                </tr>
                </thead>
                <!--内容容器-->
                <tbody id="con">
                <?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                <tr>
                    <td><?php echo htmlentities($v['order_id']); ?></td>
                    <td><?php echo htmlentities($v['content']); ?></td>
                    <td><?php echo htmlentities($v['username']); ?></td>
                    <td><?php echo toDate($v['time'],'Y-m-d h:i:s'); ?></td>
                    <td class="sta<?php echo htmlentities($v['id']); ?>">
                        <?php if($v['status'] == '0'): ?>
                        <span style="color:red;cursor: pointer;" onclick="status(<?php echo htmlentities($v['id']); ?>)">未处理</span>
                        <?php else: ?>
                        <span style="color:green">已处理</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <input type="hidden" id="voucher_image<?php echo htmlentities($v['id']); ?>" value="<?php echo htmlentities($v['evidence']); ?>">
                        <a class="layui-btn layui-btn-sm" onclick="voucher(<?php echo htmlentities($v['id']); ?>)">查看凭证</a>
                    </td>
                </tr>
                <?php endforeach; endif; else: echo "" ;endif; ?>
                </tbody>
            </table>
            <?php echo $data; ?>
        </div>
    </div>

</div>
<script type="text/javascript" src="/static/plugins/layui/layui.js"></script>


<script>
    layui.use('form',function() {
        var form = layui.form, $ = layui.jquery;
    });
</script>

<!--查看凭证-->
<script>
    function voucher(id) {
        var link = $('#voucher_image'+id).val();
        layer.open({
            type: 1,
            title: '申诉凭证',
            offset: ['5%'],
            closeBtn: 2,
            area: ['50%','600px'],
            maxWidth:'500px',
            skin: 'layui-layer-nobg', //没有背景色
            shadeClose: true,
            content: "<img src='"+link+"' style='width: 35%'>"
        })
    }
</script>
<!--end查看凭证-->

<!--处理-->
<script>
    function status(id){
        $.post("<?php echo url('Appeal/status'); ?>",{id:id},function (data) {

            if (data.code == 1){
                $(".sta"+id).html("<span style='color:green'>已处理</span>");

                alert(data.msg);
                return false;
            }else{
                alert(data.msg);
                return false;
            }
        });
    }
</script>
<!--end处理-->