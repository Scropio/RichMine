<?php /*a:3:{s:66:"/www/wwwroot/ht.zzhr168.cn/application/admin/view/users/index.html";i:1564642621;s:66:"/www/wwwroot/ht.zzhr168.cn/application/admin/view/common/head.html";i:1564236899;s:66:"/www/wwwroot/ht.zzhr168.cn/application/admin/view/common/foot.html";i:1564236899;}*/ ?>
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
        <legend><?php echo lang('user'); ?><?php echo lang('list'); ?></legend>
    </fieldset>
    <div class="demoTable">
        <div class="layui-inline">
            <input class="layui-input" name="key" id="key" placeholder="<?php echo lang('pleaseEnter'); ?>关键字">
        </div>
        <button class="layui-btn" id="search" data-type="reload">搜索</button>
        <!--<a href="<?php echo url('index'); ?>" class="layui-btn">显示全部</a>-->
        <button type="button" class="layui-btn layui-btn-danger" id="plJH">批量激活</button>
        <button type="button" class="layui-btn layui-btn-danger" id="yjJH">一键激活</button>
    </div>
    <table class="layui-table" id="list" lay-filter="list"></table>
</div>
<div style="display: none;padding: 10px 10%" class="layer_notice">
    <form class="layui-form" id="give_data">
        <div style="width: 100%;margin-top: 10px;">
            充值会员：<input style="height: 30px;line-height: 30px;width: 100%;padding-left: 6px;" type="text" name="rechargeUsername" readonly>
        </div>
        <div style="width: 100%;margin-top: 10px;">
            充值类型：
            <select  id="rechargeType">
              
                <option value="aibi">花粉</option>
                <option value="dynamic_wallet">花粉收益</option>
            </select>
        </div>
        <input type="hidden" name="rechargeId" readonly>
        充值金额：（负值为减少）<input style="height: 30px;line-height: 30px;width: 100%;padding-left: 6px;" type="text" name="rechargeMoney">
        <input  style="background: #337ab7;border: none;color: #fff;width: 100%;margin-top: 10px;height: 30px;line-height: 30px;" type="button" onclick="submitRecharge()" value="充值">
    </form>
</div>
<script type="text/html" id="is_lock">
    <input type="checkbox" name="is_lock" value="{{d.id}}" lay-skin="switch" lay-text="正常|禁用" lay-filter="is_lock" {{ d.is_lock == 0 ? 'checked' : '' }}>
</script>
<script type="text/html" id="currency_power">
    <input type="checkbox" name="currency_power" lay-skin="switch" lay-text="开启|关闭" readonly lay-filter="currency_power" {{ d.currency_power == 1 ? 'checked' : '' }}>
</script>
<script type="text/html" id="action">
    <a class="layui-btn layui-btn-xs" lay-event="jh">激活</a>
    <a href="<?php echo url('edit'); ?>?id={{d.id}}" class="layui-btn layui-btn-xs">编辑</a>
    <!--<a  class="layui-btn layui-btn-xs" onclick="recharge({{d.id,d.username}})">充值</a>-->
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="recharge">充值</a>
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="power">权限</a>
    <!--<a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>-->
