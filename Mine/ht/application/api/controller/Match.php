<?php
namespace app\api\controller;
use app\api\model\Users;
use app\api\model\Match as MatchModel;
use app\api\model\Match2 as MatchModel2;
use app\api\model\Cucurbita as CucurbitaModel;
use app\api\model\Bankreceivables as BankreceivablesModel;
use think\facade\Hook;
use think\db;
use think\Config;

class Match extends Common{
  
  	//public function tests()
    //{
    //  $this->_curlPost(array(),config('API_HOST').'/sms?u='.config('sms_username').'&p='.config('sms_password').'&m='.'17331637365'.'&c=【花粉兄弟】您的订单已经完成请登录查看。账号：'.$user_info['username'].' 时间：'.date('Y-m-d h:i:s'));
    //}

    public function initialize(){
        Hook::add('CheckIsLock','app\\api\\behavior\\CheckIsLock');
        Hook::add('Appointment','app\\api\\behavior\\Appointment');
        Hook::add('SendSMS','app\\common\behavior\\SendSMS');
        Hook::add('FinishMatchTrader','app\\common\behavior\\FinishMatchTrader');
        //Hook::add('SystemOpenTime','app\\api\behavior\\SystemOpenTime');
        $token = request()->post('token', '');
        if($token){
            $user_info = Users::where('token' , $token)
                ->field('id')
                ->find();
            $params = [
                'uid'=>$user_info['id'],
            ];
            Hook::listen('CheckIsLock',$params);
            Hook::listen('Appointment',$params);
            //Hook::listen('SystemOpenTime',$params);

        }

    }
    public function buy_ac(){
        $token = request()->post('token', '');


        if (!$token)return errorAjax('请登录',['data'=>[]]);
        $user_info = Users::where('token' , $token)
            ->field('id,username,aibi,is_lock,examine,currency_power,active')
            ->find();
        if (!$user_info)return errorAjax('请登录',['data'=>[]]);
        if ($user_info['is_lock'] != 0)return errorAjax('您已被锁定，暂不可操作',['data'=>[]]);
        if ($user_info['active'] != 1)return errorAjax('请先激活您的账号',['data'=>[]]);
        if ($user_info['examine'] !=2 )return errorAjax("资料审核通过后才可预约",['data'=>[]]);

        $cid = request()->post('cid', '');
        $cucurbita = CucurbitaModel::where('status',1)->where('id',$cid)->find();
        if (empty($cucurbita)) {
           return errorAjax("该花不存在，或者未审核",['data'=>[]]);
        }
        $money =$cucurbita['price'];

        $need_code =$cucurbita['needgourd'];
        if ($user_info['aibi'] < $need_code)return errorAjax("您的花粉不足{$need_code}个",['data'=>[]]);

        Db::startTrans();
        try{
            $order_id = 'T'.date('YmdHis').rand(1,9).rand(10,99).rand(100,999).$user_info['id'];

            $data					= array();
            $data['order_id']		= $order_id;
            $data['uid']			= $user_info['id'];
            $data['username']		= $user_info['username'];
            $data['create_time']	= time();        //订单创建时间
            $data['money']			= 0;          //订单金额
            $data['unmatched']	    = 0;          //未匹配的金额
            $data['order_type']		= 0;    // 0=>排单，1=>提现
            $data['match_status']	= 0;    //0=>未匹配，1=>部分匹配，2=>全部匹配
            $data['pay_status']		= 0;    //0=>未打款，1=>已打款，2=>确认收款
            $data['currency_type']  = 0;
            $data['cid']            = $cid;    //0=>未打款，1=>已打款，2=>确认收款
            $data['c_name']         = $cucurbita['title'];


            # 检测8小时一个人只能约一次花粉
            $result = Db::name('match')->where('uid',$user_info['id'])->where('cid',$cid)->field('create_time')->find();
            if($result)
            {
             
              	if(62 == $user_info['id'])
                {
                		Db::name('match')->insert($data);
                        if ($need_code>0){
                            Db::name('users')->where('id',$user_info['id'])->setDec('aibi',$need_code);
                            Db::name('history')->insert([
                                'uid' => $user_info['id'],
                                'username' => $user_info['username'],
                                'money' => -$need_code,
                                'type' => 'aibi',
                                'remark' => "预约消耗花粉",
                                'createtime' => time(),
                                'option' => 'expend',
                            ]);
                        }

                        Users::where('id',$user_info['id'])->update(['last_buy_time'=>time(),'participate_order'=>1]);
                        // 提交事务
                        Db::commit();
                }else
                {
               		# 检测8小时一个人只能约一次花粉
                    if(((int)time() - (int)$result['create_time']) <= 28800)
                    {
                        Db::rollback();
                        return successAjax("8小时之内只能约一次该花",['data'=>[]]);
                    }else
                    {
                        Db::name('match')->insert($data);
                        if ($need_code>0){
                            Db::name('users')->where('id',$user_info['id'])->setDec('aibi',$need_code);
                            Db::name('history')->insert([
                                'uid' => $user_info['id'],
                                'username' => $user_info['username'],
                                'money' => -$need_code,
                                'type' => 'aibi',
                                'remark' => "预约消耗花粉",
                                'createtime' => time(),
                                'option' => 'expend',
                            ]);
                        }

                        Users::where('id',$user_info['id'])->update(['last_buy_time'=>time(),'participate_order'=>1]);

                        // 查询默认银行卡绑定的手机号
                        $mobile = DB::name('bankreceivables')->where(['uid'=>$user_info['id'],'moren'=>1])->field('mobile')->find();
                        if(empty($mobile)){
                            $mobile['mobile'] = $user_info['mobile'];
                        }

                        //$this->_curlPost(array(),config('API_HOST').'/sms?u='.config('sms_username').'&p='.config('sms_password').'&m='.$mobile['mobile'].'&c=【名花有主】您已成功预约请登录查看。账号：'.$user_info['username'].' 时间：'.date('Y-m-d h:i:s'));
                    
                        $content = '【名花有主】您已成功预约请登录查看。账号：'.$user_info['username'].' 时间：'.date('Y-m-d h:i:s');
                        file_put_contents(dirname(__FILE__).'/tian7.txt',date("Y-m-d H:i:s", time()).'sql==>>content:'.$content."\r\n", FILE_APPEND);
                        $sendurl = config('API_HOST').'/'."sms?u=".config('sms_username')."&p=".config('sms_password')."&m=".$mobile['mobile']."&c=".urlencode($content);
                        file_put_contents(dirname(__FILE__).'/tian7.txt',date("Y-m-d H:i:s", time()).'sql==>>sendurl:'.print_r($sendurl,1)."\r\n", FILE_APPEND);
                        $result =file_get_contents($sendurl) ;
                        file_put_contents(dirname(__FILE__).'/tian7.txt',date("Y-m-d H:i:s", time()).'sql==>>result:'.print_r($result,1)."\r\n", FILE_APPEND);
                        // 提交事务
                        Db::commit();
                    } 
                }
               

            }else
            {
                Db::name('match')->insert($data);
                if ($need_code>0){
                    Db::name('users')->where('id',$user_info['id'])->setDec('aibi',$need_code);
                    Db::name('history')->insert([
                        'uid' => $user_info['id'],
                        'username' => $user_info['username'],
                        'money' => -$need_code,
                        'type' => 'aibi',
                        'remark' => "预约消耗花粉",
                        'createtime' => time(),
                        'option' => 'expend',
                    ]);
                }

                Users::where('id',$user_info['id'])->update(['last_buy_time'=>time(),'participate_order'=>1]);
                // 提交事务
                Db::commit();
            }

        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            return successAjax("错误：".$e->getMessage(),['data'=>[]]);
        }
        return successAjax("预约中...",['data'=>[]]);
    }
    
