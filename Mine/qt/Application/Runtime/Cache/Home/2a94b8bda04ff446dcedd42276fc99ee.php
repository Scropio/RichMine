<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0"/>
    <meta name="format-detection" content="telephone=no,email=no,date=no,address=no">
    <title>祈福香火</title>
    <link rel="stylesheet" type="text/css" href="/Public/app/css/aui.css" />
    <script src="/Public/app/script/jquery.min.js"></script>
    <style>
        .flower_box{
            border-radius:4px;text-align: center; border: 1px solid #E95F8F; margin-left:1%; float: left; width: 48%; margin-top: 1rem;
        }
        .flower_box:nth-child(2n){
            margin-left:2%;
        }
    </style>
</head>
<?php echo W('Body/Index');?>
<?php echo W('Head/Index');?>


    <div class="aui-content" style="overflow: scroll;height: 80%;">
        <div class="aui-row" style="margin-bottom:3.2rem">

            <?php if(is_array($data['data']['data'])): foreach($data['data']['data'] as $key=>$item): ?><div class="aui-col-xs-6 flower_box">
                    <input type="hidden" id="yuyue_temp_<?php echo ($item["id"]); ?>" value="<?php echo ($item["yuyue"]); ?>" />
                    <input type="hidden" id="show_temp_<?php echo ($item["id"]); ?>" value="<?php echo ($item["is_show"]); ?>" />
                    <input type="hidden" id="vip_temp_<?php echo ($item["id"]); ?>" value="<?php echo ($item["is_vip"]); ?>" />
                    <input type="hidden" id="online_temp_<?php echo ($item["id"]); ?>" value="<?php echo ($item["is_online"]); ?>" />
                    <div style="width: 98%;height:98%; margin-top: 1%; margin-left:1%; background-color: #000; margin-bottom: 0.1rem;">
                        <div class="aui-row" style=" margin-top: 0.1rem; margin-bottom: 0.1rem;">
                            <div class="aui-col-xs-12" style="padding:10px;">
                                <img src="<?php echo ($item["thumb"]); ?>" alt="" width="100%">
                            </div>
                        </div>

                        <div class="aui-row">
                            <div class="aui-col-xs-12">
                                <span style="color: white;letter-spacing:1px; text-align: center; text-indent: 0.5rem;font-size: 15px; "><?php echo ($item["title"]); ?></span>
                            </div>
                        </div>

                        <div class="aui-row">
                            <div class="aui-col-xs-6" style="margin-top: 5px;">
                                <img src="/Public/site/images/877fbc05ed74cba6e745976e8f9c6ee.png" alt="" width="100%" style="padding: 0px;">
                            </div>
                            <div class="aui-col-xs-6" style="text-align: right; padding-right: 0.2rem; margin-top: 0.25rem; "><span style="font-size:0.65rem;color: white;"><?php echo ($item["adopt_time"]); ?></span></div>
                        </div>

                        <div class="aui-row" style="font-size:0.59rem; margin-top:4px; padding-left: 0.3rem; padding-right: 0.1rem">
                            <div class="aui-col-xs-4" style="text-align: left"><span style="color: #E95F8F">价值范围:</span></div>
                            <div class="aui-col-xs-8" style="text-align: right"><span style="color: white;font-size: 12px;"><?php echo ($item["price_one"]); ?>-<?php echo ($item["price_two"]); ?></span></div>
                        </div>

                        <div class="aui-row" style="font-size:0.59rem; margin-top:4px; padding-left: 0.3rem; padding-right: 0.1rem">
                            <div class="aui-col-xs-6" style="text-align: left"><span style="color: #E95F8F">预约/自动抢:</span></div>
                            <div class="aui-col-xs-6" style="text-align: right"><span style="color: white;"><?php echo ($item["needgourd"]); ?>/<?php echo ($item["vipneedgourd"]); ?></span></div>
                        </div>

                        <div class="aui-row" style="font-size:0.58rem; margin-top:4px; padding-left: 0.3rem; padding-right: 0.1rem">
                            <div class="aui-col-xs-4" style="text-align: left; width:56%;"><span style="color: #E95F8F;">领养收益:</span></div>
                            <div class="aui-col-xs-8" style="text-align: right; width:44%;"><span style="color: white;"><?php echo ($item["gains"]); ?>%/<?php echo ($item["grow_day"]); ?>天</span></div>
                        </div>

