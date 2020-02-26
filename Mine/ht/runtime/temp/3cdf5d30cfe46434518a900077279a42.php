<?php /*a:2:{s:73:"/www/wwwroot/ht.zzhr168.cn/application/admin/view/match/manual_match.html";i:1564642110;s:66:"/www/wwwroot/ht.zzhr168.cn/application/admin/view/common/head.html";i:1564236899;}*/ ?>
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
<link href="/static/common/css/manualMatch.css" rel="stylesheet" />
<link href="/static/common/bootstrap/css/bootstrap.css" rel="stylesheet" />
<script src="/static/common/bootstrap/js/bootstrap.min.js"></script>
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
<!--内容区-->
<div class="inner_content">
    <div style="text-align: center">
        <input type="submit" value="批量匹配" class="btn btn-success" onclick="batch_matching()">
        <!--
        <input type="submit" value="自动刷新" class="btn btn-primary" onclick="batch_start()">
        <input type="submit" value="停止刷新" class="btn btn-danger" onclick="batch_stop()">
        -->
    </div>
    <!--匹配区-->
    <div style="width: 100%;float: left;overflow: hidden;">
        <div style="width: 49%;float: left;margin-right: 2%" class="buy">

            <div class="search">
                <form method="post" action="<?php echo url('Match/manual_match'); ?>">
                    <div class="layui-form-pane" style="margin-top: 15px;">
                        <div class="layui-form-item">
                            <label class="layui-form-label">范围选择</label>
                            <div class="layui-input-inline">
                                <input class="layui-input" placeholder="范围" id="in_set_time" name="in_time" readonly value="<?php echo htmlentities($in_time); ?>">
                            </div>
                        </div>
                    </div>

                    <div class="layui-form-pane" style="margin-top: 15px;">
                        <div class="layui-form-item">
                            <label class="layui-form-label">选择花</label>
                            <div class="layui-input-inline">

                                <select name="inWawa" id="inWawa">
                                    <?php if(is_array($cucurbitas) || $cucurbitas instanceof \think\Collection || $cucurbitas instanceof \think\Paginator): $i = 0; $__LIST__ = $cucurbitas;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                    <option value="<?php echo htmlentities($vo['id']); ?>"><?php echo htmlentities($vo['title']); ?></option>
                                    <?php endforeach; endif; else: echo "" ;endif; ?>
                                </select>

                            </div>
                        </div>
                    </div>

                    <div class="layui-form-pane">
                        <label class="layui-form-label">会员编号</label>
                        <div class="layui-input-inline">
                            <input type="text" name="InUserID" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input" value="<?php echo htmlentities($InUserID); ?>">

                        </div>
                        <div  class="layui-input-inline">
                            <input type="submit" value="搜 索"  class="btn btn-success">
                        </div>
                    </div>
                </form>
            </div>

            <div style="text-align: center">
                <button type="submit" class="btn btn-success" onclick="yjqx()">一键取消预约</button>
            </div>


            <!--排单列表-->
            <div>
                <table class="layui-table listing" lay-even="" lay-skin="row">
                    <thead>
                    <tr>
                        <th><input type="checkbox" name="buy[]" id="buy_all" onclick="buyChecked(this)"></th>
                        <th>会员</th>
                        <th>订单</th>
                        <th>金额</th>
                        <th>花</th>
                        <th>创建时间</th>
                        <th>是否在线</th>
                        <th>VIP</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(is_array($matchInfo_in) || $matchInfo_in instanceof \think\Collection || $matchInfo_in instanceof \think\Paginator): $i = 0; $__LIST__ = $matchInfo_in;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                    <tr>
                        <td><input type="checkbox" name="buy[]" value="<?php echo htmlentities($vo['order_id']); ?>" onclick="buyChecked(this)"></td>
                        <td><?php echo htmlentities($vo['username']); ?></td>

                        <td><?php echo htmlentities($vo['order_id']); ?></td>
                        <td><?php echo htmlentities($vo['money']); ?></td>
                        <td><?php echo htmlentities($vo['c_name']); ?></td>
                        <td><?php echo date('Y-m-d H:i:s',$vo['create_time']); ?></td>
                        <td><?php echo !empty($vo['is_online']) ? '在线' : '不在线'; ?></td>
                        <td><?php echo !empty($vo['is_vip']) ? '是' : '否'; ?></td>
                        <td>
                        <button class="btn btn-primary">买入匹配</button>
                        <a href="<?php echo url('Match/delquxiao'); ?>?oid=<?php echo htmlentities($vo['id']); ?>">
                        <button style="background: #666;margin-left: 10px;" class="btn btn-primary">取消预约</button>
                        </a>
                        </td>
                    </tr>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                    </tbody>
                </table>
                <?php echo $matchInfo_in; ?>
            </div>
            <!--排单列表end-->
        </div>


        <div style="width: 49%;float: left;" class="sell">

            <div class="search">
                <form method="post" action="<?php echo url('Match/manual_match'); ?>">
                    <div class="layui-form-pane" style="margin-top: 15px;">
                        <div class="layui-form-item">
                            <label class="layui-form-label">范围选择</label>
                            <div class="layui-input-inline">
                                <input class="layui-input" placeholder="范围" id="out_set_time" name="out_time" value="<?php echo htmlentities($out_time); ?>">
                            </div>
                        </div>
                    </div>

                    <!--                    <div class="layui-form-pane" style="margin-top: 15px;">-->
                    <!--                        <div class="layui-form-item">-->
                    <!--                            <label class="layui-form-label">选择花</label>-->
                    <!--                            <div class="layui-input-inline">-->

                    <!--                                <select name="outWawa">-->
                    <!--                                    <?php if(is_array($cucurbitas) || $cucurbitas instanceof \think\Collection || $cucurbitas instanceof \think\Paginator): $i = 0; $__LIST__ = $cucurbitas;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>-->
                    <!--                                    <option value="<?php echo htmlentities($vo['id']); ?>"><?php echo htmlentities($vo['title']); ?></option>-->
                    <!--                                    <?php endforeach; endif; else: echo "" ;endif; ?>-->
                    <!--                                </select>-->

                    <!--                            </div>-->
                    <!--                        </div>-->
                    <!--                    </div>-->

                    <div class="layui-form-pane">
                        <label class="layui-form-label">会员编号</label>
                        <div class="layui-input-inline">
                            <input type="text" name="OutUserID" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input" value="<?php echo htmlentities($OutUserID); ?>">

                        </div>
                        <div class="layui-input-inline">
                            <input type="submit" value="搜 索" class="btn btn-success">
                        </div>
                    </div>
                </form>
            </div>
            <!--提现列表-->
            <div class="table-responsive">
                <table class="layui-table listing table table-hover" lay-even="" lay-skin="row">

                    <thead>
                    <tr>
                        <th><input type="checkbox" name="sell[]" id="sell_all" onclick="sellChecked(this)"></th>
                        <th>会员</th>
                        <th>订单</th>
                        <th>金额</th>
                        <th>花</th>
                        <th>创建时间</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(is_array($matchInfo_out) || $matchInfo_out instanceof \think\Collection || $matchInfo_out instanceof \think\Paginator): $i = 0; $__LIST__ = $matchInfo_out;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                    <tr class="sellListInfo">
                        <td><input type="checkbox" name="sell[]" value="<?php echo htmlentities($vo['order_id']); ?>" onclick="sellChecked(this)"></td>
                        <td><?php echo htmlentities($vo['username']); ?></td>
                        <td><?php echo htmlentities($vo['order_id']); ?></td>
                        <td><?php echo htmlentities($vo['money']); ?></td>
                        <td><?php echo htmlentities($vo['c_name']); ?></td>
                        <td><?php echo date('Y-m-d H:i:s',$vo['create_time']); ?></td>
                        <td><button class="btn btn-primary">卖出匹配</button></td>
                    </tr>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                    </tbody>
                </table>


            </div>
            <?php echo $matchInfo_out; ?>

            <!--提现列表end-->
            <div style="height: 120px"></div>

        </div>
        <!--模态框-->
        <!--避免闪现的问题，直接给隐藏最高优先级-->
        <div class="modality" style="display: none">
            <div class="confirm">
                <h2>匹配确认</h2>

                <table class="layui-table listing" lay-even="" lay-skin="row">
                    <colgroup>
                        <col width="150">
                        <col width="150">
                        <col width="200">
                        <col>
                    </colgroup>
                    <thead>
                    <tr>
                        <th>买/卖</th>
                        <th>会员</th>
                        <th>订单</th>
                        <th>金额</th>
                        <th>花</th>
                        <th>申请日期</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>买入</td>
                        <td>MMM003082</td>
                        <td>MMM003082</td>
                        <td>1000.0000</td>
                        <td>1000</td>
                        <td>2016/6/27 14:27:30</td>
                    </tr>
                    <tr>
                        <td>卖出</td>
                        <td>system</td>
                        <td>system</td>
                        <td>1000.0000</td>
                        <td>1000</td>
                        <td>2016/6/27 14:27:30</td>
                    </tr>
                    </tbody>
                </table>

                <div class="trade">
                    <form method="post" name="match" action="<?php echo url('Match/start_manual_match'); ?>">
                        <div class="dealer">
                            <span>MMM257476</span> 买：<span>3000</span>
                            <input id="inCode" name="inCode" type="hidden">
                            <input id="epoints" name="epoints" type="text" disabled="disabled">
                            <input id="outCode" name="outCode" type="hidden">
                            <span>system</span> 卖：<span>9000.0000</span>
                        </div>
                        <div class="push-button">
                            <input type="button" value="关闭">
                            <input type="submit" value="确定" onClick="if(confirm('确定要匹配订单吗?')) return true; else return false;">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--警告-->
        <!--避免闪现的问题，直接给隐藏最高优先级-->
        <div class="warning" style="display: none">
            <div class="content">
                <span>卖出和买入不能相等！</span>
                <a>确定</a>
            </div>
        </div>
    </div>