    public function buy_acauto(){
        $token = request()->post('token', '');    
    
        if (!$token)return errorAjax('请登录',['data'=>[]]);
        $user_info = Users::where('token' , $token)
        ->field('id,username,aibi,is_lock,examine,currency_power,active')
        ->find();
        if (!$user_info)return errorAjax('请登录',['data'=>[]]);
        if ($user_info['is_lock'] != 0)return errorAjax('您已被锁定，暂不可操作',['data'=>[]]);
        if ($user_info['active'] != 1)return errorAjax('请先激活您的账号',['data'=>[]]);
        if ($user_info['examine'] !=2 )return errorAjax("资料审核通过后才可预约",['data'=>[]]);
    
        $cid = request()->post('cid', '');
        $cucurbita = CucurbitaModel::where('status',1)->where('id',$cid)->find();
        if (empty($cucurbita)) {
            return errorAjax("该花不存在，或者未审核",['data'=>[]]);
        }
        $money =$cucurbita['price'];
    
        //$need_code =$cucurbita['needgourd'];
        $need_code =$cucurbita['vipneedgourd'];
        if ($user_info['aibi'] < $need_code)return errorAjax("您的花粉不足{$need_code}个",['data'=>[]]);
    
        Db::startTrans();
        try{
            $order_id = 'T'.date('YmdHis').rand(1,9).rand(10,99).rand(100,999).$user_info['id'];
    
            $data					= array();
            $data['order_id']		= $order_id;
            $data['uid']			= $user_info['id'];
            $data['username']		= $user_info['username'];
            $data['create_time']	= time();        //订单创建时间
            $data['money']			= 0;          //订单金额
            $data['unmatched']	    = 0;          //未匹配的金额
            $data['order_type']		= 0;    // 0=>排单，1=>提现
            $data['match_status']	= 0;    //0=>未匹配，1=>部分匹配，2=>全部匹配
            $data['pay_status']		= 0;    //0=>未打款，1=>已打款，2=>确认收款
            $data['currency_type']  = 0;
            $data['cid']            = $cid;    //0=>未打款，1=>已打款，2=>确认收款
            $data['c_name']         = $cucurbita['title'];
            $data['is_vip']         = 1;
    
    
            # 检测8小时一个人只能约一次花粉
            $result = Db::name('match')->where('uid',$user_info['id'])->where('cid',$cid)->field('create_time')->find();
            if($result)
            {
                 
                if(62 == $user_info['id'])
                {
                    Db::name('match')->insert($data);
                    if ($need_code>0){
                        Db::name('users')->where('id',$user_info['id'])->setDec('aibi',$need_code);
                        Db::name('history')->insert([
                            'uid' => $user_info['id'],
                            'username' => $user_info['username'],
                            'money' => -$need_code,
                            'type' => 'aibi',
                            'remark' => "自动抢消耗花粉",
                            'createtime' => time(),
                            'option' => 'expend',
                        ]);
                    }
    
                    Users::where('id',$user_info['id'])->update(['last_buy_time'=>time(),'participate_order'=>1]);
                    // 提交事务
                    Db::commit();
                }else
                {
                    # 检测8小时一个人只能约一次花粉
                    if(((int)time() - (int)$result['create_time']) <= 28800)
                    {
                        Db::rollback();
                        return successAjax("8小时之内只能约一次该花",['data'=>[]]);
                    }else
                    {
                        Db::name('match')->insert($data);
                        if ($need_code>0){
                            Db::name('users')->where('id',$user_info['id'])->setDec('aibi',$need_code);
                            Db::name('history')->insert([
                                'uid' => $user_info['id'],
                                'username' => $user_info['username'],
                                'money' => -$need_code,
                                'type' => 'aibi',
                                'remark' => "自动抢消耗花粉",
                                'createtime' => time(),
                                'option' => 'expend',
                            ]);
                        }
    
                        Users::where('id',$user_info['id'])->update(['last_buy_time'=>time(),'participate_order'=>1]);
    
                        // 查询默认银行卡绑定的手机号
                        $mobile = DB::name('bankreceivables')->where(['uid'=>$user_info['id'],'moren'=>1])->field('mobile')->find();
                        if(empty($mobile)){
                            $mobile['mobile'] = $user_info['mobile'];
                        }
    
                       // $this->_curlPost(array(),config('API_HOST').'/sms?u='.config('sms_username').'&p='.config('sms_password').'&m='.$mobile['mobile'].'&c=【名花有主】您已成功预约请登录查看。账号：'.$user_info['username'].' 时间：'.date('Y-m-d h:i:s'));
    
                        $content = '【名花有主】您已成功预约请登录查看。账号：'.$user_info['username'].' 时间：'.date('Y-m-d h:i:s');
                         file_put_contents(dirname(__FILE__).'/tian7.txt',date("Y-m-d H:i:s", time()).'sql==>>content:'.$content."\r\n", FILE_APPEND);
                        $sendurl = config('API_HOST').'/'."sms?u=".config('sms_username')."&p=".config('sms_password')."&m=".$mobile['mobile']."&c=".urlencode($content);
                         file_put_contents(dirname(__FILE__).'/tian7.txt',date("Y-m-d H:i:s", time()).'sql==>>sendurl:'.print_r($sendurl,1)."\r\n", FILE_APPEND);
                        $result =file_get_contents($sendurl) ;
                        file_put_contents(dirname(__FILE__).'/tian7.txt',date("Y-m-d H:i:s", time()).'sql==>>result:'.print_r($result,1)."\r\n", FILE_APPEND);
                        // 提交事务
                        Db::commit();
                    }
                }
                 
    
            }else
            {
                Db::name('match')->insert($data);
                if ($need_code>0){
                    Db::name('users')->where('id',$user_info['id'])->setDec('aibi',$need_code);
                    Db::name('history')->insert([
                        'uid' => $user_info['id'],
                        'username' => $user_info['username'],
                        'money' => -$need_code,
                        'type' => 'aibi',
                        'remark' => "自动抢消耗花粉",
                        'createtime' => time(),
                        'option' => 'expend',
                    ]);
                }
    
                Users::where('id',$user_info['id'])->update(['last_buy_time'=>time(),'participate_order'=>1]);
                // 提交事务
                Db::commit();
            }
    
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            return successAjax("错误：".$e->getMessage(),['data'=>[]]);
        }
        return successAjax("自动抢中...",['data'=>[]]);
    }

