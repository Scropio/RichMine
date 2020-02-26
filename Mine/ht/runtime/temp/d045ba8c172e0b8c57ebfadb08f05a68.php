<?php /*a:3:{s:65:"/www/wwwroot/ht.zzhr168.cn/application/admin/view/users/edit.html";i:1566316884;s:66:"/www/wwwroot/ht.zzhr168.cn/application/admin/view/common/head.html";i:1564236899;s:66:"/www/wwwroot/ht.zzhr168.cn/application/admin/view/common/foot.html";i:1564236899;}*/ ?>
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
<div class="admin-main layui-anim layui-anim-upbit" ng-app="hd" ng-controller="ctrl">
    <fieldset class="layui-elem-field layui-field-title">
        <legend><?php echo htmlentities($title); ?></legend>
    </fieldset>
    <form class="layui-form layui-form-pane">
        <div class="layui-form-item">
            <label class="layui-form-label">所属用户组</label>
            <div class="layui-input-4">
                <select name="level" lay-verify="required" ng-model="field.level" ng-options="v.level_id as v.level_name for v in group" ng-selected="v.level_id==field.level">
                    <option value="">请选择会员组</option>
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">用户名</label>
            <div class="layui-input-4">
                <input type="text" name="username" readonly ng-model="field.username" lay-verify="required" placeholder="<?php echo lang('pleaseEnter'); ?><?php echo lang('nickname'); ?>" class="layui-input">
            </div>
        </div>
         <div class="layui-form-item">
            <label class="layui-form-label">手机号码</label>
            <div class="layui-input-4">
                <input type="text" name="mobile" readonly ng-model="field.mobile" lay-verify="required" placeholder="<?php echo lang('pleaseEnter'); ?><?php echo lang('nickname'); ?>" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">真实姓名</label>
            <div class="layui-input-4">
                <input type="text" name="realname" ng-model="field.realname" lay-verify="required" placeholder="真实姓名" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">身份证号</label>
            <div class="layui-input-4">
                <input type="text" name="IDcard" ng-model="field.IDcard" lay-verify="required" placeholder="身份证号" class="layui-input">
            </div>
        </div>
       <!--  <div class="layui-form-item">
            <label class="layui-form-label">支付宝</label>
            <div class="layui-input-4">
                <input type="text" name="alipay" ng-model="field.alipay" lay-verify="required" placeholder="支付宝" class="layui-input">
            </div>
        </div> -->
        <!--<div class="layui-form-item">-->
            <!--<label class="layui-form-label">微信</label>-->
            <!--<div class="layui-input-4">-->
                <!--<input type="text" name="wechat" ng-model="field.wechat" lay-verify="required" placeholder="微信" class="layui-input">-->
            <!--</div>-->
        <!--</div>-->
 <!--        <div class="layui-form-item">
            <label class="layui-form-label">开户银行</label>
            <div class="layui-input-4">
                <input type="text" name="bank_name" ng-model="field.bank_name" lay-verify="required" placeholder="开户银行" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">银行卡号</label>
            <div class="layui-input-4">
                <input type="text" name="bank_card" ng-model="field.bank_card" lay-verify="required" placeholder="银行卡号" class="layui-input">
            </div>
        </div> -->
        <!--<div class="layui-form-item">-->
            <!--<label class="layui-form-label"><?php echo lang('email'); ?></label>-->
            <!--<div class="layui-input-4">-->
                <!--<input type="text" name="email" ng-model="field.email" lay-verify="eamil" placeholder="输入<?php echo lang('email'); ?>" class="layui-input">-->
            <!--</div>-->
            <!--<div class="layui-form-mid layui-word-aux">-->
                <!--必填：用于找回密码-->
            <!--</div>-->
        <!--</div>-->
        <!--<div class="layui-form-item">-->
            <!--<label class="layui-form-label"><?php echo lang('tel'); ?></label>-->
            <!--<div class="layui-input-4">-->
                <!--<input type="text" name="mobile" ng-model="field.mobile" lay-verify="mobile" placeholder="输入<?php echo lang('tel'); ?>" class="layui-input">-->
            <!--</div>-->
            <!--<div class="layui-form-mid layui-word-aux">-->
                <!--只能填写数字-->
            <!--</div>-->
        <!--</div>-->
        <div class="layui-form-item">
            <label class="layui-form-label"><?php echo lang('pwd'); ?></label>
            <div class="layui-input-4">
                <input type="password" name="password" placeholder="输入<?php echo lang('pwd'); ?>" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux">
                密码必须大于6位，小于18位
            </div>
        </div>
         <div class="layui-form-item">
            <label class="layui-form-label"><?php echo lang('支付密码'); ?></label>
            <div class="layui-input-4">
                <input type="password" name="paypwd" placeholder="输入<?php echo lang('支付密码'); ?>" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux">
                密码必须大于6位，小于18位
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label"><?php echo lang('sex'); ?></label>
                <div class="layui-input-block">
                    <input type="radio" name="sex" ng-model="field.sex" ng-checked="field.sex==1" ng-value="1" title="<?php echo lang('man'); ?>">
                    <input type="radio" name="sex" ng-model="field.sex" ng-checked="field.sex==0" ng-value="0" title="<?php echo lang('woman'); ?>">
                </div>
            </div>
        </div>
         <!--<div class="layui-form-item">
            <label class="layui-form-label">短信</label>
            <div class="layui-input-4">
              <input type="text" name="sendCode"  id="sendCode" placeholder="验证码" class="layui-input" style="width: 50%;float: left;">
                        <button type="button" onclick="sendCode(this)"
		                       id="send-code" style="    height: 40px;" >发送验证码
		                </button>

            </div>
            <div class="layui-form-mid layui-word-aux">
                
            </div>
        </div>      -->
        <!--<div class="layui-form-item">-->
            <!--<label class="layui-form-label"><?php echo lang('qq'); ?></label>-->
            <!--<div class="layui-input-4">-->
                <!--<input type="text" name="qq" ng-model="field.qq" placeholder="输入<?php echo lang('qq'); ?>" class="layui-input">-->
            <!--</div>-->
        <!--</div>-->
        <!--<div class="layui-form-item">-->
            <!--<label class="layui-form-label"><?php echo lang('address'); ?></label>-->
            <!--<div class="layui-input-inline">-->
                <!--<select name="province" ng-model="field.province" lay-filter="province" ng-options="v.id as v.name for v in province" ng-selected="v.id==field.province">-->
                    <!--<option value="">请选择省</option>-->
                <!--</select>-->
            <!--</div>-->
            <!--<div class="layui-input-inline" >-->
                <!--<select name="city" id="city" ng-model="field.city" lay-filter="city" ng-options="v.id as v.name for v in city" ng-selected="v.id==field.city">-->
                    <!--<option value="">请选择市</option>-->
                <!--</select>-->
            <!--</div>-->
            <!--<div class="layui-input-inline">-->
                <!--<select name="district" id="district" ng-model="field.district" lay-filter="district" ng-options="v.id as v.name for v in district" ng-selected="v.id==field.district">-->
                    <!--<option value="">请选择县/区</option>-->
                <!--</select>-->
            <!--</div>-->
        <!--</div>-->
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button type="button" class="layui-btn" lay-submit="" lay-filter="submit"><?php echo lang('submit'); ?></button>
                <a href="<?php echo url('index'); ?>" class="layui-btn layui-btn-primary"><?php echo lang('back'); ?></a>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript" src="/static/plugins/layui/layui.js"></script>