<!--                        <div class="aui-row" style="font-size:0.58rem; margin-top:4px; padding-left: 0.4rem; padding-right: 0.4rem">-->
<!--                            <div class="aui-col-xs-6" style="text-align: left; width:56%;"><span style="color: #E95F8F">可获取CBC:</span></div>-->
<!--                            <div class="aui-col-xs-6" style="text-align: right;width:44%"><span style="color: white;"><?php echo ($item["pgc"]); ?></span></div>-->
<!--                        </div>-->
                     
                        <?php if(($item['yuyue']) == "1"): if((session('token') == '3fb2c60b-cd5a-4c1f-8e66-9af2c6627810') OR (session('token') == 'cd7b84b0-cae4-4f62-9664-63ec839457f9')): ?><div class="aui-btn aui-btn-primary" style="background: #E95F8F; width:80%; margin-top:8px;margin-bottom:20px;" onclick="openDialog('callback','<?php echo ($item["title"]); ?>','<?php echo ($item["price_one"]); ?>','<?php echo ($item["price_two"]); ?>','<?php echo ($item["id"]); ?>')">请预约</div>
                              	
                            <?php else: ?>  
                               <?php if(($item['is_vip']) == "1"): ?><div class="aui-btn aui-btn-primary" style="background: #7b7b7b; width:44%; margin-top:8px;margin-bottom:20px;">已预约</div>
                              		<div class="aui-btn aui-btn-primary shoutime_<?php echo ($item["id"]); ?>" style="background: #7b7b7b; width: 44%;margin-top:8px;margin-bottom:20px;">抢购</div>
                              <?php else: ?> 
                                   <div class="aui-btn aui-btn-primary" style="background: #7b7b7b; width:44%; margin-top:8px;margin-bottom:20px;">已预约</div>                              	  
                              	   <?php if(($item["is_online"] == '1')): ?><div class="aui-btn aui-btn-primary shoutime_<?php echo ($item["id"]); ?>" style="background: #7b7b7b;width: 44%;margin-top:8px;margin-bottom:20px;">抢购</div>
                              	   <?php else: ?>
                              	   		<div class="aui-btn aui-btn-primary" style="width: 44%;margin-top:8px;margin-bottom:20px;" onclick="onlineBuy('callback','<?php echo ($item["title"]); ?>','<?php echo ($item["price_one"]); ?>','<?php echo ($item["price_two"]); ?>','<?php echo ($item["id"]); ?>')">抢购</div><?php endif; endif; endif; ?>                         	
                          
                         <?php else: ?>
                            <div class="aui-btn aui-btn-primary" style="background: #E95F8F; width:40%; margin-top:8px;margin-bottom:20px;" onclick="openDialog('callback','<?php echo ($item["title"]); ?>','<?php echo ($item["price_one"]); ?>','<?php echo ($item["price_two"]); ?>','<?php echo ($item["id"]); ?>')">请预约</div>
                            <div class="aui-btn aui-btn-primary" style="width: 44%;margin-top:8px;margin-bottom:20px;" onclick="autoBuy('callback','<?php echo ($item["title"]); ?>','<?php echo ($item["price_one"]); ?>','<?php echo ($item["price_two"]); ?>','<?php echo ($item["id"]); ?>')">自动抢</div><?php endif; ?>
                    </div>
                </div><?php endforeach; endif; ?>


        </div>
    </div>
    <div id="tian_top_temp" style="width:100%;height: 1000px;margin-top: -600px;position:absolute;z-index:1000;opacity: 0.9;background-color: #fff;display: none;">      
         <div class="aui-row" style=" margin-top: 6.1rem;; margin-bottom: 0.1rem;">
             <div style=" text-align: center; color: red;">正在抢单中，请耐心等待...</div>
             <div class="aui-col-xs-12" style="padding:10px;">            
                <img src="<?php echo ($host_name); ?>/uploads/wait1.gif" alt="" width="100%">
                <!--<img src="<?php echo ($host_name); ?>/uploads/luck.gif" alt="" width="100%"> -->
             </div>            
         </div>
    </div>
  
    <script type="text/javascript" src="/Public/app/script/aui-dialog.js" ></script>
    <script type="text/javascript" src="/Public/app/script/aui-toast.js" ></script>
    <script type="text/javascript">
        apiready = function(){
            api.parseTapmode();
        };

        var toast = new auiToast();
        if('<?php echo ($suc_msg); ?>')
        {
            toast.success({
                title:decodeURI('<?php echo ($suc_msg); ?>'),
                duration:2000
            });
        }

        var dialog = new auiDialog({});
        function openDialog(type,title,price_one,price_two,id){
            switch (type) {
                case "callback":
                    dialog.alert({
                        title:"确认预约："+title,
                        msg:'价格为：'+price_one+'-'+price_two,
                        buttons:['取消','确定']
                    },function(ret){

                        if(2 == ret.buttonIndex)
                        {
                            //向服务器发送请求，开始预约葫芦娃
                            window.location.href = '/index.php/home/index/yhl?id='+id;
                        }

                    });
                    break;
                default:
                    break;
            }
        }
        function  autoBuy(type,title,price_one,price_two,id){
            switch (type) {
            case "callback":
                dialog.alert({
                    title:"确认自动抢："+title,
                    msg:'价格为：'+price_one+'-'+price_two,
                    buttons:['取消','确定']
                },function(ret){

                    if(2 == ret.buttonIndex)
                    {
                        //向服务器发送请求，开始预约葫芦娃
                        window.location.href = '/index.php/home/index/yhlauto?id='+id;
                    }

                });
                break;
            default:
                break;
        }
    }
        function  onlineBuy(type,title,price_one,price_two,id){
            switch (type) {
            case "callback":
                dialog.alert({
                    title:"确认抢购："+title,
                    msg:'价格为：'+price_one+'-'+price_two,
                    buttons:['取消','确定']
                },function(ret){

                    if(2 == ret.buttonIndex)
                    {
                        //向服务器发送请求，开始预约葫芦娃
                        window.location.href = '/index.php/home/index/yhlonline?id='+id;
                    }

                });
                break;
            default:
                break;
        }
    }
        
        var Interval_temp;
        function batch_stop(){        	    	
        	$('#tian_top_temp').css("display","none");
        	$('.shoutime_'+endtime_id).text('已抢购');
        }
        
        function batch_start(){    	
        	batch_start1();
        }
        function batch_start1(endtime_id){ 
        	Interval_temp = setInterval(function() 
        	        {
        		       getdata_temp(endtime_id);
        	        },1000);
        }
        function getdata_temp(endtime_id){
        	 $.ajax({
                 cache : false,
                 type : 'get',
                 dataType: 'json',
                 //url : '<?php echo ($host_name); ?>/api.php/api/Match/images',
                 url : '<?php echo ($host_name); ?>/api.php/api/Match/getMatchdata?cid='+endtime_id+'&token='+"<?php echo ($endtime_token); ?>",
                 success : function(data){
                	 console.log(data);
                	 if(data.data.data==2){                		
                		 $("#tian_top_temp img").attr('src',"<?php echo ($host_name); ?>/uploads/luck.gif"); 
                		// playSound('top_compay_playSound','<?php echo ($host_name); ?>/uploads/luck.mp3');
                		 window.clearInterval(Interval_temp);
                		 setTimeout(function () {
                			 batch_stop();
         	            }, 10000)
                	 }else if(data.data.data==1){
                		 console.log(data.msg);
                	 }else{
                		 $("#tian_top_temp img").attr('src',"<?php echo ($host_name); ?>/uploads/disappoined.gif");  
                		// playSound('top_compay_playSound','<?php echo ($host_name); ?>/uploads/disappoined.mp3');
                		 window.clearInterval(Interval_temp);
                		 setTimeout(function () {
                			 batch_stop();
         	            }, 10000)
                		 console.log(data.msg);                		 
                	 }
                 }
             });
        }         
       
        var endtime_id = "<?php echo ($endtime_id); ?>";
        var yuyue =$('#yuyue_temp_'+<?php echo ($endtime_id); ?>).val();
        var is_show_temp =$('#show_temp_'+<?php echo ($endtime_id); ?>).val();
        if(endtime_id >0 && yuyue >0 && is_show_temp ==0){
        	var endtime = "<?php echo ($endtime); ?>";
        	var is_vip_temp =$('#vip_temp_'+<?php echo ($endtime_id); ?>).val();
        	var is_online_temp =$('#online_temp_'+<?php echo ($endtime_id); ?>).val();
        	if(is_vip_temp ==1 || is_online_temp==1){
        		TimeDown(endtime);
        	}
        }        
        function TimeDown(endDateStr) {
            //结束时间
            endDateStr=endDateStr.replace(new RegExp(/-/gm) ,"/");
            var endDate = new Date(endDateStr);
            //当前时间
            var nowDate = new Date();
            //相差的总秒数
            var totalSeconds = parseInt((endDate - nowDate) / 1000); 
            $('.shoutime_'+endtime_id).text(totalSeconds.toString()+'s');
            if(totalSeconds <= 0){
            	$('.shoutime_'+endtime_id).text('0s');
            	$('#tian_top_temp').css("display","block");
            	batch_start1(endtime_id);
            }else{
	            //延迟一秒执行自己
	            setTimeout(function () {
	                TimeDown(endDateStr);
	            }, 1000)
            }
        }
       /*  function playSound(name,str){  
              $("#top_compay_playSound").html('<embed width="0" height="0"  src="'+str+'" autostart="true" loop="false">');
              document.getElementById(""+name+"").Play();             
              
             
          } */
      //  batch_start1();

    </script>
    <?php echo W('Tab/Index');?>

</body>
</html>