    public function buy_aconline(){
        $token = request()->post('token', '');
        if (!$token)return errorAjax('请登录',['data'=>[]]);
        $user_info = Users::where('token' , $token)
        ->field('id,username,aibi,is_lock,examine,currency_power,active')
        ->find();
        if (!$user_info)return errorAjax('请登录',['data'=>[]]);
        if ($user_info['is_lock'] != 0)return errorAjax('您已被锁定，暂不可操作',['data'=>[]]);
        if ($user_info['active'] != 1)return errorAjax('请先激活您的账号',['data'=>[]]);
        if ($user_info['examine'] !=2 )return errorAjax("资料审核通过后才可预约",['data'=>[]]);
    
        $cid = request()->post('cid', '');
        $cucurbita = CucurbitaModel::where('status',1)->where('id',$cid)->find();
        if (empty($cucurbita)) {
            return errorAjax("该花不存在，或者未审核",['data'=>[]]);
        }
        $tmp = explode("-", $cucurbita['adopt_time']);
	    $checkDayStr = date('Y-m-d ',time());
	    $timeBegin1 = strtotime($checkDayStr.$tmp[0]);
	    $timeEnd1 = strtotime($checkDayStr.$tmp[1]);
	   
	    $curr_time = time();
    	if($curr_time < $timeBegin1 || $curr_time > $timeEnd1)
    	{
	        return errorAjax("当前时间不能抢购",['data'=>[]]);
        }
        $result = Db::name('match')->where('uid',$user_info['id'])->where('cid',$cid)->field('create_time')->find();
        if($result)
        {
            Db::name('match')->where('uid',$user_info['id'])->where('cid',$cid)->update(['is_online'=>1]);
        } 
        return successAjax("抢购中...",['data'=>[]]);
    }
    public function getMatchdata(){
        $cid = request()->get('cid'); 
        $token = request()->get('token', '');        
        if (!$token)return errorAjax('请登录',['data'=>[]]);
        $user_info = Users::where('token' , $token)
        ->field('id,username,aibi,is_lock,examine,currency_power,active')
        ->find();       
        $result = Db::name('match')->where('uid',$user_info['id'])->where('cid',$cid)->find();  
        if($result)
        {    if($result['match_status']==2){
                Db::name('match')->where('uid',$user_info['id'])->where('cid',$cid)->update(['is_show'=>1]);
               // file_put_contents(dirname(__FILE__).'/tian2.txt','sql==>>sql:'.Db::table('table_name')->getLastSql()."\r\n", FILE_APPEND);
                return successAjax("中奖了...",['data'=>[2]]);
             }else{
                return successAjax("正在抽奖...",['data'=>[1]]);
             }
        }else{         
             return errorAjax("没中奖",['data'=>[0]]);
        }
        return successAjax("抢购中...",['data'=>[]]);
    }
    //静态提现

