<?php /*a:3:{s:79:"/www/wwwroot/ht.qy-315.cn/application/admin/view/users/check_personal_data.html";i:1564236895;s:65:"/www/wwwroot/ht.qy-315.cn/application/admin/view/common/head.html";i:1564236899;s:65:"/www/wwwroot/ht.qy-315.cn/application/admin/view/common/foot.html";i:1564236899;}*/ ?>
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
        <legend>审核列表</legend>
    </fieldset>
    <div class="demoTable">
        <div class="layui-inline">
            <input class="layui-input" name="key" id="key" placeholder="<?php echo lang('pleaseEnter'); ?>关键字">
        </div>
        <button class="layui-btn" id="search" data-type="reload">搜索</button>
        <!--<a href="<?php echo url('index'); ?>" class="layui-btn">显示全部</a>-->
        <button type="button" class="layui-btn layui-btn-danger" id="plSH">批量审核</button>
    </div>
    <table class="layui-table" id="list" lay-filter="list"></table>
</div>
<style type="text/css" media="screen">
    .layui-table-cell {
    height: 78px;
    line-height: 78px;
    padding: 0 15px;
    position: relative;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    box-sizing: border-box;
}
</style>
<script type="text/html" id="is_lock">
    <input type="checkbox" name="is_lock" value="{{d.id}}" lay-skin="switch" lay-text="正常|禁用" lay-filter="is_lock" {{ d.is_lock == 0 ? 'checked' : '' }}>
</script>
<script type="text/html" id="IDcardimg1">
   <img src="{{d.IDcardimg1}}" alt="">
</script>
<script type="text/html" id="IDcardimg2">
    <img src="{{d.IDcardimg2}}" alt="">
</script>
<script type="text/html" id="action">
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="check_personal_save">审核</a>
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
            url: '<?php echo url("check_personal_data"); ?>',
            method: 'post',
            page: true,
            cols: [[
                {checkbox:true,fixed: true},
                // {field: 'id', title: '<?php echo lang("id"); ?>', width: 80, fixed: true},
                {field: 'username', title: '<?php echo lang("username"); ?>', width: 120},
                // {field: 'is_lock', align: 'center',title: '<?php echo lang("status"); ?>', width: 120,toolbar: '#is_lock'},
                {field: 'realname', title: '真实姓名', width: 100},
                {field: 'mobile', title: '手机号码', width: 160},
                 {field: 'IDcard', title: '身份证号', width: 200},
                 {field: 'IDcardimg1', title: '身份证正面', width: 150,toolbar: '#IDcardimg1'},
                 {field: 'IDcardimg2', title: '身份证反面', width: 150,toolbar: '#IDcardimg2'},
                // {field: 'bank_name', title: '开户银行', width: 200},
                // {field: 'bank_card', title: '银行卡号', width: 220},
                {field: 'reg_time', title: '注册时间', width: 150},
                {field: 'examine_apply_time', title: '提交时间', width: 180},
                {field: 'examine_agree_time', title: '审核时间', width: 180},
                {field: 'examine', title: '审核状态', width: 100},
                {width: 160, align: 'center', toolbar: '#action'}
            ]],
            limit: 10 //每页默认显示的数量
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
            if (obj.event === 'check_personal_save') {
                layer.confirm('您确定要审核会员资料吗？', function(index){
                    var loading = layer.load(1, {shade: [0.1, '#fff']});
                    $.post("<?php echo url('check_personal_save'); ?>",{id:data.id},function(res){
                        layer.close(loading);
                        if(res.code===1){
                            layer.msg(res.msg,{time:1000,icon:1});
                            tableIn.reload();
                        }else{
                            layer.msg(res.msg,{time:1500,icon:2});
                        }
                    });
                    layer.close(index);
                });
            }
        });

        $('#plSH').click(function(){
            layer.confirm('确认审核选中的信息吗？', {icon: 3}, function(index) {
                layer.close(index);
                var checkStatus = table.checkStatus('user'); //test即为参数id设定的值
                var ids = [];
                $(checkStatus.data).each(function (i, o) {
                    ids.push(o.id);
                });
                var loading = layer.load(1, {shade: [0.1, '#fff']});
                $.post("<?php echo url('plSH'); ?>", {ids: ids}, function (data) {
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
</script>
</body>
</html>