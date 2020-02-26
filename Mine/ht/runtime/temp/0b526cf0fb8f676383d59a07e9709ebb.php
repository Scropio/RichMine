<?php /*a:3:{s:68:"/www/wwwroot/ht.qy-315.cn/application/admin/view/cucurbita/form.html";i:1564642172;s:65:"/www/wwwroot/ht.qy-315.cn/application/admin/view/common/head.html";i:1564236899;s:65:"/www/wwwroot/ht.qy-315.cn/application/admin/view/common/foot.html";i:1564236899;}*/ ?>
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
            <label class="layui-form-label">名称</label>
            <div class="layui-input-4">
                <input type="text" name="title" ng-model="field.title" lay-verify="required" placeholder="<?php echo lang('pleaseEnter'); ?>名称" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">图片</label>
            <input type="hidden" name="thumb" id="thumb" value="{{field.thumb}}">
            <div class="layui-input-block">
                <div class="layui-upload">
                    <button type="button" class="layui-btn layui-btn-primary" id="adBtn"><i class="icon icon-upload3"></i>点击上传</button>
                    <div class="layui-upload-list">
                        <img class="layui-upload-img" id="adPic">
                        <p id="demoText"></p>
                    </div>
                </div>
            </div>
        </div>
     
        <div class="layui-form-item">
            <label class="layui-form-label">是否审核</label>
            <div class="layui-input-block">
                <input type="radio" name="status" ng-model="field.status" ng-checked="field.status==1" ng-value="1" title="<?php echo lang('open'); ?>">
                <input type="radio" name="status" ng-model="field.status" ng-checked="field.status==0" ng-value="0" title="<?php echo lang('close'); ?>">
            </div>
        </div>
       
        <div class="layui-form-item">
            <label class="layui-form-label">领养时间</label>
            <div class="layui-input-4">
                <input type="text" name="adopt_time" ng-model="field.adopt_time" lay-verify="required" placeholder="<?php echo lang('pleaseEnter'); ?>领养时间" class="layui-input">
            </div>
        </div>
         <div class="layui-form-item">
            <label class="layui-form-label">价值</label>
            <div class="layui-input-4">
                <input type="text" name="price" ng-model="field.price" lay-verify="required" placeholder="<?php echo lang('pleaseEnter'); ?>价值" class="layui-input">
            </div>
        </div>
         <div class="layui-form-item">
            <label class="layui-form-label">预约价范围</label>
            <div class="layui-input-4">
                <input type="text" name="price_one" ng-model="field.price_one" lay-verify="required" placeholder="<?php echo lang('pleaseEnter'); ?>预约价" class="layui-input">
                  <input type="text" name="price_two" ng-model="field.price_two" lay-verify="required" placeholder="<?php echo lang('pleaseEnter'); ?>预约价" class="layui-input">
            </div>
        </div>
         <div class="layui-form-item">
            <label class="layui-form-label">所需花粉</label>
            <div class="layui-input-4">
                <input type="text" name="needgourd" ng-model="field.needgourd" lay-verify="required" placeholder="<?php echo lang('pleaseEnter'); ?>所需花粉" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">VIP所需花粉</label>
            <div class="layui-input-4">
                <input type="text" name="vipneedgourd" ng-model="field.vipneedgourd" lay-verify="required" placeholder="<?php echo lang('pleaseEnter'); ?>VIP所需花粉" class="layui-input">
            </div>
        </div>
         <div class="layui-form-item">
            <label class="layui-form-label">合约收益(%)</label>
            <div class="layui-input-4">
                <input type="text" name="gains" ng-model="field.gains" lay-verify="required" placeholder="<?php echo lang('pleaseEnter'); ?>合约收益" class="layui-input">
            </div>
        </div>
         <div class="layui-form-item">
            <label class="layui-form-label">生长天数</label>
            <div class="layui-input-4">
                <input type="text" name="grow_day" ng-model="field.grow_day" lay-verify="required" placeholder="<?php echo lang('pleaseEnter'); ?>合约收益" class="layui-input">
            </div>
        </div>
         <div class="layui-form-item">
            <label class="layui-form-label">可获得PGC</label>
            <div class="layui-input-4">
                <input type="text" name="pgc" ng-model="field.pgc" lay-verify="required" placeholder="<?php echo lang('pleaseEnter'); ?>可获得PGC" class="layui-input">
            </div>
        </div>
        
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
<script src="/static/ueditor/ueditor.config.js" type="text/javascript"></script>
<script src="/static/ueditor/ueditor.all.min.js" type="text/javascript"></script>
<script>
    var m = angular.module('hd',[]);
    m.controller('ctrl',['$scope',function($scope) {
        $scope.field = '<?php echo $info; ?>'!='null'?<?php echo $info; ?>:{catid:'',id:'',title:'',status:1,thumb:'',content:''};
        $scope.group = <?php echo $adtypeList; ?>;
        $scope.selected = <?php echo $selected; ?>;
        layui.use(['form', 'layer','upload'], function () {
            var form = layui.form, $ = layui.jquery, upload = layui.upload;
            if($scope.field.thumb){
                adPic.src = $scope.field.thumb;
            }
            form.on('submit(submit)', function (data) {
                // 提交到方法 默认为本身
                data.field.id = $scope.field.id;
                var loading = layer.load(1, {shade: [0.1, '#fff']});
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
            });
            //普通图片上传
            var uploadInst = upload.render({
                elem: '#adBtn'
                ,url: '<?php echo url("UpFiles/upload"); ?>'
                ,before: function(obj){
                    //预读本地文件示例，不支持ie8
                    obj.preview(function(index, file, result){
                        $('#adPic').attr('src', result); //图片链接（base64）
                    });
                },
                done: function(res){
                    if(res.code>0){
                        $('#thumb').val(res.url);
                    }else{
                        //如果上传失败
                        return layer.msg('上传失败');
                    }
                }
                ,error: function(){
                    //演示失败状态，并实现重传
                    var demoText = $('#demoText');
                    demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-mini demo-reload">重试</a>');
                    demoText.find('.demo-reload').on('click', function(){
                        uploadInst.upload();
                    });
                }
            });
        });
    }]);
      
</script>