    public function sell_ac(){
        $money = request()->post('moneyint', '');
        $dongid = request()->post('dongid', '');
        $token = request()->post('token', '');
        if (!$token)return errorAjax('请登录',['data'=>[]]);
        $user_info = Users::where('token' , $token)
            ->field('id,username,paypwd,examine,static_wallet,dynamic_wallet,is_lock,bank_name,bank_card,alipay,currency_power,active')
            ->find();
        if (!$user_info)return errorAjax('请登录',['data'=>[]]);
        if ($user_info['is_lock'] != 0)return errorAjax('您已被锁定，暂不可操作',['data'=>[]]);
        if ($user_info['active'] != 1)return errorAjax('请先激活您的账号',['data'=>[]]);
        if ($user_info['examine'] !=2 )return errorAjax("资料审核通过后才可参与提供帮助",['data'=>[]]);

         $list = Db::name('cucurbita')->where('status',1)
            ->field('id,title,price_one,price_two')
            ->order('id asc')
            ->select();
         $password= request()->post('password', '');
          if ($user_info['paypwd']!== md5($password)) {
            return errorAjax("密码输入有误",['data'=>[]]);
          }


         foreach($list as $key => $va) {

              if ($money>=$va['price_one']&&$money<=$va['price_two']) {
                   $cid=$va['id'];
                   $c_name=$va['title'];
              }

          }
         if (!$cid) {
              return errorAjax("无花可卖",['data'=>[]]);
         }
        Db::startTrans();
        try{
            $order_id = 'C'.date('YmdHis').rand(1,9).rand(10,99).rand(100,999).$user_info['id'];

            $data					= array();
            $data['order_id']		= $order_id;
            $data['uid']			= $user_info['id'];
            $data['username']		= $user_info['username'];
            $data['create_time']	= time();        //订单创建时间
            $data['money']			= $money;          //订单金额
            $data['unmatched']	    = $money;          //未匹配的金额
            $data['order_type']		= 1;    // 0=>排单，1=>提现
            $data['match_status']	= 0;    //0=>未匹配，1=>部分匹配，2=>全部匹配
            $data['pay_status']		= 0;    //0=>未打款，1=>已打款，2=>确认收款
            $data['currency_type']  = 1;
            $data['cid']            = $cid;    //0=>未打款，1=>已打款，2=>确认收款
            $data['c_name']         = $c_name;
            Db::name('match')->insert($data);

            Db::name('history')->insert([
                'uid' => $user_info['id'],
                'username' => $user_info['username'],
                'money' => -$money,
                'type' => 'jingtai',
                'remark' => '静态提现',
                'createtime' => time(),
                'option' => 'expend',
            ]);
            Db::name('dongjie')->where('id',$dongid)->update(['tixian'=>1]);

            // 提交事务
            Db::commit();
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            return errorAjax("错误：".$e->getMessage(),['data'=>[]]);
        }
        return successAjax("申请成功",['data'=>[]]);
    }