</script>
<script type="text/html" id="email">
    {{d.email}}
    {{# if(d.email && d.email_validated=='0'){ }}
    (未验证)
    {{# } }}
</script>
<script type="text/javascript" src="/static/plugins/layui/layui.js"></script>


<script>
    layui.use(['table','form'], function() {
        var table = layui.table,form = layui.form, $ = layui.jquery;
        var tableIn = table.render({
            id: 'user',
            elem: '#list',
            url: '<?php echo url("index"); ?>',
            method: 'post',
            page: true,
            cols: [[
                {checkbox:true,fixed: true},
                // {field: 'id', title: '<?php echo lang("id"); ?>', width: 80, fixed: true},
                {field: 'username', title: '<?php echo lang("username"); ?>', width: 120},
                {field: 'realname', title: '真实姓名', width: 120},              
                {field: 'mobile', title: '手机号码', width: 120},
                {field: 're_name', title: '推荐人', width: 120},
                {field: 'level_name', title: '会员等级', width: 100},
                {field: 'mobile1', title: '手机号码', width: 120},
                // {field: 'email', title: '<?php echo lang("email"); ?>', width: 250,templet:'#email'},
                // {field: 'mobile', title: '<?php echo lang("tel"); ?>', width: 150},
                {field: 'is_lock', align: 'center',title: '<?php echo lang("status"); ?>', width: 120,toolbar: '#is_lock'},
                // {field: 'aixinzhongzi', title: '爱心种子', width: 120},
                {field: 'aibi', title: '花粉', width: 100},
                {field: 'static_wallet', title: '静态钱包', width: 100},
                {field: 'dynamic_wallet', title: '动态钱包', width: 100},
                {field: 'reg_time', title: '注册时间', width: 150},
                // {field: 'alipay', title: '支付宝', width: 150},
                // {field: 'wechat', title: '微信', width: 150},
                {field: 'currency_power', align: 'center',title: '权限', width: 80,toolbar: '#currency_power'},
                {width: 200, align: 'center', toolbar: '#action'}
            ]],
            limit: 30 //每页默认显示的数量
        });
        form.on('switch(is_lock)', function(obj){
            loading =layer.load(1, {shade: [0.1,'#fff']});
            var id = this.value;
            var is_lock = obj.elem.checked===true?0:1;
            $.post('<?php echo url("usersState"); ?>',{'id':id,'is_lock':is_lock},function (res) {
                layer.close(loading);
                if (res.status==1) {
                    tableIn.reload();
                }else{
                    layer.msg(res.msg,{time:1000,icon:2});
                    return false;
                }
            })
        });
        //搜索
        $('#search').on('click', function() {
            var key = $('#key').val();
            if($.trim(key)==='') {
                layer.msg('<?php echo lang("pleaseEnter"); ?>关键字！',{icon:0});
                return;
            }
            tableIn.reload({ page: {page: 1},where: {key: key}});
        });
        table.on('tool(list)', function(obj) {
            var data = obj.data;
            if (obj.event === 'del') {
                layer.confirm('您确定要删除该会员吗？', function(index){
                    var loading = layer.load(1, {shade: [0.1, '#fff']});
                    $.post("<?php echo url('usersDel'); ?>",{id:data.id},function(res){
                        layer.close(loading);
                        if(res.code===1){
                            layer.msg(res.msg,{time:1000,icon:1});
                            tableIn.reload();
                        }else{
                            layer.msg('操作失败！',{time:1000,icon:2});
                        }
                    });
                    layer.close(index);
                });
            }
            if (obj.event === 'jh') {
                layer.confirm('您确定要激活该会员吗？', function(index){
                    var loading = layer.load(1, {shade: [0.1, '#fff']});
                    $.post("<?php echo url('jh'); ?>",{id:data.id},function(res){
                        layer.close(loading);
                        if(res.code===1){
                            layer.msg(res.msg,{time:1000,icon:1});
                            tableIn.reload();
                        }else{
                            layer.msg('操作失败！',{time:1000,icon:2});
                        }
                    });
                    layer.close(index);
                });
            }
            if (obj.event === 'recharge') {
                $("input[name='rechargeUsername']").val(data.username);
                $("input[name='rechargeId']").val(data.id);
                layer.open({
                    type: 1,
                    shade: false,
                    title: '会员充值', //不显示标题
                    area: ['500px', '400px'],
                    content: $('.layer_notice'), //捕获的元素，注意：最好该指定的元素要存放在body最外层，否则可能被其它的相对元素所影响
                    cancel: function(){
                        // layer.msg('捕获就是从页面已经存在的元素上，包裹layer的结构', {time: 5000, icon:6});
                        $('.layer_notice').hide();
                    }
                });
            }
            if (obj.event === 'power') {
                layer.confirm('确认开启权限？开启后将不需要按照规则', {icon: 3}, function(index) {
                    var loading = layer.load(1, {shade: [0.1, '#fff']});
                    $.post("<?php echo url('set_power'); ?>",{id:data.id},function(res){
                        layer.close(loading);
                        if(res.code===1){
                            layer.msg(res.msg,{time:1000,icon:1});
                            tableIn.reload();
                        }else{
                            layer.msg('操作失败！',{time:1000,icon:2});
                        }
                    });
                    layer.close(index);
                });
            }
        });

        $('#plJH').click(function(){
            layer.confirm('确认要激活选中用户吗？', {icon: 3}, function(index) {
                layer.close(index);
                var checkStatus = table.checkStatus('user'); //test即为参数id设定的值
                var ids = [];
                $(checkStatus.data).each(function (i, o) {
                    ids.push(o.id);
                });
                var loading = layer.load(1, {shade: [0.1, '#fff']});
                $.post("<?php echo url('plJH'); ?>", {ids: ids}, function (data) {
                    layer.close(loading);
                    if (data.code === 1) {
                        layer.msg(data.msg, {time: 1000, icon: 1});
                        tableIn.reload();
                    } else {
                        layer.msg(data.msg, {time: 1000, icon: 2});
                    }
                });
            });
        });

        $('#yjJH').click(function(){
            layer.confirm('确认要激活所有用户吗？', {icon: 3}, function(index) {
                layer.close(index);
                var checkStatus = table.checkStatus('user'); //test即为参数id设定的值
                var ids = [];
                // $(checkStatus.data).each(function (i, o) {
                //     ids.push(o.id);
                // });
                var loading = layer.load(1, {shade: [0.1, '#fff']});
                $.post("<?php echo url('yjJH'); ?>", {ids: ids}, function (data) {
                    layer.close(loading);
                    if (data.code === 1) {
                        layer.msg(data.msg, {time: 1000, icon: 1});
                        tableIn.reload();
                    } else {
                        layer.msg(data.msg, {time: 1000, icon: 2});
                    }
                });
            });
        })
    });
    function submitRecharge() {
        $.post("<?php echo url('Recharge/recharge'); ?>", {
            rechargeUsername : $("input[name='rechargeUsername']").val(),
            rechargeId : $("input[name='rechargeId']").val(),
            rechargeMoney : $("input[name='rechargeMoney']").val(),
            rechargeType : $("#rechargeType").val()
        }, function (data) {
            if (data.code === 1) {
                layer.msg(data.msg, {time: 1000, icon: 1},function () {
                    window.location.reload();
                });
            } else {
                layer.msg(data.msg, {time: 1000, icon: 2});
            }
        });
    }
</script>
</body>
</html>