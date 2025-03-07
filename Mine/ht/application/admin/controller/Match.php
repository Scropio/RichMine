<?php
namespace app\admin\controller;
use app\admin\model\Users as UsersModel;
use app\admin\model\Match as MatchModel;
use app\admin\model\Match2 as MatchModel2;
use think\console\Input;
use think\db;
use think\facade\Hook;
use app\api\model\Cucurbita as CucurbitaModel;
use think\Request;
use think\config;

class Match extends Common{
    public function initialize()
    {
        Hook::add('SendSMS','app\\common\behavior\\SendSMS');
        Hook::add('FinishMatchTrader','app\\common\behavior\\FinishMatchTrader');
    }

    public function manual_match(){
        /*---------排单部分--------*/
        $in_time = explode('~',input('in_time'));
        $in_startDate = strtotime(trim($in_time['0']));
        $in_endDate   = strtotime(trim($in_time['1']));
        $InUserID   = trim(input('InUserID'));
        $inWawa   = trim(input('inWawa',1));
      	
      	//var_dump($inWawa);
      
        //$outWawa   = trim(input('outWawa',0));
        $is_in_time = input('in_time');
        if (!empty($is_in_time)){
            $this->assign('in_time',input('in_time'));
        }
        if (!empty($in_startDate))$inWhere[] = ['create_time','>=',$in_startDate];
        if (!empty($in_endDate))$inWhere[] = ['create_time','<=',$in_endDate];
        if (!empty($in_endDate) && !empty($in_startDate))$inWhere[] = ['create_time','between',[$in_startDate,$in_endDate]];
        if (!empty($InUserID)){
            $inWhere[]  = ['username','=',$InUserID];
            $this->assign('InUserID',$InUserID);
        }
        $inWhere[]  = ['order_type','=',0];
        $inWhere[]  = ['match_status','=',0];

        if ($inWawa)
        {
            $list = MatchModel::where($inWhere)->where('cid',$inWawa)->paginate(100,false,[
                'type'     => 'bootstrap',
                'var_page' => 'page_in',
                'query' => request()->param(),
            ]);
        }else
        {
            $list = MatchModel::where($inWhere)->paginate(100,false,[
                'type'     => 'bootstrap',
                'var_page' => 'page_in',
                'query' => request()->param(),
            ]);
        }
     

        $this->assign('matchInfo_in',$list);



        /*---------提现部分--------*/
        $out_time = explode('~',input('out_time'));
        $out_startDate =  strtotime(trim($out_time['0']));
        $out_endDate   =  strtotime(trim($out_time['1']));
        $OutUserID   = trim(input('OutUserID'));
        $is_out_time = input('out_time');
        if (!empty($is_out_time)){
            $this->assign('out_time',input('out_time'));

        }
        if (!empty($out_startDate))$outWhere[] = ['create_time','>=',$out_startDate];
        if (!empty($out_endDate))$outWhere[] = ['create_time','<=',$out_endDate];
        if (!empty($out_startDate) && !empty($out_endDate))$outWhere[] = ['create_time','between',[$out_startDate,$out_endDate]];
        if (!empty($OutUserID)){
            $outWhere[]  = ['username','=',$OutUserID];
            $this->assign('OutUserID',$OutUserID);
        }
        $outWhere[]  = ['order_type','=',1];
        $outWhere[]  = ['unmatched','>',0];
      	//$outWhere[]  = ['match_status','=',1];

        if($inWawa)
        {
            $list2 = MatchModel::where($outWhere)->where('cid',$inWawa)->paginate(100,false,[
                'type'     => 'bootstrap',
                'var_page' => 'page_out',
                'query' => request()->param()
            ]);
        }else
        {
            $list2 = MatchModel::where($outWhere)->paginate(100,false,[
                'type'     => 'bootstrap',
                'var_page' => 'page_out',
                'query' => request()->param()
            ]);
        }
      
      	//var_dump(Db::table('match')->getLastSql());
        
        //查询花用于筛选匹配
        $cucurbitas = CucurbitaModel::select();

        //var_dump($cucurbitas);
        $this->assign('cucurbitas',$cucurbitas);
        $this->assign('matchInfo_out',$list2);
        return $this->fetch();
    }

