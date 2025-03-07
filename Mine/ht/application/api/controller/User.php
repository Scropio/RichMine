<?php
namespace app\api\controller;
use app\admin\controller\News;
use app\api\model\Users;
use app\api\model\UserLevel;
use app\api\model\MobileCode;
use think\db;
use think\facade\Hook;
use think\Validate;
use think\facade\Env;
use app\api\model\SmsQueue;
use app\api\model\Cucurbita as CucurbitaModel;
use app\api\model\Bankreceivables as BankreceivablesModel;
class User extends Common{
    public $global_var = 0;
    public function initialize(){
        Hook::add('unlockMatchOrder','app\\api\\behavior\\UnlockMatchOrder');
        Hook::add('CheckOrderOut','app\\api\\behavior\\CheckOrderOut');
        Hook::add('CheckIsLock','app\\api\\behavior\\CheckIsLock');
        Hook::add('Appointment','app\\api\\behavior\\Appointment');
        Hook::add('SendSMS','app\\common\behavior\\SendSMS');
        //Hook::add('SystemOpenTime','app\\api\behavior\\SystemOpenTime');
        Hook::add('AutoLock','app\\api\behavior\\AutoLock');
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
             Hook::listen('AutoLock',$params);
        }
    }
    public function app_update(){
        $updateUrl = 'http://'.$_SERVER['HTTP_HOST'].'/app.html';
        $appid = $_GET['appid'];
        $version = $_GET['version'];//客户端版本号
        $rsp = array('status' => 0);//默认返回值，不需要升级
        if (isset($appid) && isset($version)) {
            if($appid == "__UNI__5EE4B69"){//校验appid
//                这里是示例代码，真实业务上，最新版本号及relase notes可以存储在数据库或文件中
                if($version !== "1.0.1"){
                    $rsp['status'] = 1;
                    $rsp['title'] = "发现新版本1.0.1";
                    $rsp['note'] = "- 优化用户体验\n- 修复已知体验问题";//release notes，支持换行
                    $rsp['url'] = $updateUrl;//应用升级包下载地址
                }
            }
        }
        exit(json_encode($rsp));
    }
    //服务器自动发送短信
    public function server_auth_send_sms(){
        $cursor2 = SmsQueue::where('send_time','<=',time())->field('id,mobile,template')->cursor();
        if ($cursor2){
            foreach($cursor2 as $value){
                if ( SmsQueue::destroy($value['id'])){
                    $param = [
                        'mobile'        => $value['mobile'],
                        'code'          => '',
                        'templateID'    => $value['template'],
                        'smsType'       => '聚合短信'
                    ];
                    Hook::listen('SendSMS',$param);
                }

            }
        }
    }
    public function customer_url(){
        //客服链接
        $url = db::name('system_config')->where('name','customer_url')->value('value');
        //下载链接
        $down_app_url = 'https://'.$_SERVER['HTTP_HOST'].'/app.html';
        //下载APP二维码
        $xlx_app = stripslashes('http://'.$_SERVER['HTTP_HOST'].'/package/download.png');
        return successAjax('',['data'=>$url,'xlx_app'=>$xlx_app,'down_app_url'=>stripslashes($down_app_url)]);
    }
    public function get_user_login_status(){
        $token = request()->post('token', '');
        if (!$token)return errorAjax('请登录',['data'=>[]]);
        $user_info = Users::where('token' , $token)->field('id,is_lock')->find();
        if (!$user_info)return errorAjax('请登录',['data'=>[]]);
        if ($user_info['is_lock'] !=0){
            Users::update([
                'id'=>$user_info['id'],
                'token'=>'',
            ]);
            return errorAjax('账号已被锁定',['data'=>[]]);
        }
    }
    public function get_user_info(){

        $token = request()->post('token', '');
        if (!$token)return errorAjax('请登录',['data'=>[]]);
        $user_info = Users::where('token' , $token)
            ->field('id,username,active,aixinzhongzi,level,aibi,static_wallet,dynamic_wallet,avatar,realname,bank_name,bank_card,examine,wechat,alipay,avatar,old_money,read_news,is_lock,pgc,dynamic,staticmoney,mobile,IDcard,IDcardimg1,IDcardimg2')
            ->find();
        if (!$user_info)return errorAjax('请登录',['data'=>[]]);
        if ($user_info['is_lock'] !=0){
            Users::update([
                'id'=>$user_info['id'],
                'token'=>'',
            ]);
            return errorAjax('账号已被锁定',['data'=>[]]);
        }

        $re_id_account = BankreceivablesModel::where('uid',$user_info['id'])->count();
        if( $re_id_account == 0){
            return errorAjax('请先添加银行卡',['data'=>['code'=>0]]);
        }
       
        
        if ($user_info['avatar'])$user_info['avatar'] = stripslashes('http://'.$_SERVER['HTTP_HOST'].'/'.$user_info['avatar']);
        $text = 'http://'.$_SERVER['HTTP_HOST'].'/#/pages/auth/register?type=0&code='.$user_info['username'];

        $params = [
            'uid'=>$user_info['id'],
        ];
      
      	//查询用户级别
      	$dai = UserLevel::where('level_id',$user_info['level'])->field('dai,level_name')->find();
      	/* 
      	if($dai['dai'] < 5)
        {
          	$user_info['dai'] = '第'.$dai['dai'].'级代理';
        }else
        {
        	$user_info['dai'] = '无限级代理';
        } */
        
        $user_info['dai'] = $dai['level_name'];
        
        $re_id_account = Users::where('re_id',$user_info['id'])->count();
     
        $user_info['re_accounts'] = $re_id_account;
       // file_put_contents(dirname(__FILE__).'/tian1.txt','准备找0==>>id：'.$user_info['id']."\r\n", FILE_APPEND);
        $user_info['re_myteams'] = 0;//$this->myteamstemp($user_info['id']);
       // if($user_info['id']==19){         
            $list_member = Users::where('id', '>', $user_info['id'])->where('re_id', '>=', $user_info['id'])->field('id,re_id,username')->order('id')->select();
          
            $user_info['re_myteams'] = $this->GetTeamMember($list_member,$user_info['id']);
        
       // }
       // file_put_contents(dirname(__FILE__).'/tian2.txt',date("Y-m-d H:i:s", time()).' user_info:'.print_r($user_info,1). "\r\n", FILE_APPEND);
        //解冻订单
        Hook::listen('unlockMatchOrder',$params);
        //检测订单超时
        Hook::listen('CheckOrderOut',$params);
        Hook::listen('AutoLock',$params=[]);
        return successAjax('数据获取成功',['data'=>$user_info,'code'=>1,'recommend_link'=>stripslashes($text)]);
    }
   public function GetTeamMember($members,$mid) {
       global $global_var;
       $global_var = 0;
      // file_put_contents(dirname(__FILE__).'/tian3.txt','开始找==>>GetTeamMember：'."\r\n", FILE_APPEND);
        $Teams=array();//最终结果
      //  file_put_contents(dirname(__FILE__).'/tian3.txt','开始找==>>GetTeamMember1：'."\r\n", FILE_APPEND);
        $mids=array($mid);//第一次执行时候的用户id
      //  file_put_contents(dirname(__FILE__).'/tian3.txt','sql==>>mids:'.print_r($mids,1)."\r\n", FILE_APPEND);
         do {
            $othermids=array();
            $state=false;
            foreach ($mids as $valueone) {
                foreach ($members as $key => $valuetwo) {
                  //  file_put_contents(dirname(__FILE__).'/tian3.txt','找我的下级==>>re_id：'.$valuetwo['re_id'].' valueone:'.$valueone."\r\n", FILE_APPEND);                    
                    if($valuetwo['re_id'] == $valueone){ 
                        $global_var ++;
                      //  file_put_contents(dirname(__FILE__).'/tian3.txt','找到我的下级==>>：'.$global_var."\r\n", FILE_APPEND);
                       // file_put_contents(dirname(__FILE__).'/tian3.txt','找到我的下级==>>：'.$valuetwo['id'].' username:'.$valuetwo['username']."\r\n", FILE_APPEND);
                        $Teams[] = $valuetwo['id'];//找到我的下级立即添加到最终结果中
                       // file_put_contents(dirname(__FILE__).'/tian3.txt','sql==>>Teams:'.print_r($Teams,1)."\r\n", FILE_APPEND);
                        $othermids[] = $valuetwo['id'];//将我的下级id保存起来用来下轮循环他的下级
                       // file_put_contents(dirname(__FILE__).'/tian3.txt','sql==>>othermids:'.print_r($othermids,1)."\r\n", FILE_APPEND);
                       // file_put_contents(dirname(__FILE__).'/tian3.txt','sql==>>key:'.print_r($key,1)."\r\n", FILE_APPEND);
                       // array_splice($members,$key,1);//从所有会员中删除他
                      // $result2 = array_splice($members[$key]);
                       unset($members[$key]);
                       // file_put_contents(dirname(__FILE__).'/tian3.txt','sql==>>result2:'.print_r($result2,1)."\r\n", FILE_APPEND);
                      //  file_put_contents(dirname(__FILE__).'/tian3.txt','sql==>>members:'.print_r($members,1)."\r\n", FILE_APPEND);
                        $state=true;
                    }else{
                       // file_put_contents(dirname(__FILE__).'/tian3.txt','没找到我的下级==>>：'.$valuetwo['id'].' username:'.$valuetwo['username']."\r\n", FILE_APPEND);
                    }
                }
            }
            $mids=$othermids;//foreach中找到的我的下级集合,用来下次循环
        } while ($state==true); 
       // file_put_contents(dirname(__FILE__).'/tian3.txt','找到我的下级 共==>>：'.$global_var."\r\n", FILE_APPEND);
        return $global_var;
    }
    public function myteamstemp($id){
        global $global_var;
        $global_var = 0;      
       // file_put_contents(dirname(__FILE__).'/tian1.txt','准备找==>>id：'.$id."\r\n", FILE_APPEND);
        $re_myteams =0;        
        $list = Users::where('re_id',$id)->select();      
        foreach ($list as $key=>$value){
           // file_put_contents(dirname(__FILE__).'/tian1.txt','开始找==>>id：'.$value['id'].' name:'.$value['username']."\r\n", FILE_APPEND);        
            $this->myteams_temp1($value['id']);
            $re_myteams ++;
        }   
       // file_put_contents(dirname(__FILE__).'/tian1.txt',date("Y-m-d H:i:s", time()).' global_var:'.print_r($global_var,1). "\r\n", FILE_APPEND);     
        
        return $re_myteams + $global_var; 
    }
    public function myteams_temp1($id){        
        global $global_var;
        $member_list = Users::where('re_id',$id)->find();
        file_put_contents(dirname(__FILE__).'/tian1.txt','找==>>re_id：'.$id."\r\n", FILE_APPEND);      
        if($member_list){									//判断上级是否存在
            $member_id =$member_list['id'];
            file_put_contents(dirname(__FILE__).'/tian1.txt','找到==>>id：'.$id.' re_id:'.$member_id.' name:'.$member_list['username']."\r\n", FILE_APPEND);
           // $ShareholdersMember[] = $member_list['id']; 	//把member_id存入数组（这里包括自己的ID，所以在传入初始ID的时候最好传入初始ID的上级ID（p1_id））   
            $global_var = $global_var + 1;        
            $this->myteams_temp1($member_id);		//继续执行本函数
         }else{
           file_put_contents(dirname(__FILE__).'/tian1.txt','没找到==>>id：'.$id."\r\n", FILE_APPEND);
           return $global_var;
         } 
        
    }
    
    public function get_system_config(){
        $token = request()->post('token', '');
        if (!$token)return errorAjax('请登录',['data'=>[]]);
        $user_info = Users::where('token' , $token)->field('id,aibi,static_wallet,dynamic_wallet')->find();
        if (!$user_info)return errorAjax('请登录',['data'=>[]]);
        $dbConfig = db('system_config')
            ->where('name','pay_range')
            ->whereOr('name','pay_range2')
            ->whereOr('name','pay_range3')
            ->whereOr('name','base_money')
            ->whereOr('name','static_currency')
            ->whereOr('name','dynamic_currency')
            ->field('value,name')
            ->select();
        $config = array();
        foreach ($dbConfig as $v){
            $config[$v['name']] = $v['value'];
        }
        $array = array(
            'pay_range'  => explode('|',$config['pay_range']),
            'pay_range2' => explode('|',$config['pay_range2']),
            'pay_range3' => explode('|',$config['pay_range3']),
            'base_money' => explode('|',$config['base_money']),
            'static_currency' => explode('|',$config['static_currency']),
            'dynamic_currency' => explode('|',$config['dynamic_currency']),
            'aibi'       => $user_info['aibi'],
            'static_wallet'       => $user_info['static_wallet'],
            'dynamic_wallet'       => $user_info['dynamic_wallet'],
        );
        return successAjax('',['data'=>$array]);
    }
    //我的直推
    public function my_recommend(){
        $token = request()->post('token', '');
        if (!$token)return errorAjax('请登录',['data'=>[]]);
        $user_info = Users::where('token' , $token)->field('id')->find();
        if (!$user_info)return errorAjax('请登录',['data'=>[]]);
        $page = request()->post('page', 1);
        $list = Users::where('re_id',$user_info['id'])
            ->order('id desc')
            ->field('username,reg_time,active,id')
            ->select();
        foreach ($list as $key=>$value){
            $list[$key]['reg_time'] = date('m-d H:i',$list[$key]['reg_time']);
        }
        $recommend_number = Users::where('re_id',$user_info['id'])->count();
        return successAjax('数据获取成功',['data'=>$list,'page'=>$page,'recommend_number'=>$recommend_number]);
    }
    //
    public function my_team(){
        $leader_username = request()->post('username', '');
        $token = request()->post('token', '');
        $user_info = Users::where('token' , $token)->field('username,re_level')->find();
        if (!$leader_username)return errorAjax('暂无团队信息',['data'=>[]]);
        $leader_info = Users::where('username' , $leader_username)->field('id,username,re_level,re_id,re_name')->find();
        if ($leader_info['re_level'] < $user_info['re_level'])$leader_info = Users::where('username' , $user_info['username'])->field('id,username,re_level,re_id,re_name')->find();
        $list = Users::where('re_id',$leader_info['id'])
            ->field('username,reg_time,active,re_level')
            ->order('id desc')
            ->select();
        foreach ($list as $key=>$value){
            $list[$key]['reg_time'] = date('m-d H:i',$list[$key]['reg_time']);
            $list[$key]['re_level'] = ($list[$key]['re_level'] - $user_info['re_level']).' 代';
            $list[$key]['username'] = substr_replace($value['username'], '****', 3, 4);;
        }
        $team_number = Users::where('re_path','like',"%,{$leader_info['id']},%")->count();
        if ($leader_info['re_id']){
            $upper_layer = $leader_info['re_name'];
        }else{
            $upper_layer = $user_info['username'];
        }
        return successAjax('数据获取成功',['data'=>$list,'team_number'=>$team_number,'upper_layer'=>$upper_layer]);
    }
    public function transfer(){
        $receiveUsername = request()->post('receiveUsername', '');
        $money = request()->post('money', '');
        $type = request()->post('indexpay', '');
        $token = request()->post('token', '');
        if (!$token)return errorAjax('请登录',['data'=>[]]);
        $user_info = Users::where('token' , $token)->field('id,is_lock,aibi,aixinzhongzi,username,transfer_power')->find();
        if (!$user_info)return errorAjax('请登录',['data'=>[]]);
        if ($user_info['is_lock'] != 0 )return errorAjax('您的账户已被锁定',['data'=>[]]);

        if ($money<=0 || !is_numeric($money))return errorAjax('金额不能为空',['data'=>[]]);
        $receiveUser = Users::where('username',$receiveUsername)->field('is_lock,id,username,re_id')->find();
        if (!$receiveUser)return errorAjax('转账会员不存在',['data'=>[]]);
        if ($receiveUser['is_lock'] != 0 )return errorAjax('转账会员已被锁定',['data'=>[]]);
        if ($receiveUser['id'] == $user_info['id'] )return errorAjax('不能转给自己',['data'=>[]]);
        if ($user_info['transfer_power'] != 1){
            if ($receiveUser['re_id'] != $user_info['id'] )return errorAjax('只能转给下级会员',['data'=>[]]);
        }
        switch ($type){
            case 0:$moneyType = 'aibi';
                break;
            case 1:$moneyType = 'aixinzhongzi';
                break;
            default:return errorAjax('暂不支持该类型',['data'=>[]]);
        }
        if ($user_info[$moneyType] < $money)return errorAjax('余额不足',['data'=>[]]);
        Db::startTrans();
        try{

            switch ($type){
                case 0:
                    Db::name('users')->where('id', $user_info['id'])->setDec('aibi', $money);
                    Db::name('users')->where('id', $receiveUser['id'])->setInc('aibi', $money);
                    break;
                case 1:
                    Db::name('users')->where('id', $user_info['id'])->setDec('aixinzhongzi', $money);
                    Db::name('users')->where('id', $receiveUser['id'])->setInc('aixinzhongzi', $money);
                    break;
                default:return errorAjax('暂不支持该类型',['data'=>[]]);
            }
            Db::name('history')->insert([
                'uid' => $user_info['id'],
                'username' => $user_info['username'],
                'money' => -$money,
                'type' => $moneyType,
                'remark' => '转账给会员【'.$receiveUser['username'].'】',
                'createtime' => time(),
                'option' => 'expend',
            ]);
            Db::name('history')->insert([
                'uid' => $receiveUser['id'],
                'username' => $receiveUser['username'],
                'money' => $money,
                'type' => $moneyType,
                'remark' => '会员【'.$receiveUser['username'].'】转入',
                'createtime' => time(),
                'option' => 'income',
            ]);
            Db::commit();
            return successAjax('转账成功',['data'=>[]]);
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            return errorAjax($e->getMessage(),['data'=>[]]);
        }
    }
    public function active(){
        $id = request()->post('id', '');
        $token = request()->post('token', '');
        if (!$token)return errorAjax('请登录',['data'=>[]]);
        $user_info = Users::where('token' , $token)->field('id,aixinzhongzi,is_lock,aibi,active,username')->find();
        if (!$user_info)return errorAjax('请登录',['data'=>[]]);
        if ($user_info['is_lock'] != 0)return errorAjax('您的账户已被锁定',['data'=>[]]);
        if ($user_info['active'] != 1)return errorAjax('您的账户还未激活',['data'=>[]]);

        $jihuo = db::name('system_config')->where('name','jihuo')->value('value');

        //if ($user_info['aibi'] <$jihuo)return errorAjax('花粉余额不足'.$jihuo.'个',['data'=>[]]);
        $activeUser = Users::where('id' , $id)->field('id,username,active')->find();
        if (!$activeUser)return errorAjax('会员不存在',['data'=>[]]);
        if ($activeUser['active'] == 1)return errorAjax('该会员已激活，无需重复操作',['data'=>[]]);
        Db::startTrans();
        try{
            //Db::name('users')->where('id', $user_info['id'])->setDec('aibi',$jihuo);
            Db::name('users')->where('id', $activeUser['id'])->setField('active', 1);
            Db::name('history')->insert([
                'uid' => $user_info['id'],
                'username' => $user_info['username'],
                'money' => -$jihuo,
                'type' => 'jihuo',
                'remark' => '激活会员【'.$activeUser['username'].'】',
                'createtime' => time(),
                'option' => 'expend',
            ]);
            Db::commit();
            return successAjax('激活成功',['data'=>[]]);
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            return errorAjax($e->getMessage(),['data'=>[]]);
        }
    }
    public function personal_data(){
        $realname = request()->post('realname', '');
        $alipay = request()->post('alipay', '');
        $wechat = request()->post('wechat', '');
        $bank_name = request()->post('bank_name', '');
        $bank_card = request()->post('bank_card', '');
        $token = request()->post('token', '');
        if (!$token)return errorAjax('请登录',['data'=>[]]);
        $user_info = Users::where('token' , $token)->field('id,examine')->find();
        if (!$user_info)return errorAjax('请登录',['data'=>[]]);
        if ($user_info['examine'] != 0)return errorAjax('请勿重复提交',['data'=>[]]);
        if (!$realname)return errorAjax('真实姓名不能为空',['data'=>[]]);
        if (!$alipay)return errorAjax('支付宝不能为空',['data'=>[]]);

        if (!$bank_name)return errorAjax('开户银行不能为空',['data'=>[]]);
        if (!$bank_card)return errorAjax('银行账户不能为空',['data'=>[]]);
        $res = Users::update([
            'id' => $user_info['id'],
            'realname' => $realname,
            'alipay' => $alipay,
            'bank_name' => $bank_name,
            'bank_card' => $bank_card,
            'examine' => 1,
            'examine_apply_time' => time(),
        ]);
        if ($res){
            return successAjax('提交成功',['data'=>[]]);
        }else{
            return errorAjax('未知错误',['data'=>[]]);
        }
    }
     public function personal_dataac(){
        $realname = request()->post('realname', '');
        $mobile = request()->post('mobile', '');
        $IDcard = request()->post('IDcard', '');
        $IDcardimg1 = request()->post('IDcardimg1', '');
        $IDcardimg2 = request()->post('IDcardimg2', '');
        $token = request()->post('token', '');
        if (!$token)return errorAjax('请登录',['data'=>[]]);
        $user_info = Users::where('token' , $token)->field('id,examine')->find();
        if (!$user_info)return errorAjax('请登录',['data'=>[]]);
        if ($user_info['examine'] != 0)return errorAjax('请勿重复提交',['data'=>[]]);
        if (!$realname)return errorAjax('真实姓名不能为空',['data'=>[]]);
        if (!$mobile)return errorAjax('电话号码不能为空',['data'=>[]]);
        if (!$IDcard)return errorAjax('身份证号不能为空',['data'=>[]]);
//        if (!$IDcardimg1)return errorAjax('请上传身份证正面',['data'=>[]]);
//        if (!$IDcardimg2)return errorAjax('请上传身份证反面',['data'=>[]]);

        $res = Users::update([
            'id' => $user_info['id'],
            'realname' => $realname,
            'mobile' => $mobile,
            'IDcard' => $IDcard,
            'IDcardimg1' => $IDcardimg1,
            'IDcardimg2' => $IDcardimg2,
            'examine' => 1,
            'examine_apply_time' => time(),
        ]);
        if ($res){
            return successAjax('提交成功',['data'=>[]]);
        }else{
            return errorAjax('未知错误',['data'=>[]]);
        }
    }
    public function send_mobile_code(){
        $codeType = request()->post('codeType', '');
        $randCode = rand(100000,999999);
        switch ($codeType){
            case 'reset_password':
                $mobile = request()->post('mobile', '');
                $username = request()->post('username', '');
                if (!$mobile)return errorAjax('请输入用户名',['data'=>[]]);
                $user_info = db('users')->where('username' , $mobile)->where('mobile' , $mobile)->field('id,username')->find();
                if (!$user_info)return errorAjax('会员不存在',['data'=>[]]);
                $sms = MobileCode::where('mobile',$mobile)->where('type','reset_password')->field('create_time')->find();
                if ($sms){
                    if ( time() - $sms['create_time'] < 30 )return errorAjax('发送频繁',['data'=>[]]);
                }
                //修改密码
                 $param = [
                    'mobile'        => $mobile,
                    'content'       => '您正在修改密码，验证码为：'.$randCode.',请勿泄露于他人',
                    'smsType'       => '合作短信'
                ];
                Hook::listen('SendSMS',$param);
                
                MobileCode::where('mobile',$mobile)->where('type','reset_password')->delete();
                MobileCode::create([
                    'uid'=>$user_info['id'],
                    'mobile'=>$user_info['mobile'],
                    'code'=>$randCode,
                    'type'=>'reset_password',
                    'create_time'=>time(),
                ]);
                return successAjax('发送成功',['data'=>[]]);
                break;
            case 'register':
                $mobile = request()->post('mobile', '');
                if (!$mobile)return errorAjax('请输入手机号码',['data'=>[]]);
                $rule = [
                    'mobile' => 'mobile',
                ];
                $msg = [
                    'mobile'        => '手机格式错误',
                ];
                $data = [
                    'mobile' => $mobile,
                ];
                $validate   = Validate::make($rule,$msg);
                $result = $validate->check($data);
                if(!$result) {
                    return errorAjax($validate->getError(),['data'=>[]]);
                }
                $reg = db::name('system_config')->where('name','register')->value('value');

                $is_account = Users::where('mobile',$mobile)->count();
                if ($is_account>$reg)return errorAjax('该手机号码已被使用超出',['data'=>[]]);
                $sms = MobileCode::where('mobile',$mobile)->where('type','register')->field('create_time')->find();
                if ($sms){
                    if ( time() - $sms['create_time'] < 30 )return errorAjax('发送频繁',['data'=>[]]);
                }
                //注册会员
                 $param = [
                    'mobile'        => $mobile,
                    'content'       => '您正在注册会员，验证码为：'.$randCode,
                    'smsType'       => '合作短信'
                ];
                Hook::listen('SendSMS',$param);
                MobileCode::where('mobile',$mobile)->where('type','register')->delete();
                MobileCode::create([
                    'mobile'=>$mobile,
                    'code'=>$randCode,
                    'type'=>'register',
                    'create_time'=>time(),
                ]);
                return successAjax('发送成功',['data'=>[]]);
                break;
            default: return errorAjax('暂不支持该类型',['data'=>[]]);
        }


    }
    public function resetpwd(){
        $username = request()->post('username', '');
        $mobile = request()->post('mobile', '');
        $code = request()->post('code', '');
        $password = request()->post('password', '');
        $paypwd = request()->post('paypwd', '');
        if (!$username)return errorAjax('请输入用户名',['data'=>[]]);
        $rule = [
            'password' => 'length:6,18|alphaNum',
            'paypwd'   => 'length:6,18|alphaNum',
        ];
        $msg = [
            'password'        => '密码长度为6-18位，且为字母和数字',
            'paypwd'          => '支付密码长度为6-18位，且为字母和数字',
        ];
        $data = [
            'password' => $password,
            'paypwd' => $paypwd,
        ];
        $validate   = Validate::make($rule,$msg);
        $result = $validate->check($data);
        if(!$result) {
            return errorAjax($validate->getError(),['data'=>[]]);
        }
        if(!preg_match('/^(?![0-9]+$)(?![a-zA-Z]+$)/', $password))return errorAjax('密码为数字、英文的组合',['data'=>[]]);

        $user_info = db('users')->where('username' , $username)->where('mobile',$mobile)->field('id,username,password,paypwd')->find();
        if (!$user_info)return errorAjax('会员不存在',['data'=>[]]);
        $where[] = ['mobile','=',$mobile];
        $where[] = ['type','=','reset_password'];
        $dbCode = MobileCode::where($where)->value('code');
        if (!$dbCode || $code != $dbCode)return errorAjax('请输入正确的验证码',['data'=>[]]);
        if ($user_info['password'] != md5($password)){
            db('users')->where('id',$user_info['id'])->update([
                'password'=>md5($password)
            ]);
        }
        if ($user_info['paypwd'] != md5($paypwd)){
            db('users')->where('id',$user_info['id'])->update([
                'paypwd'=>md5($paypwd)
            ]);
        }
        MobileCode::where($where)->delete();
        return successAjax('密码重置成功',['data'=>[]]);
    }
    public function change_password(){
        $token = request()->post('token', '');
        $oldpassword = request()->post('oldpassword', '');
        $newpassword = request()->post('newpassword', '');
        if (!$token)return errorAjax('请先登录',['data'=>[]]);
        $user_info = db('users')->where('token' , $token)->field('id,password')->find();
        if (!$user_info)return errorAjax('请先登录',['data'=>[]]);
        $rule = [
            'password' => 'length:6,18|alphaNum',
        ];
        $msg = [
            'password'        => '密码长度为6-18位，且为字母和数字',
        ];
        $data = [
            'newpassword' => $newpassword,
        ];
        $validate   = Validate::make($rule,$msg);
        $result = $validate->check($data);
        if(!$result) {
            return errorAjax($validate->getError(),['data'=>[]]);
        }
        if(!preg_match('/^(?![0-9]+$)(?![a-zA-Z]+$)/', $newpassword))return errorAjax('密码为数字、英文的组合',['data'=>[]]);

        $mobile = request()->post('mobile', '');
        $sendCode = request()->post('sendCode', '');        
        $sendcode_Info = Db::name('sendcode')->where('mobile',$mobile)->where('types',2)->order("id desc")->find();
        if($sendcode_Info){       
            if($sendcode_Info['sendcode'] != $sendCode || !$sendCode){              
                return errorAjax('验证码错误',['data'=>['code'=>0]]);
            }
        }
        
        if( md5($oldpassword) != $user_info['password'])return errorAjax('原密码验证失败',['data'=>[]]);
        if (md5($newpassword) == $user_info['password']){
            return successAjax('修改成功',['data'=>[]]);
        }else{
            db('users')->where('id',$user_info['id'])->update([
                'password'=>md5($newpassword)
            ]);
            Db::name('sendcode')->where('mobile',$mobile)->delete();
            return successAjax('修改成功',['data'=>[]]);
        }
    }

    public function change_paypwd(){
        $token = request()->post('token', '');
        $oldpassword = request()->post('oldpassword', '');
        $newpassword = request()->post('newpassword', '');
        if (!$token)return errorAjax('请先登录',['data'=>[]]);
        $user_info = db('users')->where('token' , $token)->field('id,paypwd')->find();
        if (!$user_info)return errorAjax('请先登录',['data'=>[]]);
        $rule = [
            'password' => 'length:6,18|alphaNum',
        ];
        $msg = [
            'password'        => '密码长度为6-18位，且为字母和数字',
        ];
        $data = [
            'newpassword' => $newpassword,
        ];
        $validate   = Validate::make($rule,$msg);
        $result = $validate->check($data);
        if(!$result) {
            return errorAjax($validate->getError(),['data'=>[]]);
        }
        if(!preg_match('/^(?![0-9]+$)(?![a-zA-Z]+$)/', $newpassword))return errorAjax('密码为数字、英文的组合',['data'=>[]]);

        $mobile = request()->post('mobile', '');
        $sendCode = request()->post('sendCode', '');
        $sendcode_Info = Db::name('sendcode')->where('mobile',$mobile)->where('types',2)->order("id desc")->find();
        if($sendcode_Info){
            if($sendcode_Info['sendcode'] != $sendCode || !$sendCode){
                return errorAjax('验证码错误',['data'=>['code'=>0]]);
            }
        }
        
        if( md5($oldpassword) != $user_info['paypwd'])return errorAjax('原密码验证失败',['data'=>[]]);
        if (md5($newpassword) == $user_info['paypwd']){
            return successAjax('修改成功',['data'=>[]]);
        }else{
            db('users')->where('id',$user_info['id'])->update([
                'paypwd'=>md5($newpassword)
            ]);
            Db::name('sendcode')->where('mobile',$mobile)->delete();
            return successAjax('修改成功',['data'=>[]]);
        }
    }
    /**
     * @return \think\response\Json
     * 获取用户推广码
     */
    public function recommend_code()
    {
        $token = request()->post('token', '');
        if (!$token)return errorAjax('请先登录',['data'=>[$token]]);
        $user_info = db('users')->where('token' , $token)->field('id,username')->find();
        if (!$user_info)return errorAjax('登录超时',['data'=>[],'is_logout'=>1]);
        //$text = 'http://'.$_SERVER['HTTP_HOST'].'/#/pages/auth/register?type=0&code='.$user_info['username'];
        $text = 'http://qt.zzhr168.cn/index.php/home/user/register?code='.$user_info['username'];

        $path = Env::get('ROOT_PATH') . 'public/recommendCode/'.$user_info['id'].'.png';

        if (file_exists($path))unlink($path);
        \PHPQRCode\QRcode::png($text, $path, 'L', 4, 2);
        //return successAjax('success',['data'=>'http://'.$_SERVER['HTTP_HOST'].'/recommendCode/'.$user_info['id'].'.png']);
        return successAjax('success',['data'=>'http://ht.zzhr168.cn /recommendCode/'.$user_info['id'].'.png']);
    }
    public function uploadPortrait(){
        $file = request()->file('file');
        // 移动到框架应用根目录/public/uploads/ 目录下
        if($file){
            $token = request()->post('token', '');
            if (!$token)return errorAjax('登录超时',['data'=>[$token]]);
            $user_info = db('users')->where('token' , $token)->field('id,avatar')->find();
            if (!$user_info)return errorAjax('登录超时',['data'=>[],'is_logout'=>1]);

            //限定3M
            $info = $file->validate(['size'=>3145728,'ext'=>'jpg,png'])->move('headPortrait');
            if($info){
                $path = 'headPortrait/'.$info->getSaveName();
                if ($user_info['avatar']){
                    if (file_exists($_SERVER['DOCUMENT_ROOT']."/".$user_info['avatar'])){
                        unlink($_SERVER['DOCUMENT_ROOT']."/".$user_info['avatar']);
                    }
                }
                db('users')->where('id',$user_info['id'])->update(['avatar'=>$path]);
                return successAjax('上传成功',['data'=>stripslashes('http://'.$_SERVER['HTTP_HOST'].'/'.$path)]);
            }else{
                return errorAjax($file->getError(),['data'=>[]]);
            }
        }

    }
    public function read_news(){
        $news = db::name('article')->order('id desc')->find();
        return successAjax('数据获取成功',['data'=>$news]);
    }
    public function queryhistory(){
         $token = request()->post('token', '');
         
          $type = request()->post('type', '');
        if (!$token)return errorAjax('请先登录',['data'=>[$token]]);
        $user_info = db('users')->where('token' , $token)->field('id,username')->find();
        if (!$user_info)return errorAjax('登录超时',['data'=>[],'is_logout'=>1]);

          $list = Db::name('history')->where('uid',$user_info['id'])
            ->where('type',$type)
            ->order('id desc')
            ->limit(100)
            ->page($page)
            ->select();
            foreach ($list as $key=>$value){
                $list[$key]['createtime'] = date('Y-m-d H:i',$value['createtime']);
            }
        return successAjax('数据获取成功',['data'=>$list,'page'=>$page]);
    }

     public function growlist(){
         $token = request()->post('token', '');
         $is_pay = request()->post('is_pay', '');
        if (!$token)return errorAjax('请先登录',['data'=>[$token]]);
        $user_info = db('users')->where('token' , $token)->field('id,username')->find();
        if (!$user_info)return errorAjax('登录超时',['data'=>[],'is_logout'=>1]);

          $list = Db::name('dongjie')->where('uid',$user_info['id'])
            ->where('is_pay',$is_pay)
            ->order('id desc')
            ->limit(100)
            ->page($page)
            ->select();
            foreach ($list as $key=>$value){
                $list[$key]['create_time'] = date('Y-m-d H:i:s',$value['create_time']);
                $list[$key]['jiedong_time'] = date('Y-m-d H:i:s',$value['jiedong_time']);
                $cucur = CucurbitaModel::where('status',1)->where('id',$value['cid'])->find();
                $list[$key]['gains'] = $cucur['gains'];
                $list[$key]['grow_day'] = $cucur['grow_day'];
                $list[$key]['thumb'] = $cucur['thumb'];
                 $date=floor(($value['jiedong_time']-time())/86400);
                $hour=floor(($value['jiedong_time']-time())%86400/3600);
                $minute=floor(($value['jiedong_time']-time())%86400/60)%60;
                $second=floor(($value['jiedong_time']-time())%86400%60);


                
                 $list[$key]['t'] = $date;
                 $list[$key]['h'] = $hour;
                 $list[$key]['f'] = $minute;
                 $list[$key]['m'] = $second; 

               
            }
        return successAjax('数据获取成功',['data'=>$list,'page'=>$page]);
    }
    public function notes(){
        $list = Db::name('article')->where('status',1)->select();
          foreach ($list as $key=>$value){
                $list[$key]['createtime'] = date('Y-m-d H:i',$value['createtime']);
               
                
            }
        return successAjax('数据获取成功',['data'=>$list]);    
    }


    /*
  * @ 申诉api
  */
    public function shensu(){
        $order_id = request()->post('order_id', '');
        $content = request()->post('content', '');
        $IDcardimg1 = request()->post('IDcardimg1', '');
        $token = request()->post('token', '');
        if (!$token)return errorAjax('请登录',['data'=>[]]);
        $user_info = Users::where('token' , $token)->field('id,username')->find();
        if (!$user_info)return errorAjax('请登录',['data'=>[]]);
        if (!$content)return errorAjax('请输入申诉内容',['data'=>[]]);
        if (!$IDcardimg1)return errorAjax('请上传凭证',['data'=>[]]);

        $data = [
            'order_id' => $order_id,
            'content' => $content,
            'evidence' => $IDcardimg1,
            'uid' => $user_info['id'],
            'username' => $user_info['username'],
            'time' => time()
        ];
        $res = DB::name('appeal')->insert($data);
        if ($res){
            return successAjax('提交成功',['data'=>['order_id'=>$order_id]]);
        }else{
            return errorAjax('未知错误',['data'=>[]]);
        }
    }

    /*
     * @ 转出api
     */
    public function zhuanchu(){
        $nums = request()->post('nums', '');
        $username = request()->post('username', '');
        $paypassword = request()->post('paypassword', '');

        $token = request()->post('token', '');

        //return successAjax('',['nums' => $nums,'username' => $username,'paypassword' => $paypassword,'token' => $token]);

        if (!$token)return errorAjax('请登录',['data'=>[]]);
        $user_info = Users::where('token' , $token)->field('id,username,aibi,paypwd')->find();
        if (!$user_info)return errorAjax('请登录',['data'=>[]]);
        if (!$nums)return errorAjax('请输入转出数量',['data'=>[]]);
        if (!$username)return errorAjax('请输入对方编号',['data'=>[]]);
        if (!$paypassword)return errorAjax('请输入二级密码',['data'=>[]]);
        if ($user_info['paypwd'] != md5($paypassword))return errorAjax('请输入正确的二级密码',['data'=>[]]);
        if ($nums > $user_info['aibi'])return errorAjax('花粉不足，不能转出',['data'=>[]]);
        $user_info2 = Users::where('username' , $username)->field('id,username,aibi')->find();
        if (!$user_info2)return errorAjax('您要转账的账户不存在',['data'=>[]]);

        Db::startTrans();
        try{
            Db::name('users')->update([
                'id' => $user_info['id'],
                'aibi' => $user_info['aibi'] - $nums
            ]);
            Db::name('users')->update([
                'id' => $user_info2['id'],
                'aibi' => $user_info2['aibi'] + $nums
            ]);
            Db::name('transfer_accounts')->insert([
                'out_userid' => $user_info['id'],
                'out_username' => $user_info['username'],
                'in_userid' => $user_info2['id'],
                'in_username' => $user_info2['username'],
                'nums' => $nums,
                'time' => time(),
            ]);
            Db::commit();
            return successAjax('转账成功',['data'=>[]]);
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            return errorAjax($e->getMessage(),['data'=>[]]);
        }
    }

    /*
     * @ 获取当前登录用户的转出记录
     */
    public function get_zhuanzhang(){
        $token = request()->post('token', '');

        $page = request()->post('page', '');
        if (!$token)return errorAjax('请先登录',['data'=>[$token]]);
        $user_info = db('users')->where('token' , $token)->field('id,username')->find();
        if (!$user_info)return errorAjax('登录超时',['data'=>[],'is_logout'=>1]);

        $list = Db::name('transfer_accounts')->where('out_userid',$user_info['id'])
            ->whereOr('in_userid',$user_info['id'])
            ->order('id desc')
            ->limit(10)
            ->page($page)
            ->select();
        foreach ($list as $key=>$value){
            $list[$key]['createtime'] = date('Y-m-d H:i',$value['time']);
        }
        return successAjax('数据获取成功',['data'=>$list,'page'=>$page]);
    }
}