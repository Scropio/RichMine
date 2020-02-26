<?php /*a:3:{s:65:"/www/wwwroot/ht.zzhr168.cn/application/admin/view/agent/auth.html";i:1564236901;s:66:"/www/wwwroot/ht.zzhr168.cn/application/admin/view/common/head.html";i:1564236899;s:66:"/www/wwwroot/ht.zzhr168.cn/application/admin/view/common/foot.html";i:1564236899;}*/ ?>
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
<div class="admin-main layui-anim layui-anim-upbit">

    <form action="/admin.php/agent/auth" method="post">

        <select name="level">

            <?php if(is_array($userLevels) || $userLevels instanceof \think\Collection || $userLevels instanceof \think\Paginator): $i = 0; $__LIST__ = $userLevels;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <option value="<?php echo htmlentities($vo['level_id']); ?>" <?php if($level == $vo['level_id'])echo "selected" ?>><?php echo htmlentities($vo['level_name']); ?></option>
            <?php endforeach; endif; else: echo "" ;endif; ?>

        </select>

        <input type="submit" value="查询" />

    </form>

    <?php if(1 == $slug): ?>
        <ul>
            <?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <li><span>用户名：<?php echo htmlentities($vo['username']); ?>&nbsp;&nbsp;</span><span>直推人数：<?php echo htmlentities($vo['zhitui']); ?>&nbsp;&nbsp;</span><span>团队人数：<?php echo htmlentities($vo['tuandui']); ?>&nbsp;&nbsp;</span></li>
                <hr />
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
    <?php endif; ?>

</div>
<script type="text/javascript" src="/static/plugins/layui/layui.js"></script>