    public function start_manual_match(){
        $inCode = input('inCode');
        $outCode = input('outCode');

        $inWhere[] = ['clt_match.order_id','=',$inCode];
        $inWhere[] = ['clt_match.is_pay','=',0];
        $inWhere[] = ['clt_match.order_type','=',0];
        $inWhere[] = ['clt_match.match_status','<',2];

        $outWhere[] = ['clt_match.order_id','=',$outCode];
        $outWhere[] = ['clt_match.is_pay','=',0];
        $outWhere[] = ['clt_match.order_type','=',1];
        $outWhere[] = ['clt_match.match_status','<',2];


        $order_in = MatchModel::where($inWhere)->join('clt_users','clt_match.uid = clt_users.id')->field('clt_match.id,clt_match.cid,clt_match.c_name,clt_match.uid,clt_match.username,clt_match.order_id,clt_match.money,clt_users.mobile')->find();
        if(!$order_in)$this->error('进场订单不存在或已匹配');

        $order_out = MatchModel::where($outWhere)->join('clt_users','clt_match.uid = clt_users.id')->field('clt_match.id,clt_match.cid,clt_match.c_name,clt_match.uid,clt_match.username,clt_match.order_id,clt_match.money,clt_users.mobile')->find();
        if(!$order_out)$this->error('出场订单不存在或已匹配');

        $epoints=$order_out['money'];

        if ($order_in['cid']!==$order_out['cid'])$this->error('该两笔订单预约等级不同。不能进行匹配');
        if($order_in['uid']==$order_out['uid'])$this->error('不能与自身匹配');

        // 获取默认银行卡的手机号
        $mobile_in = DB::name('bankreceivables')->where(['uid'=>$order_in['uid'],'moren'=>1])->field('mobile')->find();
        if(empty($mobile_in)){
            $mobile_in['mobile'] = $order_in['mobile'];
        }
        $mobile_out = DB::name('bankreceivables')->where(['uid'=>$order_out['uid'],'moren'=>1])->field('mobile')->find();
        if(empty($mobile_out)){
            $mobile_out['mobile'] = $order_out['mobile'];
        }

        $time = time();
        //开始时间|结束时间|超时开始时间，在设定时间段内匹配将按照当前匹配时间计算超时，在非设定时间段内匹配则按照当天8点开始计算，超过则按明天8点，在匹配时间段内不可执行打款操作
        $match_time = explode('|',db::name('system_config')->where('name','match_time')->value('value'));
        $today = strtotime(date('Y-m-d'));
        if ( ($time > $today+$match_time[0]*3600) && ($time < $today+$match_time[1]*3600)){
            $appointment = 0;   //实时匹配
        }else{
            $appointment = 1;   //预匹配进行中
            if ($time < $today+$match_time[0]*3600)$time = $today + $match_time[2] * 3600;
            if ($time > $today+$match_time[1]*3600)$time = $today + $match_time[2] * 3600 + 86400;
        }
        Db::startTrans();
        try{
            if ($order_in['cid']==$order_out['cid']){
                Db::name('match')->update([
                    'id'=>$order_in['id'],
                    'match_status'=>2,
                    'match_time'=>$time,
                    'money'=>Db::raw('money+'.$epoints),
                    'appointment'=>$appointment
                ]);
            }
            if ($order_in['cid']==$order_out['cid']){
                Db::name('match')->update([
                    'id'=>$order_out['id'],
                    'match_status'=>2,
                    'match_time'=>$time,
                    'unmatched'=>Db::raw('unmatched-'.$epoints),
                    'appointment'=>$appointment
                ]);
            }
            $matchOrderId = 'M'.date('YmdHis').rand(1,9).rand(10,99).rand(100,999);

            $data					= array();
            $data['order_id']	    = $matchOrderId;
            $data['in_order_id']	= $order_in['order_id'];
            $data['out_order_id']	= $order_out['order_id'];
            $data['uid']			= $order_in['uid'];
            $data['username']		= $order_in['username'];
            $data['bid']			= $order_out['uid'];
            $data['busername']		= $order_out['username'];
            $data['create_time']	= $time;  //创建时间（匹配时间）
            $data['money']			= $epoints;
            $data['appointment']	= $appointment;
            $data['cid']            = $order_in['cid'];
            $data['c_name']         = $order_in['c_name'];
            Db::name('match2')->insert($data);

            //新增一条记录，用于提示用户匹配状态
//            Db::name('pp_msg')->insertAll([
//                [
//                    'type' => 1, //买入
//                    'uid' => $order_in['uid'],
//                    'username' => $order_in['username'],
//                    'uread' => 0,
//                    'msg' => '您与 '.$order_out['username'].' 的匹配 '.$order_in['c_name'].' 在 '.date('Y-m-d H:i',$time).' 成功',
//                ],
//
//                [
//                    'type' => 2, //卖出
//                    'uid' => $order_out['uid'],
//                    'username' => $order_out['username'],
//                    'uread' => 0,
//                    'msg' => '您与 '.$order_in['username'].' 的匹配 '.$order_in['c_name'].' 在 '.date('Y-m-d H:i',$time).' 成功',
//                ],
//
//            ]);

            // 提交事务
            Db::commit();
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            $this->error("错误：".$e->getMessage());
        }
        //实时匹配发送短信
        if ($appointment==0){
            /*
             * curl 请求 发送短信接口。返回   0  发送成功
             * 'u' => config('sms_username'),
             * 'p' => config('sms_password'),
             * 'm' => $order_in['mobile'],
             * 'c' => "【花粉兄弟】您的订单已经预约成功请登录查看。账号：".$order_in['username']." 时间：".date('Y-m-d h:i:s',$time),
             */

            // 卖出
            //$data_out = $this->_curlPost(array(),config('API_HOST').'/sms?u='.config('sms_username').'&p='.config('sms_password').'&m='.$mobile_out['mobile'].'&c=【花粉兄弟】您的订单已经成功请登录查看。账号：'.$order_out['username'].' 时间：'.date('Y-m-d h:i:s',$time));

            //您发起的提供帮助现已匹配成功，请登录后台查看并及时处理
//            $param_buy = [
//                'mobile'        => $order_in['username'],
//                'code'          => '',
//                'templateID'    => 116760,
//                'smsType'       => '聚合短信'
//            ];
//            Hook::listen('SendSMS',$param_buy);
        }else{
            db::name('sms_queue')->insert([
                'mobile' => $order_in['username'],
                'create_time' => time(),
                'template' => 116760,
                'smsType'       => '聚合短信',
                'send_time' => $time
            ]);
        }
      // 买入
      $data_in = $this->_curlPost(array(),config('API_HOST').'/sms?u='.config('sms_username').'&p='.config('sms_password').'&m='.$mobile_in['mobile'].'&c=【名花有主】您已成功预约请登录查看。账号：'.$order_in['username'].' 时间：'.date('Y-m-d h:i:s',$time));
      
        $this->success('匹配成功');
    }
  