<script src="/static/common/js/angular.min.js"></script>
<script>
    var m = angular.module('hd',[]);
    m.controller('ctrl',function($scope) {
        $scope.field = <?php echo $info; ?>;
        $scope.group = <?php echo $user_level; ?>;
        $scope.province = <?php echo $province; ?>;
        $scope.city = <?php echo $city; ?>;
        $scope.district = <?php echo $district; ?>;
        layui.use(['form', 'layer'], function () {
            var form = layui.form, layer = layui.layer,$= layui.jquery;
            form.on('select(province)', function(data) {
                var pid = data.value;
                var loading = layer.load(1, {shade: [0.1, '#fff']});
                $.get("<?php echo url('getRegion'); ?>?pid=" + pid, function (data) {
                    layer.close(loading);
                    var html='<option value="">请选择市</option>';
                    $.each(data, function (i, value) {
                        html += '<option value="number:'+value.id+'">'+value.name+'</option>';
                    });
                    $('#city').html(html);
                    $('#district').html('<option value="">请选择县/区</option>');
                    form.render()
                });
            });
            form.on('select(city)', function(data) {
                var pid = data.value;
                var loading = layer.load(1, {shade: [0.1, '#fff']});
                $.get("<?php echo url('getRegion'); ?>?pid=" + pid, function (data) {
                    layer.close(loading);
                    var html='<option value="">请选择县/区</option>';
                    $.each(data, function (i, value) {
                        html += '<option value="number:'+value.id+'">'+value.name+'</option>';
                    });
                    $('#district').html(html);

                    form.render()
                });
            });
            form.on('submit(submit)', function (data) {
                // 提交到方法 默认为本身
                var loading = layer.load(1, {shade: [0.1, '#fff']});
                data.field.id = $scope.field.id;
                $.post("", data.field, function (res) {
                    layer.close(loading);
                    if (res.code > 0) {
                        layer.msg(res.msg, {time: 1800, icon: 1}, function () {
                            location.href = res.url;
                        });
                    } else {
                        layer.msg(res.msg, {time: 1800, icon: 2});
                    }
                });
            })
        });
    });
</script>
</body>
</html>