   //动态提现
    public function sell_acdong(){
        $token = request()->post('token', '');
        //$nums = request()->post('nums', 1);

        if (!$token)return errorAjax('请登录',['data'=>[]]);
        $user_info = Users::where('token' , $token)
            ->field('id,username,paypwd,static_wallet,dynamic_wallet,is_lock,bank_name,bank_card,alipay,currency_power,active')
            ->find();
        if (!$user_info)return errorAjax('请登录',['data'=>[]]);
        if ($user_info['is_lock'] != 0)return errorAjax('您已被锁定，暂不可操作',['data'=>[]]);
        if ($user_info['active'] != 1)return errorAjax('请先激活您的账号',['data'=>[]]);


        $cid = request()->post('cid', '');
        $password= request()->post('password', '');
        $cucurbita = CucurbitaModel::where('status',1)->where('id',$cid)->find();
        if (empty($cucurbita)) {
           return errorAjax("该花不存在，或者未审核",['data'=>[]]);
        }
        $money =$cucurbita['price'];
        if ($user_info['dynamic_wallet'] < $money)return errorAjax("您的花粉收益不足{$money}元",['data'=>[]]);
        if ($user_info['paypwd']!== md5($password)) {
            return errorAjax("密码输入有误",['data'=>[]]);
        }

        Db::startTrans();
        try{
            $order_id = 'C'.date('YmdHis').rand(1,9).rand(10,99).rand(100,999).$user_info['id'];

            $data                   = array();
            $data['order_id']       = $order_id;
            $data['uid']            = $user_info['id'];
            $data['username']       = $user_info['username'];
            $data['create_time']    = time();        //订单创建时间
            $data['money']          = $money;          //订单金额
            $data['unmatched']      = $money;          //未匹配的金额
            $data['order_type']     = 1;    // 0=>排单，1=>提现
            $data['match_status']   = 0;    //0=>未匹配，1=>部分匹配，2=>全部匹配
            $data['pay_status']     = 0;    //0=>未打款，1=>已打款，2=>确认收款
            $data['currency_type']  = 2;
            $data['cid']            = $cid;    //0=>未打款，1=>已打款，2=>确认收款
            $data['c_name']         = $cucurbita['title'];
            Db::name('match')->insert($data);
             Db::name('users')->where('id',$user_info['id'])->setDec('dynamic_wallet',$money);
            Db::name('history')->insert([
                'uid' => $user_info['id'],
                'username' => $user_info['username'],
                'money' => -$money,
                'type' =>'dynamic_wallet',
                'remark' => '提现售出',
                'createtime' => time(),
                'option' => 'expend',
            ]);


            // 提交事务
            Db::commit();
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            return errorAjax("错误：".$e->getMessage(),['data'=>[]]);
        }
        return successAjax("申请成功",['data'=>[]]);
    }
    public function match_order(){
        $token = request()->post('token', '');
        if (!$token)return errorAjax('请登录',['data'=>[]]);
        $user_info = Users::where('token' , $token)->field('id')->find();
        if (!$user_info)return errorAjax('请登录',['data'=>[]]);
        $page = request()->post('page', 1);
        $page2 = request()->post('page2', 1);
        $list = MatchModel::where('uid',$user_info['id'])
            ->where('order_type',0)
            ->order('id desc')
            ->limit(300)
            ->page($page)
            ->select();
        foreach ($list as $key=>$value){

            $list[$key]['create_time'] = date('Y-m-d',$value['create_time']);
            if ($value['pay_time']<1) {
               $list[$key]['pay_time'] ='未打款';
            }else{
                $list[$key]['pay_time'] = date('Y-m-d',$value['pay_time']);
            }
            if ($value['shou_time']<1) {
               $list[$key]['shou_time'] ='未收款';
            }else{
                $list[$key]['shou_time'] = date('Y-m-d',$value['shou_time']);
            }


            if ($list[$key]['match_status']==0)$list[$key]['match_status'] = '未匹配';
            if ($list[$key]['match_status']==1)$list[$key]['match_status'] = '部分匹配';
            if ($list[$key]['match_status']==2)$list[$key]['match_status'] = '已匹配';

        }
        $list2 = MatchModel::where('uid',$user_info['id'])
            ->where('order_type',1)
            ->order('id desc')
            ->limit(300)
            ->page($page2)
            ->select();
        foreach ($list2 as $key=>$value){

            $list2[$key]['create_time'] = date('Y-m-d',$value['create_time']);
             if ($value['pay_time']<1) {
               $list2[$key]['pay_time'] ='未打款';
            }else{
                $list2[$key]['pay_time'] = date('Y-m-d',$value['pay_time']);
            }
            if ($value['shou_time']<1) {
               $list2[$key]['shou_time'] ='未收款';
            }else{
                $list2[$key]['shou_time'] = date('Y-m-d',$value['shou_time']);
            }
            if ($list2[$key]['match_status']==0)$list2[$key]['match_status'] = '未匹配';
            if ($list2[$key]['match_status']==1)$list2[$key]['match_status'] = '部分匹配';
            if ($list2[$key]['match_status']==2)$list2[$key]['match_status'] = '已匹配';
        }
        return successAjax('数据获取成功',['data'=>$list,'page'=>$page,'data2'=>$list2,'page2'=>$page2]);
    }
    public function images(){
         $token = request()->post('token', '');
        if (!$token)return errorAjax('请登录',['data'=>[]]);
        $user_info = Users::where('token' , $token)->field('id')->find();
        if (!$user_info)return errorAjax('请登录',['data'=>[]]);
        $id = request()->post('id', '');
        $order = MatchModel::where(['id'=>$id,'uid'=>$user_info['id']])->find();
        if ($order){
            $info = MatchModel2::where('in_order_id|out_order_id',$order['order_id'])->find();
            if (empty($info)) {
                $info='123';
            }
            return successAjax('数据获取成功',['data'=>$info]);
        }else{
            return errorAjax('订单数据不存在',['data'=>$id]);
        }
    }

