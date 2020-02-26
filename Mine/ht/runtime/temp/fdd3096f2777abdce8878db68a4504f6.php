<?php /*a:2:{s:75:"/www/wwwroot/ht.zzhr168.cn/application/admin/view/match/trading_center.html";i:1564236897;s:66:"/www/wwwroot/ht.zzhr168.cn/application/admin/view/common/head.html";i:1564236899;}*/ ?>
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
<style type="text/css">
    .layui-table, .layui-table-view{margin: 0;}
    .layui-table td, .layui-table th{padding:5px 0;text-align: center; }
    .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td{padding: 5px;}
    .pagination {}

    .pagination li {display: inline-block;margin-right: -1px;padding: 5px;border: 1px solid #e2e2e2;min-width: 20px;text-align: center;}

    .pagination li.active {background: #009688;color: #fff;border: 1px solid #009688;}

    .pagination li a {display: block;text-align: center;}
</style>
<div>
    <div class="search">
        <form method="post" action="<?php echo url('Match/trading_center'); ?>">
            <div class="layui-form-pane" style="margin-top: 15px;">
                <div class="layui-form-item">
                    <label class="layui-form-label">范围选择</label>
                    <div class="layui-input-inline">
                        <input class="layui-input" placeholder="开始-结束" id="set_time" name="set_time" readonly value="<?php echo htmlentities($set_time); ?>">
                    </div>
                </div>
            </div>

            <div class="layui-form-pane">
                <label class="layui-form-label">会员编号</label>
                <div class="layui-input-inline">
                    <input type="text" name="username" lay-verify="required" placeholder="会员编号或匹配编号" autocomplete="off" class="layui-input" value="<?php echo htmlentities($username); ?>">
                </div>
            </div>
            <div class="layui-form-pane">
                <label class="layui-form-label">订单类型</label>
                <div class="layui-input-inline">
                    <select name="pay_status" lay-verify="required" class="layui-input-block">
                        <option value="">全部订单</option>
                        <option value="0" <?php if($pay_status == '0'): ?>selected<?php endif; ?>>等待打款</option>
                        <option value="1" <?php if($pay_status == '1'): ?>selected<?php endif; ?>>等待收款</option>
                        <option value="2" <?php if($pay_status == '2'): ?>selected<?php endif; ?>>已收款</option>
                    </select>
                </div>
                <button type="submit" 	class="layui-btn layui-btn-sm">查询</button>
            </div>
        </form>
    </div>
    <table class="layui-table" lay-size="sm">
        <thead>
        <tr>
            <th>匹配订单</th>
            <th>匹配金额</th>
            <th>进场订单</th>
            <th>买家编号</th>
            <th>出场订单</th>
            <th>卖家编号</th>
            <th>匹配时间</th>
            <th>状态</th>
            <!--<th>投诉</th>-->
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
        <tr>
            <td style="color:blue"><?php echo htmlentities($vo['order_id']); ?></td>
            <td style="color:blue"><?php echo htmlentities($vo['money']); ?></td>
            <td><?php echo htmlentities($vo['in_order_id']); ?></td>
            <td><?php echo htmlentities($vo['username']); ?></td>
            <td><?php echo htmlentities($vo['out_order_id']); ?></td>
            <td><?php echo htmlentities($vo['busername']); ?></td>
            <td><?php echo date('Y-m-d H:i:s',$vo['create_time']); ?></td>
            <td>
                <?php if($vo['pay_status'] == '0'): ?>未打款<?php endif; if($vo['pay_status'] == '1'): ?>未收款<?php endif; if($vo['pay_status'] == '2'): ?>已收款<?php endif; ?>
            </td>
            <!--<td>-->
                <!--<?php if($vo['complaint'] == '0'): ?><i class="fa fa-close">无</i><?php endif; ?>-->
                <!--<?php if($vo['complaint'] == '1'): ?><i class="fa fa-check" style="color: red" onclick="show_time(<?php echo htmlentities($vo['complaint_time']); ?>)">有</i><?php endif; ?>-->
            <!--</td>-->
            <td>
                <a class="layui-btn layui-btn-sm" onclick="undo_matching(<?php echo htmlentities($vo['id']); ?>)">撤销匹配</a>
                <a class="layui-btn layui-btn-sm" onclick="arbitration(<?php echo htmlentities($vo['id']); ?>)">仲裁</a>
                <input type="hidden" id="voucher_image<?php echo htmlentities($vo['id']); ?>" value="<?php echo htmlentities($vo['image']); ?>">
                <a class="layui-btn layui-btn-sm" onclick="voucher(<?php echo htmlentities($vo['id']); ?>)">凭证</a>
            </td>
        </tr>
        <?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
    </table>
    <?php echo $list; ?>
</div>

</div>


<!--撤销匹配-->
<script>
    function undo_matching(oid) {

        $.post("<?php echo url('Match/match_info'); ?>",{oid:oid},function (data) {
				console.log(data);
            var waiting = '&nbsp;';
            if (data.pay_status ==0){var waiting = '<p style="color: red">订单未打款，撤销匹配后将还原排单和提现订单的状态，并删除匹配订单</p>';}
            if (data.pay_status ==1){var waiting = '<p style="color: red">订单已打款，请执行仲裁操作</p>';}
            if (data.pay_status ==2){var waiting = '<p style="color: red">提现方已确认收款！交易已完成，无需操作</p>';}
            //示范一个公告层
            layer.open({
                type: 1
                ,title: '撤销匹配' //不显示标题栏
                ,closeBtn: 1
                ,area: '400px;'
                ,shade: 0.8
                ,id: 'LAY_layuipro' //设定一个id，防止重复弹出
                ,btn: ['撤销匹配', '取消']
                ,moveType: 1 //拖拽模式，0或者1
                ,content: '<div style="padding: 50px; line-height: 22px; background-color: #393D49; color: #fff; font-weight: 300;">' +
                '匹配订单：'+data.order_id+'<br>' +
                '打款订单：'+data.in_order_id+'【'+data.username+'】<br>' +
                '提现订单：'+data.out_order_id+'【'+data.busername+'】<br>' +
                '匹配金额：'+data.money+'<br>' + waiting +
                '</div>'
                ,success: function(layero){
                    var btn = layero.find('.layui-layer-btn');
                    btn.css('text-align', 'center');

                    btn.find('.layui-layer-btn0').click(function () {
                        $.post("<?php echo url('Match/undo_matching_save'); ?>",{oid:oid},function (data) {
                            if (data.status == 0){
                                layer.msg(data.info, {time: 2500, icon: 2});
                            }
                            if (data.status == 1){
                                layer.msg(data.info, {time: 1000, icon: 1},function () {
                                    // window.location.reload();
                                });
                            }
                        });
                    })

                }
            });
        });

    }
</script>

<!--仲裁操作-->
<script>
    function arbitration(oid) {

        $.post("<?php echo url('Match/match_info'); ?>",{oid:oid},function (data) {
//				console.log(data);
            var waiting = '&nbsp;';
            if (data.pay_status ==0){var waiting = '<p style="color: red">订单未打款，可直接执行撤销匹配操作</p>';}
            if (data.pay_status ==1){var waiting = '<p style="color: red">进场方已打款，请审核打款凭证后操作</p>';}
            if (data.pay_status ==2){var waiting = '<p style="color: red">提现方已确认收款！交易已完成，无需操作</p>';}
            //示范一个公告层
            layer.open({
                type: 1
                ,title: '仲裁中心' //不显示标题栏
                ,closeBtn: 1
                ,area: '400px;'
                ,shade: 0.8
                ,id: 'LAY_layuipro' //设定一个id，防止重复弹出
                ,btn: ['进场方', '出场方','取消']
                ,moveType: 1 //拖拽模式，0或者1
                ,content: '<div style="padding: 50px; line-height: 22px; background-color: #393D49; color: #fff; font-weight: 300;">' +
                '匹配订单：'+data.order_id+'<br>' +
                '打款订单：'+data.in_order_id+'【'+data.username+'】<br>' +
                '提现订单：'+data.out_order_id+'【'+data.busername+'】<br>' +
                '匹配金额：'+data.money+'<br>' + waiting +
                '</div>'
                ,success: function(layero){
                    var btn = layero.find('.layui-layer-btn');
                    btn.css('text-align', 'center');

                    btn.find('.layui-layer-btn0').click(function () {
                        layer.confirm('确定进场方已打款，确认后订单将变成完成状态，打款方将收到匹配金额', {icon: 3, title:'仲裁操作'}, function(index){
                            $.post("<?php echo url('Match/admin_arbitration'); ?>",{oid:oid,arbitration_type:1},function (data) {
								console.log(data);
                                if (data.status == 0){
                                    layer.msg(data.info, {time: 4000, icon: 2});
                                }
                                if (data.status == 1){
                                    layer.msg(data.info, {time: 3000, icon: 1},function () {
                                        // window.location.reload();
                                    });
                                }
                                layer.close(index);
                            });
                        });

                    });
                    btn.find('.layui-layer-btn1').click(function () {
                        layer.confirm('确定提现方未收到打款，确认后订单将撤销匹配，进场订单将变为不可再次匹配状态，出场订单将重新匹配', {icon: 3, title:'仲裁操作'}, function(index){
                            $.post("<?php echo url('Match/admin_arbitration'); ?>",{oid:oid,arbitration_type:2},function (data) {
//								console.log(data);
                                if (data.status == 0){
                                    layer.msg(data.info, {time: 4000, icon: 2});
                                }
                                if (data.status == 1){
                                    layer.msg(data.info, {time: 3000, icon: 1},function () {
                                        // window.location.reload();
                                    });
                                }
                            });
                            layer.close(index);
                        });

                    });
                    btn.find('.layui-layer-btn2').click(function () {
                        layer.msg('您取消了操作', {time: 2500, icon: 2});
                    })

                }
            });
        });

    }
</script>

<!--凭证-->
<script>
    function voucher(id) {
			// var pub='__PUBLIC__';
			// var zhi =$('#voucher_image'+id).val();
			// var url=  zhi.substring(10);
			// var link = pub+zhi;

        var link = $('#voucher_image'+id).val();
        layer.open({
            type: 1,
            title: '打款凭证',
            offset: ['5%'],
            closeBtn: 2,
            area: ['50%','600px'],
            maxWidth:'500px',
            skin: 'layui-layer-nobg', //没有背景色
            shadeClose: true,
            content: "<img src='"+link+"' style='width: 35%'>"
        })
    }

    function show_time(time) {
        var date = new Date(parseInt(time) * 1000).toLocaleString().replace(/:\d{1,2}$/,' ');
        layer.alert('申请投诉时间：'+date);
    }
</script>

<!--日期选择-->

<script>
    layui.use('laydate', function(){
        var laydate = layui.laydate;

        //日期范围
        laydate.render({
            elem: '#set_time'
            ,range: '~'
        });
    });
</script>