</div>

<!--全选-->
<script>
    function buyChecked(obj){
        var chbs=document.getElementsByName("buy[]");//获取到复选框的名称
        // alert(chbs.length);
        //全选
        //JS的if判断中Undefined类型视为false，其他类型视为true；
        //obj.id是定义过的值，类型为非Undefined，所以视为true。
        if(obj.id == 'buy_all'){
            for(var i=1;i<chbs.length;i++){
                //若全选框的结果为选中，则进行全选操作,否则进入下一步
                //obj.checked表示复选框当前状态，已选为true，未选为false。
                if(obj.checked == true){
                    var chb = chbs[i];
                    chb.checked = true;
                }
            }

            //全不选
            for(var i=1;i<chbs.length;i++){
                //若全选框的结果为没选中，则进行全不选操作,否则进入下一步
                if(obj.checked == false){
                    var chb = chbs[i];
                    chb.checked = false;
                }
            }
        }else{
            // str = '';
            // for (var i=1;i<chbs.length;i++) {
            //     str = str+"chbs["+i+"].checked && ";
            // }
            // new_str = str.substring(0,str.length-4);
            //若子选择全选，全选框也选中。
            if(false){
                chbs[0].checked = true;
            }else{
                //若子选项没有全选，全选框不选中。
                chbs[0].checked = false;
            }
        }
    }
    function sellChecked(obj){
        var chbs=document.getElementsByName("sell[]");//获取到复选框的名称
        //全选
        //JS的if判断中Undefined类型视为false，其他类型视为true；
        //obj.id是定义过的值，类型为非Undefined，所以视为true。
        if(obj.id == 'sell_all'){
            for(var i=1;i<chbs.length;i++){
                //若全选框的结果为选中，则进行全选操作,否则进入下一步
                //obj.checked表示复选框当前状态，已选为true，未选为false。
                if(obj.checked == true){
                    var chb = chbs[i];
                    chb.checked = true;
                }
            }

            //全不选
            for(var i=1;i<chbs.length;i++){
                //若全选框的结果为没选中，则进行全不选操作,否则进入下一步
                if(obj.checked == false){
                    var chb = chbs[i];
                    chb.checked = false;
                }
            }
        }else{
            //若子选择全选，全选框也选中。chbs[1].checked && chbs[2].checked && chbs[3].checked && chbs[4].checked
            if(false){
                chbs[0].checked = true;
            }else{
                //若子选项没有全选，全选框不选中。
                chbs[0].checked = false;
            }
        }
    }