    /*
 * @ 手动批量匹配
 */
    public function batch_matching(){
       // file_put_contents(dirname(__FILE__).'/tian7.txt',date("Y-m-d H:i:s", time()).'sql==>>batch_matching:ok'."\r\n", FILE_APPEND);
        // 自定义变量
        $num = 0;
        $num_success = 0;
        $num_error = 0;

        // 接收需要匹配的项
        $inCode = input('arr_buy');
        $outCode = input('arr_sell');

        $inWhere[] = ['clt_match.order_id','in',$inCode];
        $inWhere[] = ['clt_match.is_pay','=',0];
        $inWhere[] = ['clt_match.order_type','=',0];
        $inWhere[] = ['clt_match.match_status','=',0];

        $outWhere[] = ['clt_match.order_id','in',$outCode];
        $outWhere[] = ['clt_match.is_pay','=',0];
        $outWhere[] = ['clt_match.order_type','=',1];
        $outWhere[] = ['clt_match.match_status','=',0];

        $order_in = MatchModel::where($inWhere)->leftJoin('clt_users','clt_match.uid = clt_users.id')->field('clt_match.id,clt_match.cid,clt_match.c_name,clt_match.uid,clt_match.username,clt_match.order_id,clt_match.money,clt_users.mobile')->select();
        $order_out = MatchModel::where($outWhere)->leftJoin('clt_users','clt_match.uid = clt_users.id')->field('clt_match.id,clt_match.cid,clt_match.c_name,clt_match.uid,clt_match.username,clt_match.order_id,clt_match.money,clt_users.mobile')->select();


//        return $this->success('','',[
//           'order_ins' => $order_in,
//            'order_outs' => $order_out,
//
//        ]);
//
//
//        exit();

        foreach($order_out as $key => $val){
            foreach($order_in as $k => $v){
               // file_put_contents(dirname(__FILE__).'/tian7.txt',date("Y-m-d H:i:s", time()).'sql==>>v:'.print_r($v,1)."\r\n", FILE_APPEND);
                $num = $num+1;
                if($val['uid'] != $v['uid'] && $val['cid'] == $v['cid']){
                    $num_success = $num_success+1;

                    // 获取默认银行卡的手机号
                    $mobile_in = DB::name('bankreceivables')->where(['uid'=>$v['uid'],'moren'=>1])->field('mobile')->find();
                  
                    if(empty($mobile_in)){
                        $mobile_in['mobile'] = $order_in['mobile'];
                    }
                  
                    $mobile_out = DB::name('bankreceivables')->where(['uid'=>$val['uid'],'moren'=>1])->field('mobile')->find();
                    if(empty($mobile_out)){
                        $mobile_out['mobile'] = $order_out['mobile'];
                    }

                    $time = time();
                    //开始时间|结束时间|超时开始时间，在设定时间段内匹配将按照当前匹配时间计算超时，在非设定时间段内匹配则按照当天8点开始计算，超过则按明天8点，在匹配时间段内不可执行打款操作
                    $match_time = explode('|',db::name('system_config')->where('name','match_time')->value('value'));
                    $today = strtotime(date('Y-m-d'));
                    if ( ($time > $today+$match_time[0]*3600) && ($time < $today+$match_time[1]*3600)){
                        $appointment = 0;   //实时匹配
                    }else{
                        $appointment = 1;   //预匹配进行中
                        if ($time < $today+$match_time[0]*3600)$time = $today + $match_time[2] * 3600;
                        if ($time > $today+$match_time[1]*3600)$time = $today + $match_time[2] * 3600 + 86400;
                    }

                    Db::startTrans();
                    try{
                        Db::name('match')->update([
                            'id'=>$v['id'],
                            'match_status'=>2,
                            'match_time'=>$time,
                            'money'=>Db::raw('money+'.$val['money']),
                            'appointment'=>$appointment
                        ]);

                        Db::name('match')->update([
                            'id'=>$val['id'],
                            'match_status'=>2,
                            'match_time'=>$time,
                            'unmatched'=>Db::raw('unmatched-'.$val['money']),
                            'appointment'=>$appointment
                        ]);

                        $matchOrderId = 'M'.date('YmdHis').rand(1,9).rand(10,99).rand(100,999);

                        $data					= array();
                        $data['order_id']	    = $matchOrderId;
                        $data['in_order_id']	= $v['order_id'];
                        $data['out_order_id']	= $val['order_id'];
                        $data['uid']			= $v['uid'];
                        $data['username']		= $v['username'];
                        $data['bid']			= $val['uid'];
                        $data['busername']		= $val['username'];
                        $data['create_time']	= $time;  //创建时间（匹配时间）
                        $data['money']			= $val['money'];
                        $data['appointment']	= $appointment;
                        $data['cid']            = $v['cid'];
                        $data['c_name']         = $v['c_name'];

                        Db::name('match2')->insert($data);

                        // 提交事务
                        Db::commit();
                    } catch (\Exception $e) {
                        // 回滚事务
                        Db::rollback();
                        $this->error("错误：".$e->getMessage());
                    }
                    //实时匹配发送短信
                    if ($appointment==0){
                        // 买入
                        //$data_in = $this->_curlPost(array(),config('API_HOST').'/sms?u='.config('sms_username').'&p='.config('sms_password').'&m='.$mobile_in['mobile'].'&c=【花粉兄弟】您的订单已经预约成功请登录查看。账号：'.$v['username'].' 时间：'.date('Y-m-d h:i:s',$time));
                        // 卖出
                        //$data_out = $this->_curlPost(array(),config('API_HOST').'/sms?u='.config('sms_username').'&p='.config('sms_password').'&m='.$mobile_out['mobile'].'&c=【花粉兄弟】您的订单已经成功请登录查看。账号：'.$val['username'].' 时间：'.date('Y-m-d h:i:s',$time));
                    }else{
                        db::name('sms_queue')->insert([
                            'mobile' => $v['username'],
                            'create_time' => time(),
                            'template' => 116760,
                            'smsType'       => '聚合短信',
                            'send_time' => $time
                        ]);
                    }
                  
                                      	// 买入短信提醒
                   // $data_in = $this->_curlPost(array(),config('API_HOST').'/sms?u='.config('sms_username').'&p='.config('sms_password').'&m='.$mobile_in['mobile'].'&c=【名花有主】您已成功预约请登录查看。账号：'.$v['username'].' 时间：'.date('Y-m-d h:i:s',$time));
                  //  file_put_contents(dirname(__FILE__).'/tian1.txt',date("Y-m-d H:i:s", time()).'==>>短信提醒:'.print_r($data_in,1)."\r\n", FILE_APPEND);
                    //$content = '【名花有主】您已成功预约请登录查看。账号：'.$v['username'].' 时间：'.date('Y-m-d h:i:s',$time);
                   // file_put_contents(dirname(__FILE__).'/tian7.txt',date("Y-m-d H:i:s", time()).'sql==>>username:'.$v['username']."\r\n", FILE_APPEND);
                    $content = ' 【名花有主】恭喜您匹配成功请登录APP查看。账号：'.$v['username'].' 时间：'.date('Y-m-d h:i:s',$time);  
                    file_put_contents(dirname(__FILE__).'/tian7.txt',date("Y-m-d H:i:s", time()).'sql==>>content:'.$content."\r\n", FILE_APPEND);
                    $sendurl = config('API_HOST').'/'."sms?u=".config('sms_username')."&p=".config('sms_password')."&m=".$mobile_in['mobile']."&c=".urlencode($content);               
                    file_put_contents(dirname(__FILE__).'/tian7.txt',date("Y-m-d H:i:s", time()).'sql==>>sendurl:'.print_r($sendurl,1)."\r\n", FILE_APPEND);
                    $result =file_get_contents($sendurl) ;
                    file_put_contents(dirname(__FILE__).'/tian7.txt',date("Y-m-d H:i:s", time()).'sql==>>result:'.print_r($result,1)."\r\n", FILE_APPEND);
                    // 匹配成功后 删除内循环中的当前匹配项，然后跳过最外层循环
                    unset($order_in[$k]);
                    break ;
                }else{
                    $num_error = $num_error+1;
                }
            }
        }

        $data = array();
        $data['num'] = $num;
        $data['num_success'] = $num_success;
        $data['num_error'] = $num_error;

        $this->success('匹配成功','',$data);
    }