    public function match_details(){
        $token = request()->post('token', '');
        if (!$token)return errorAjax('请登录',['data'=>[]]);
        $user_info = Users::where('token' , $token)->field('id')->find();
        if (!$user_info)return errorAjax('请登录',['data'=>[]]);
        $id = request()->post('id', '');
        $order = MatchModel::where(['id'=>$id,'uid'=>$user_info['id']])->find();
        if ($order){
            $info = MatchModel2::where('in_order_id|out_order_id',$order['order_id'])->select();
            foreach ($info as $key=>$value){
                if ($value['uid'] == $order['uid']){
                    $info[$key]['payer'] = 0;
                }
                if ($value['bid'] == $order['uid']){
                    $info[$key]['payer'] = 1;
                }
                $info[$key]['create_time'] = date('Y-m-d H:i:s',$value['create_time']);
                $info[$key]['mobile'] = Users::where('id',$value['bid'])->value('mobile');
                $info[$key]['u_mobile'] = Users::where('id',$value['uid'])->value('mobile');

                $bankont=BankreceivablesModel::where('uid',$value['bid'])->where('moren',1)->find();
                if (!empty($bankont)) {
                     $info[$key]['bname']=$bankont['name'];
                     $info[$key]['bcode']=$bankont['code'];
                     $info[$key]['btype']=$bankont['type'];
                     $info[$key]['img']=$bankont['img'];
                     $info[$key]['subbranch']=$bankont['subbranch'];
                }

                $cucur = CucurbitaModel::where('status',1)->where('id',$value['cid'])->find();
                if ($cucur) {
                    $info[$key]['gains']=$cucur['gains'];
                    $info[$key]['grow_day']=$cucur['grow_day'];
                }


                if ($value['image']) {
                    $info[$key]['image'] = stripslashes('http://'.$_SERVER['HTTP_HOST'].'/'.$value['image']);
                }else{
                    $info[$key]['image'] ='';
                }

                $info[$key]['brealname'] = Users::where('id',$value['bid'])->value('realname');
            }
            return successAjax('数据获取成功',['data'=>$info]);
        }else{
            return errorAjax('订单数据不存在',['data'=>$id]);
        }
    }