</script>
<!--end全选-->
<!--批量匹配-->
<script>

    function batch_matching(){
        // if(!confirm('确定要批量匹配吗？')){
        //     return false;
        // }
        var buy=document.getElementsByName("buy[]");//获取到复选框的名称
        var sell=document.getElementsByName("sell[]");//获取到复选框的名称

        var arr_buy=new Array();
        var arr_sell=new Array();
        var k = 0;
        var j = 0;
        for(i=0;i<buy.length;i++){
            if(buy[i].checked && buy[i].value != 'on'){
                arr_buy[k] = buy[i].value;
                k = k+1;
            }
        }
        for(i=0;i<sell.length;i++){
            if(sell[i].checked && sell[i].value != 'on'){
                arr_sell[j] = sell[i].value;
                j = j+1;
            }
        }

        $.post("<?php echo url('Match/batch_matching'); ?>",{arr_buy:arr_buy,arr_sell:arr_sell},function (data) {
            // console.log(data.data);
            alert('成功匹配'+data.data.num_success+'条数据');
            window.location.href = "<?php echo url('Match/manual_match'); ?>";
            return false;
        });
    }
   /*  var Interval_temp;
    function batch_stop(){
    	window.clearInterval(Interval_temp);
    }
    function batch_start(){    	
    	batch_start1();
    }
    function batch_start1(){ 
    	Interval_temp = setInterval(function() 
    	        {
    		       getdata_temp();
    	        },1000);
    }
    function getdata_temp(){
    	window.location.href = "<?php echo url('Match/manual_match'); ?>";
    } */
   // batch_start1();