    public function Automatic_Matching(){
        $outWhere[] = ['is_pay','=',0];
        $outWhere[] = ['order_type','=',1];
        $outWhere[] = ['match_status','<',2];
        $order_out = MatchModel::where($outWhere)->field('id,order_id,uid,username,match_status,money,cid,c_name')->limit(20)->select();
        foreach ($order_out  as $key => $va) {

            while ($va['match_status']<2) {

                    $inWhere[] = ['is_pay','=',0];
                    $inWhere[] = ['order_type','=',0];
                    $inWhere[] = ['match_status','<',2];
                    $inWhere[] = ['uid','<>',$va['uid']];
                    $order_in = MatchModel::where($inWhere)->find();
                     if (!$order_in) {
                         break;
                     }
                     if ($order_in['cid']!==$va['cid']){
                        break; 
                     }
                     $appointment = 0;
                     $time=time();
                     if ($order_in['cid']==$va['cid']){
                        Db::name('match')->update([
                            'id'=>$order_in['id'],
                            'match_status'=>2,
                            'match_time'=>$time,
                            'money'=>Db::raw('money+'.$va['money']),
                            'appointment'=>$appointment
                        ]);
                        Db::name('match')->update([
                            'id'=>$va['id'],
                            'match_status'=>2,
                            'match_time'=>$time,
                            'unmatched'=>Db::raw('unmatched-'.$va['money']),
                            'appointment'=>$appointment
                        ]);
                    }
                    $matchOrderId = 'M'.date('YmdHis').rand(1,9).rand(1,9).rand(1,9);
                    $data                   = array();
                    $data['order_id']       = $matchOrderId;
                    $data['in_order_id']    = $order_in['order_id'];
                    $data['out_order_id']   = $va['order_id'];
                    $data['uid']            = $order_in['uid'];
                    $data['username']       = $order_in['username'];
                    $data['bid']            = $va['uid'];
                    $data['busername']      = $va['username'];
                    $data['create_time']    = $time;  //创建时间（匹配时间）
                    $data['money']          = $va['money'];
                    $data['appointment']    = $appointment;
                    $data['cid']            = $order_in['cid'];
                    $data['c_name']         = $order_in['c_name'];
                    $rs2=Db::name('match2')->insert($data);

                    unset($data);

            }
           
        }
        echo '本次匹配成功，20条以内';

    }
    public function trading_center(){
        $time = input('set_time');
        $set_time = explode('~',$time);
        $startDate =  strtotime($set_time['0']);
        $endDate   =  strtotime($set_time['1']);
        $username = input('username');
        $pay_status = input('pay_status');

        $where[] = ['id','>',0];
        if ($time){
            $where[] = ['create_time','between',[$startDate,$endDate]];
            $this->assign('set_time',$time);
        }
        if ($username){
            $where[] = ['username|busername|order_id|in_order_id|out_order_id','=',$username];
            $this->assign('username',$username);
        }
        if ($pay_status != null){
            $where[] = ['pay_status','=',$pay_status];
            $this->assign('pay_status',$pay_status);
        }
        $list = MatchModel2::where($where)->order('id desc')->paginate(100);
        foreach ($list as $key=>$value){
            $list[$key]['image'] = 'http://'.$_SERVER['HTTP_HOST'].'/'.$value['image'];
        }
        $this->assign('list',$list);
        return $this->fetch();
    }
    /**
     * 已匹配订单信息
     */
    public function match_info(){
        $oid = input('oid');
        $info = db::name('match2')->find($oid);
        return $info;
    }
    /**
     * 撤销匹配操作
     */
    public function undo_matching_save(){
        $oid = input('oid');
        $info = MatchModel2::get($oid);
        if ( !$info) return array('status'=>false,'info'=>'返回订单信息为空！');
        switch ( $info['pay_status'] ){
            case 0:
                Db::startTrans();
                try{
                    $data = [];
                    $data['uid'] = $info['uid'];
                    $data['username'] = $info['username'];
                    $data['bid'] = $info['bid'];
                    $data['busername'] = $info['busername'];
                    $data['create_time'] = time();
                    $data['money'] = $info['money'];
                    $data['remark'] = '排单订单未打款，后台撤销匹配';
                    db::name('xfhistory')->insert($data);

                    //进场单子
                    MatchModel::where('order_id',$info['in_order_id'])->update([
                        'unmatched' => db::raw('unmatched+'.$info['money']),
                    ]);
                    $newData = MatchModel::where('order_id',$info['in_order_id'])
                        ->field('money,unmatched')
                        ->find();
                    if ($newData['money'] == $newData['unmatched'] && $newData['unmatched']>0){
                        MatchModel::where('order_id',$info['in_order_id'])->update([
                            'match_status' => 0,
                        ]);
                    }
                    if ($newData['money'] > $newData['unmatched'] && $newData['unmatched']>0){
                        MatchModel::where('order_id',$info['in_order_id'])->update([
                            'match_status' => 1,
                        ]);
                    }

                    //出场的单子
                    MatchModel::where('order_id',$info['out_order_id'])->update([
                        'unmatched' => db::raw('unmatched+'.$info['money']),
                    ]);
                    $currencyData = MatchModel::where('order_id',$info['out_order_id'])
                        ->field('money,unmatched')
                        ->find();
                    if ($currencyData['money'] == $currencyData['unmatched'] && $currencyData['unmatched']>0){
                        MatchModel::where('order_id',$info['out_order_id'])->update([
                            'match_status' => 0,
                        ]);
                    }
                    if ($currencyData['money'] > $currencyData['unmatched'] && $currencyData['unmatched']>0){
                        MatchModel::where('order_id',$info['out_order_id'])->update([
                            'match_status' => 1,
                        ]);
                    }
                    MatchModel2::destroy($oid);
                    Db::commit();
                } catch (\Exception $e) {
                    // 回滚事务
                    Db::rollback();
                    return errorAjax($e->getMessage(),['data'=>[]]);
                }
                return array('status'=>true,'info'=>'已撤销匹配');
                break;
            case 1:
                return array('status'=>false,'info'=>'排单方已打款！请执行仲裁操作');
                break;
            case 2:
                return array('status'=>false,'info'=>'提现方已确认收款！交易已完成，无需操作');
                break;
            default :return array('status'=>false,'info'=>'数据错误！');
        }
    }
    public function delquxiao(){
        $oid = input('oid');
     
                $newData = MatchModel::where('id',$oid)->find();
                if ($newData['match_status']>0) {
                    $this->error('该订单不能取消');
                }
                $cucur = CucurbitaModel::where('status',1)->where('id',$newData['cid'])->find();                
                if($newData['is_vip']==1){
                    $cucur['needgourd'] = $cucur['vipneedgourd'];
                }
                
                $tet=UsersModel::where('id',$newData['uid'])->setInc('aibi',$cucur['needgourd']);
                if ($tet>0) {
                     Db::name('history')->insert([
                        'uid' => $newData['uid'],
                        'username' => $newData['username'],
                        'money' => $cucur['needgourd'],
                        'type' => 'yuyue',
                        'remark' => "预约失败退回",
                        'createtime' => time(),
                        'option' => 'expend',
                        'cid' => $newData['cid'],
                         'c_name' => $newData['c_name'],
                    ]); 
                  MatchModel::where('id',$oid)->delete(); 
                   $this->success('取消成功');
                }
           
    }