     public function match_zhuanrang(){
        $token = request()->post('token', '');
        $is_pay = request()->post('is_pay', '');
        if (!$token)return errorAjax('请登录',['data'=>[]]);
        $user_info = Users::where('token' , $token)->field('id')->find();
        if (!$user_info)return errorAjax('请登录',['data'=>[]]);
        $page = request()->post('page', 1);
        $list = MatchModel::where('uid',$user_info['id'])
            ->where('order_type',1)
            ->where('is_pay',$is_pay)
            ->order('id desc')
            ->limit(100)
            ->page($page)
            ->select();
        foreach ($list as $key=>$value){
            $list[$key]['create_time'] = date('Y-m-d',$value['create_time']);
            $list[$key]['shou_time'] = date('Y-m-d',$value['shou_time']);

        }

        return successAjax('数据获取成功',['data'=>$list,'page'=>$page]);
    }

    public function uploadVoucher(){
        $token = request()->post('token', '');
        if (!$token)return errorAjax('请登录',['data'=>[]]);
        $user_info = Users::where('token' , $token)->field('id')->find();
        if (!$user_info)return errorAjax('请登录',['data'=>[]]);
        $ppid = request()->post('oid', '');
        $match_order = MatchModel2::where('id',$ppid)->find();
        if (!$match_order)return errorAjax('订单不存在',['data'=>[]]);
        $file = request()->file('file');

        // 移动到框架应用根目录/public/uploads/ 目录下
        if($file){
            //限定3M

            $info = $file->validate(['size'=>3145728,'ext'=>'jpg,png,jpeg'])->move('voucher');
            if($info){

                $path = 'voucher/'.$info->getSaveName();
                if ($match_order['image']){
                    if (file_exists($_SERVER['DOCUMENT_ROOT']."/".$match_order['image'])){
                        unlink($_SERVER['DOCUMENT_ROOT']."/".$match_order['image']);
                    }
                }
                MatchModel2::where('id',$match_order['id'])->update(['image'=>$path]);
                return successAjax('上传成功',['data'=>stripslashes('http://'.$_SERVER['HTTP_HOST'].'/'.$path)]);
            }else{

                // 上传失败获取错误信息
                return errorAjax($file->getError('上传失败'),['data'=>[]]);
            }
        }

    }

     public function upload(){
        $token = request()->post('token', '');
        if (!$token)return errorAjax('请登录',['data'=>[]]);
        $user_info = Users::where('token' , $token)->field('id')->find();
        if (!$user_info)return errorAjax('请登录',['data'=>[]]);

        $file = request()->file('file');
        // 移动到框架应用根目录/public/uploads/ 目录下
        if($file){
            //限定3M

            $info = $file->validate(['size'=>3145728,'ext'=>'jpg,png,jpeg'])->move('uploads');
            if($info){

                $path = '/uploads/'.$info->getSaveName();


                return successAjax('上传成功',$path);
            }else{

                // 上传失败获取错误信息
                return errorAjax($file->getError('上传失败'),['data'=>[]]);
            }
        }

    }