</script>
<!--end批量匹配-->
<!--一键取消预约-->
<script>
    function yjqx(){
        if(!confirm('确定要一键取消预约吗？')){
            return false;
        }

        var cid = $('#inWawa').val();

        $.ajax({
            cache : false,
            type : 'get',
            dataType: 'json',
            url : "<?php echo url('Match/yjQX'); ?>?cid="+cid,
            contentType : false,  //  不设置Content-type请求头
            processData : false,  //  不处理发送的数据，因为data值是Formdata对象，不需要对数据做处理
            success : function(data){
                window.location.href = "<?php echo url('Match/manual_match'); ?>";
            }
        });
    }
</script>
<!--end一键取消预约-->
<!--时间选择-->
<!--日期选择-->
<script>
    layui.use('laydate', function(){
        var laydate = layui.laydate;

        //日期范围
        laydate.render({
            elem: '#in_set_time'
            ,range: '~'
        });
        //日期范围
        laydate.render({
            elem: '#out_set_time'
            ,range: '~'
        });
    });
</script>
<!--时间选择END-->
<script>
    jQuery(function(){
        jQuery(".listing button").click(function(){
            jQuery(".listing tbody tr").removeClass("bg1")
            jQuery(this).parents("table").parent().parent().siblings().find("tbody tr").addClass("bg1")
            jQuery(".modality tbody tr").removeClass("bg1")
        })

        jQuery(".listing tbody tr").mouseover(function(){
            if(jQuery(this).hasClass("bg1")){
                jQuery(this).addClass("bg2")
            }
        })
        jQuery(".listing tbody tr").mouseout(function(){
            if(jQuery("tbody tr").hasClass("bg2")){
                jQuery(this).removeClass("bg2")
            }
        })

        jQuery(".listing tbody tr").click(function(){
            if(jQuery(this).hasClass("bg1")){
                jQuery(".modality").show()
            }
        })


        jQuery(".buy .listing button").click(function(){
            var a=jQuery(this).parents("tr").find("td").eq(1).text()
            var b=jQuery(this).parents("tr").find("td").eq(2).text()
            var c=jQuery(this).parents("tr").find("td").eq(3).text()
            var d=jQuery(this).parents("tr").find("td").eq(4).text()
            var e=jQuery(this).parents("tr").find("td").eq(5).text()

            jQuery(".modality table tbody").find("tr").eq(0).children().eq(1).text(a)
            jQuery(".modality table tbody").find("tr").eq(0).children().eq(2).text(b)
            jQuery(".modality table tbody").find("tr").eq(0).children().eq(3).text(c)
            jQuery(".modality table tbody").find("tr").eq(0).children().eq(4).text(d)
            jQuery(".modality table tbody").find("tr").eq(0).children().eq(5).text(e)
            jQuery(".dealer").find("span").eq(0).text(b)
            jQuery(".dealer").find("span").eq(1).text(c)
            jQuery("#inCode").val(b)



            jQuery(".sell .listing  tbody tr").click(function(){
                var f=jQuery(this).find("td").eq(1).text()
                var g=jQuery(this).find("td").eq(2).text()
                var h=jQuery(this).find("td").eq(3).text()
                var j=jQuery(this).find("td").eq(4).text()
                var k=jQuery(this).find("td").eq(5).text()

                jQuery(".modality table tbody").find("tr").eq(1).children().eq(1).text(f)
                jQuery(".modality table tbody").find("tr").eq(1).children().eq(2).text(g)
                jQuery(".modality table tbody").find("tr").eq(1).children().eq(3).text(h)
                jQuery(".modality table tbody").find("tr").eq(1).children().eq(4).text(j)
                jQuery(".modality table tbody").find("tr").eq(1).children().eq(5).text(k)
                jQuery(".dealer").find("span").eq(2).text(g)
                jQuery(".dealer").find("span").eq(3).text(h)
                jQuery("#outCode").val(g)
                jQuery("#epoints").val(h)

            })
        })

        jQuery(".sell .listing  button").click(function(){

            var a=jQuery(this).parents("tr").find("td").eq(1).text()
            var b=jQuery(this).parents("tr").find("td").eq(2).text()
            var c=jQuery(this).parents("tr").find("td").eq(3).text()
            var d=jQuery(this).parents("tr").find("td").eq(4).text()
            var e=jQuery(this).parents("tr").find("td").eq(5).text()

            jQuery(".modality table tbody").find("tr").eq(1).children().eq(1).text(a)
            jQuery(".modality table tbody").find("tr").eq(1).children().eq(2).text(b)
            jQuery(".modality table tbody").find("tr").eq(1).children().eq(3).text(c)
            jQuery(".modality table tbody").find("tr").eq(1).children().eq(4).text(d)
            jQuery(".modality table tbody").find("tr").eq(1).children().eq(5).text(e)
            jQuery(".dealer").find("span").eq(2).text(b)
            jQuery(".dealer").find("span").eq(3).text(c)
            jQuery("#outCode").val(b)
            jQuery("#epoints").val(c)


            jQuery(".buy .listing tbody tr").click(function(){
                var f=jQuery(this).find("td").eq(1).text()
                var g=jQuery(this).find("td").eq(2).text()
                var h=jQuery(this).find("td").eq(3).text()
                var j=jQuery(this).find("td").eq(4).text()
                var k=jQuery(this).find("td").eq(5).text()

                jQuery(".modality table tbody").find("tr").eq(0).children().eq(1).text(f)
                jQuery(".modality table tbody").find("tr").eq(0).children().eq(2).text(g)
                jQuery(".modality table tbody").find("tr").eq(0).children().eq(3).text(h)
                jQuery(".modality table tbody").find("tr").eq(0).children().eq(4).text(j)
                jQuery(".modality table tbody").find("tr").eq(0).children().eq(5).text(k)
                jQuery(".dealer").find("span").eq(0).text(g)
                jQuery(".dealer").find("span").eq(1).text(h)
                jQuery("#inCode").val(g)

            })
        })

        jQuery(".push-button input[type='button']").click(function(){
            jQuery(".modality").hide();
        })

        jQuery(".push-button input[type='submit']").click(function(){
            jQuery(".modality").hide();
            var incode=jQuery("#inCode").val();
            var outCode=jQuery("#outCode").val();
            if(incode==outCode){
                jQuery(".warning").show();
            }
        })

        jQuery(".warning a").click(function(){
            jQuery(".warning").hide();
        })

    })
</script>