    /**
     * 一键取消预约
     */
    public function yjQX()
    {
        $cid = request()->get('cid');
        if($cid)
        {
            # 查询出所有的cid花
            $result = MatchModel::where('cid',$cid)->where('match_status',0)->where('order_type',0)->field('id')->select();           
            if($result)
            {
                foreach ($result as $item)
                {
                    $oid = $item['id'];
                    $newData = MatchModel::where('id',$oid)->find();
                   // $cucur = CucurbitaModel::where('status',1)->where('id',$newData['cid'])->find();                    
                  	$cucur = CucurbitaModel::where('id',$newData['cid'])->find();
                  	if($newData['is_vip']==1){
                  	    $cucur['needgourd'] = $cucur['vipneedgourd'];
                  	}                  	
                    $tet=UsersModel::where('id',$newData['uid'])->setInc('aibi',$cucur['needgourd']);                   
                    if ($tet>0) {
                        Db::name('history')->insert([
                            'uid' => $newData['uid'],
                            'username' => $newData['username'],
                            'money' => $cucur['needgourd'],
                            'type' => 'yuyue',
                            'remark' => "预约失败退回",
                            'createtime' => time(),
                            'option' => 'expend',
                            'cid' => $newData['cid'],
                            'c_name' => $newData['c_name'],
                        ]);
                        MatchModel::where('id',$oid)->delete();
                    }
                }
            }
        }

        return successAjax('',['cid' => $cid]);
    }