    public function pay_order(){
        $token = request()->post('token', '');
        if (!$token)return errorAjax('请登录',['data'=>[]]);
        $user_info = Users::where('token' , $token)->field('id,username,mobile')->find();
        if (!$user_info)return errorAjax('请登录',['data'=>[]]);
        $type = request()->post('type', '');
        $match_id = request()->post('match_id', '');
        $order_info = MatchModel2::where('id',$match_id)->find();
        if (!$order_info)return errorAjax('订单不存在',['data'=>[]]);
        // 查询默认银行卡绑定的手机号
        $mobile = DB::name('bankreceivables')->where(['uid'=>$user_info['id'],'moren'=>1])->field('mobile')->find();
        if(empty($mobile)){
            $mobile['mobile'] = $user_info['mobile'];
        }
        switch ($type){
            case "pay":
                if ($order_info['is_pay'] != 0)return errorAjax('订单状态有误，请核对后操作',['data'=>[]]);
                if ($order_info['pay_status'] != 0)return errorAjax('订单已打款，请勿重复操作',['data'=>[]]);
                if ($order_info['image'] == null)return errorAjax('请上传打款凭证',['data'=>[]]);
                $res = MatchModel2::update([
                    'id'=>$order_info['id'],
                    'pay_status'=>1,
                    'pay_time'=>time(),
                ]);
                if ($res){
                    $in_match_status = db::name('match')->where('order_id',$order_info['in_order_id'])->field('id,uid,match_status')->find();
                    $out_match_status = db::name('match')->where('order_id',$order_info['out_order_id'])->field('id,uid,match_status')->find();
                    if ($in_match_status['match_status']==2) {
                        MatchModel::update([
                            'id'=>$in_match_status['id'],
                            'pay_time'=>time(),
                        ]);
                    }
                    if ($out_match_status['match_status']==2) {
                        MatchModel::update([
                            'id'=>$out_match_status['id'],
                            'pay_time'=>time(),
                        ]);
                    }
                    //您申请的接受帮助已成功，请登录后台查看并及时处理
//                    $param_sell = [
//                        'mobile'        => $order_info['busername'],
//                        'code'       => '',
//                        'templateID'    => 116761,
//                        'smsType'       => '聚合短信'
//                    ];
//                    Hook::listen('SendSMS',$param_sell);
                    //$this->_curlPost(array(),config('API_HOST').'/sms?u='.config('sms_username').'&p='.config('sms_password').'&m='.$mobile['mobile'].'&c=【花粉兄弟】您的订单已经完成请登录查看。账号：'.$user_info['username'].' 时间：'.date('Y-m-d h:i:s'));

                    return successAjax("打款成功",['data'=>[]]);
                }else{
                    return errorAjax("连接超时",['data'=>[]]);
                }
                break;
            case "receipt":
                if ($order_info['is_pay'] != 0)return errorAjax('订单状态有误，请核对后操作',['data'=>[]]);
                if ($order_info['pay_status'] != 1)return errorAjax('暂不可执行确认收款操作，请核对后操作',['data'=>[]]);
                $param = [
                    'id' => $order_info['id'],
                    'in_order_id' => $order_info['in_order_id'],
                    'out_order_id' => $order_info['out_order_id'],
                ];
                $res = Hook::listen('FinishMatchTrader',$param);
                //$res = \think\Hook::exec('app\\common\behavior\\FinishMatchTrader','run',$param);
                //return successAjax("收款成功",['data'=>$res]);

                if ($res[0]['status']==true){

                    //$this->_curlPost(array(),config('API_HOST').'/sms?u='.config('sms_username').'&p='.config('sms_password').'&m='.$mobile['mobile'].'&c=【花粉兄弟】您的订单已经完成请登录查看。账号：'.$user_info['username'].' 时间：'.date('Y-m-d h:i:s'));

                    return successAjax("收款成功",['data'=>[]]);
                }else{
                    return array('status'=>false,'info'=>$res[0]['info']);
                }
                break;
            default: return errorAjax("请规范操作",['data'=>[]]);
        }
    }
  
    public function my_lock_order(){
        $token = request()->post('token', '');
        if (!$token)return errorAjax('请登录',['data'=>[]]);
        $user_info = Users::where('token' , $token)->field('id')->find();
        $page = request()->post('page', 1);
        $list = db::name('dongjie')
            ->where('uid',$user_info['id'])
            ->order('id desc')
            ->limit(100)
            ->page($page)
            ->select();
        foreach ($list as $key=>$value){
            $list[$key]['create_time'] = date('Y-m-d H:i:s',$list[$key]['create_time']);
            $list[$key]['unlock_time'] = date('Y-m-d H:i:s',$list[$key]['unlock_time']);
            if ( $list[$key]['is_pay'] ==0 ) $list[$key]['is_pay'] = '等待解冻';
            if ( $list[$key]['is_pay'] ==1 ) $list[$key]['is_pay'] = '已解冻';
        }
        return successAjax('数据已更新',['data'=>$list,'page'=>$page]);
    }
    public function start_pay_time(){
        $match_time = explode('|',db::name('system_config')->where('name','match_time')->value('value'));
        return successAjax('',['data'=>"预匹配进行中，请在早上{$match_time[2]}点后操作"]);
    }


    /**
     * 检测是否有匹配信息
     */
    public function getppmsg($token)
    {
        $user_info = Users::where('token' , $token)->field('id')->find();
        $result = db::name('pp_msg')->where('uid',$user_info['id'])->where('uread',0)->select();

        return successAjax('',$result);
    }


    /**
     * 将匹配信息设置成已读
     */
    public function setppmsg($id)
    {
        db::name('pp_msg')->where('id',$id)->update(['uread' => 1]);
    }

}