    /**
     * 仲裁操作
     */
    public function admin_arbitration(){
        $oid = input('oid');
        $order_info = MatchModel2::get($oid);
        if ( !$order_info) return array('status'=>false,'info'=>'返回订单信息为空！');
        $arbitration_type = input('arbitration_type');  //仲裁选择类型    1=》进场方胜诉，2=》出场方胜诉
        switch ( $order_info['pay_status'] ){
            case 0:
                return array('status'=>false,'info'=>'订单未打款，可直接执行撤销匹配操作！');
                break;
            case 1:
                switch ($arbitration_type) {
                    case 1:
                        $param = [
                            'id' => $order_info['id'],
                            'in_order_id' => $order_info['in_order_id'],
                            'out_order_id' => $order_info['out_order_id'],
                        ];
                        $res = Hook::listen('FinishMatchTrader', $param);
                        if ($res[0]['status'] == true) {
                            $data = [];
                            $data['uid'] = $order_info['uid'];
                            $data['username'] = $order_info['username'];
                            $data['bid'] = $order_info['bid'];
                            $data['busername'] = $order_info['busername'];
                            $data['create_time'] = time();
                            $data['money'] = $order_info['money'];
                            $data['remark'] = '仲裁：排单方打款成功！金额支付至打款方账户';
                            db::name('xfhistory')->insert($data);
                            return array('status' => true, 'info' => '仲裁：排单方打款成功！金额支付至打款方账户');
                        } else {
                            return array('status' => false, 'info' => $res[0]['info']);
                        }
                        break;
                    case 2:
                        Db::startTrans();
                        try{
                            $data = [];
                            $data['uid'] = $order_info['uid'];
                            $data['username'] = $order_info['username'];
                            $data['bid'] = $order_info['bid'];
                            $data['busername'] = $order_info['busername'];
                            $data['create_time'] = time();
                            $data['money'] = $order_info['money'];
                            $data['remark'] = '仲裁：排单方打款未成功！撤销匹配';
                            db::name('xfhistory')->insert($data);

                            //进场单子
                            MatchModel::where('order_id',$order_info['in_order_id'])->update([
                                'unmatched' => db::raw('unmatched+'.$order_info['money']),
                                'is_out'    => 1
                            ]);
                            $newData = MatchModel::where('order_id',$order_info['in_order_id'])
                                ->field('money,unmatched')
                                ->find();
                            if ($newData['money'] == $newData['unmatched'] && $newData['unmatched']>0){
                                MatchModel::where('order_id',$order_info['in_order_id'])->update([
                                    'match_status' => 0,
                                ]);
                            }
                            if ($newData['money'] > $newData['unmatched'] && $newData['unmatched']>0){
                                MatchModel::where('order_id',$order_info['in_order_id'])->update([
                                    'match_status' => 1,
                                ]);
                            }

                            //出场的单子
                            MatchModel::where('order_id',$order_info['out_order_id'])->update([
                                'unmatched' => db::raw('unmatched+'.$order_info['money']),
                            ]);
                            $currencyData = MatchModel::where('order_id',$order_info['out_order_id'])
                                ->field('money,unmatched')
                                ->find();
                            if ($currencyData['money'] == $currencyData['unmatched'] && $currencyData['unmatched']>0){
                                MatchModel::where('order_id',$order_info['out_order_id'])->update([
                                    'match_status' => 0,
                                ]);
                            }
                            if ($currencyData['money'] > $currencyData['unmatched'] && $currencyData['unmatched']>0){
                                MatchModel::where('order_id',$order_info['out_order_id'])->update([
                                    'match_status' => 1,
                                ]);
                            }
                            MatchModel2::destroy($oid);
                            Db::commit();
                        } catch (\Exception $e) {
                            // 回滚事务
                            Db::rollback();
                            return errorAjax($e->getMessage(),['data'=>[]]);
                        }
                        return array('status'=>true,'info'=>'仲裁：排单方打款未成功！撤销匹配');
                        break;
                    default:
                        return array('status'=>false,'info'=>'暂不支持该类型！');
                }
                break;
            case 2:
                return array('status'=>false,'info'=>'提现方已确认收款！交易已完成，无需操作');
                break;
            default:
                return array('status'=>false,'info'=>'暂不支持该类型！');
        }
    }

    /*
     * @
     * @ 新批量匹配  2019-07-10
     */
    public function new_automatic_matching(){

        $num = 0;
        $num_success = 0;
        $num_error = 0;

        $inWhere[] = ['is_pay','=',0];
        $inWhere[] = ['order_type','=',0];
        $inWhere[] = ['match_status','<',2];

        $outWhere[] = ['is_pay','=',0];
        $outWhere[] = ['order_type','=',1];
        $outWhere[] = ['match_status','<',2];

        $order_in = MatchModel::where($inWhere)->select();

        $order_out = MatchModel::where($outWhere)->select();

        foreach($order_out as $key => $val){
            foreach($order_in as $k => $v){
                $num = $num+1;
                if($val['uid'] != $v['uid'] && $val['cid'] == $v['cid']){
                    $num_success = $num_success+1;

                    $time = time();
                    //开始时间|结束时间|超时开始时间，在设定时间段内匹配将按照当前匹配时间计算超时，在非设定时间段内匹配则按照当天8点开始计算，超过则按明天8点，在匹配时间段内不可执行打款操作
                    $match_time = explode('|',db::name('system_config')->where('name','match_time')->value('value'));
                    $today = strtotime(date('Y-m-d'));
                    if ( ($time > $today+$match_time[0]*3600) && ($time < $today+$match_time[1]*3600)){
                        $appointment = 0;   //实时匹配
                    }else{
                        $appointment = 1;   //预匹配进行中
                        if ($time < $today+$match_time[0]*3600)$time = $today + $match_time[2] * 3600;
                        if ($time > $today+$match_time[1]*3600)$time = $today + $match_time[2] * 3600 + 86400;
                    }

                    Db::startTrans();
                    try{
                        Db::name('match')->update([
                            'id'=>$v['id'],
                            'match_status'=>2,
                            'match_time'=>$time,
                            'money'=>Db::raw('money+'.$val['money']),
                            'appointment'=>$appointment
                        ]);

                        Db::name('match')->update([
                            'id'=>$val['id'],
                            'match_status'=>2,
                            'match_time'=>$time,
                            'unmatched'=>Db::raw('unmatched-'.$val['money']),
                            'appointment'=>$appointment
                        ]);

                        $matchOrderId = 'M'.date('YmdHis').rand(1,9).rand(1,9).rand(1,9);

                        $data					= array();
                        $data['order_id']	    = $matchOrderId;
                        $data['in_order_id']	= $v['order_id'];
                        $data['out_order_id']	= $val['order_id'];
                        $data['uid']			= $v['uid'];
                        $data['username']		= $v['username'];
                        $data['bid']			= $val['uid'];
                        $data['busername']		= $val['username'];
                        $data['create_time']	= $time;  //创建时间（匹配时间）
                        $data['money']			= $val['money'];
                        $data['appointment']	= $appointment;
                        $data['cid']            = $v['cid'];
                        $data['c_name']         = $v['c_name'];
                        Db::name('match2')->insert($data);

                        // 提交事务
                        Db::commit();
                    } catch (\Exception $e) {
                        // 回滚事务
                        Db::rollback();
                        $this->error("错误：".$e->getMessage());
                    }
                    //实时匹配发送短信
                    if ($appointment==0){
                        //您发起的提供帮助现已匹配成功，请登录后台查看并及时处理
                        $param_buy = [
                            'mobile'        => $v['username'],
                            'code'          => '',
                            'templateID'    => 116760,
                            'smsType'       => '聚合短信'
                        ];
                        Hook::listen('SendSMS',$param_buy);
                    }else{
                        db::name('sms_queue')->insert([
                            'mobile' => $v['username'],
                            'create_time' => time(),
                            'template' => 116760,
                            'smsType'       => '聚合短信',
                            'send_time' => $time
                        ]);
                    }
                    // 匹配成功后 删除外循环与内循环中的当前匹配项，然后跳过最外层循环
                    unset($order_out[$key]);
                    unset($order_in[$k]);
                    continue 2;
                }else{
                    $num_error = $num_error+1;
                }
            }
        }
        $data = array();
        $data['num'] = $num;
        $data['num_success'] = $num_success;
        $data['num_error'] = $num_error;

        return $data;
    }
}