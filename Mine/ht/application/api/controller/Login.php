<?php
namespace app\api\controller;
use app\api\model\Users;
use think\Db;
use think\Validate;
use app\api\model\MobileCode;
use app\api\model\Bankreceivables as BankreceivablesModel;

class Login extends Common{

    public function initialize(){
        $token = request()->post('token', '');
        if($token){
            $user_info = Users::where('token' , $token)
                ->field('id')
                ->find();
        }
    }
    
    public function getCode()
    {
        $mobile = input('mobile');//  trim(I('post.mobile'));
        $smsapi = "http://api.smsbao.com/";
        $user = "77179475"; //短信平台帐号
        $pass = md5("kanbo123"); //短信平台密码
        $code = mt_rand(100000, 999999);
        $content='您的验证码为'.$code.'，请于5分钟内正确输入，如非本人操作，请忽略此短信';//"短信内容";//要发送的短信内容
        $phone = $mobile;//要发送短信的手机号码
        $sendurl = $smsapi."sms?u=".$user."&p=".$pass."&m=".$phone."&c=".urlencode($content);
        
        $result =file_get_contents('http://utf8.api.smschinese.cn/?Uid=链猪1234567&Key=d41d8cd98f00b204e980&smsMob='.$mobile.'&smsText='.$content);
        if($result==1){
            $data = array();
            $data['mobile']      = $mobile;
            $data['sendcode']      = $code;
            $data['create_time']      = time();
            $data['types']      = 0;
            Db::name('sendcode')->data($data)->insert();      
            return successAjax('验证码发送成功',['data'=>['code'=>1]]);           
            exit();
        }else{           
            return errorAjax('验证码发送失败'.$result,['data'=>['code'=>0]]);
            exit();
        }
    }
    
    public function getbankcardCode()
    {
        $mobile = input('mobile');//  trim(I('post.mobile'));
        $smsapi = "http://api.smsbao.com/";
        $user = "77179475"; //短信平台帐号
        $pass = md5("kanbo123"); //短信平台密码
        $code = mt_rand(100000, 999999);
        $content='【名花有主】您的验证码为'.$code.'，请于5分钟内正确输入，如非本人操作，请忽略此短信';
        $phone = $mobile;
        $sendurl = $smsapi."sms?u=".$user."&p=".$pass."&m=".$phone."&c=".urlencode($content);
        $result =file_get_contents($sendurl);
    
        if($result==0){
            $data = array();
            $data['mobile']      = $mobile;
            $data['sendcode']      = $code;
            $data['create_time']      = time();
            $data['types']      = 1;
            Db::name('sendcode')->data($data)->insert();
            return successAjax('验证码发送成功',['data'=>['code'=>1]]);
            exit();
        }else{
            return errorAjax('验证码发送失败',['data'=>['code'=>0]]);
            exit();
        }
    }
    
    public function getuploginCode()
    {
        $mobile = input('mobile');//  trim(I('post.mobile'));
        $smsapi = "http://api.smsbao.com/";
        $user = "77179475"; //短信平台帐号
        $pass = md5("kanbo123"); //短信平台密码
        $code = mt_rand(100000, 999999);
        $content='【名花有主】您的验证码为'.$code.'，请于5分钟内正确输入，如非本人操作，请忽略此短信';
        
        $token = request()->post('token', '');
        if (!$token)return errorAjax('验证码发送失败',['data'=>['code'=>0]]);
        
        $user_info = Users::where('token' , $token)->field('id,aibi,static_wallet,dynamic_wallet')->find();
        $re_Bankreceivables = BankreceivablesModel::where('uid',$user_info['id'])->find();
        if(!$re_Bankreceivables) return errorAjax('验证码发送失败',['data'=>['code'=>0]]);
        
        $phone = $re_Bankreceivables['mobile'];
        
        $sendurl = $smsapi."sms?u=".$user."&p=".$pass."&m=".$phone."&c=".urlencode($content);
        $result =file_get_contents($sendurl);
 
        if($result==0){
            $data = array();
            $data['mobile']      = $mobile;
            $data['sendcode']      = $code;
            $data['create_time']      = time();
            $data['types']      = 2;
            Db::name('sendcode')->data($data)->insert();
            return successAjax('验证码发送成功',['data'=>['code'=>1]]);
            exit();
        }else{
            return errorAjax('验证码发送失败',['data'=>['code'=>0]]);
            exit();
        }
    }
    
    public function getuptwoCode()
    {
        $mobile = input('mobile');//  trim(I('post.mobile'));
        $smsapi = "http://api.smsbao.com/";
        $user = "77179475"; //短信平台帐号
        $pass = md5("kanbo123"); //短信平台密码
        $code = mt_rand(100000, 999999);
        $content='【名花有主】您的验证码为'.$code.'，请于5分钟内正确输入，如非本人操作，请忽略此短信';
        
        $token = request()->post('token', '');
        if (!$token)return errorAjax('验证码发送失败',['data'=>['code'=>0]]);
        
        $user_info = Users::where('token' , $token)->field('id,aibi,static_wallet,dynamic_wallet')->find();
        $re_Bankreceivables = BankreceivablesModel::where('uid',$user_info['id'])->find();
        if(!$re_Bankreceivables) return errorAjax('验证码发送失败',['data'=>['code'=>0]]);
        
        $phone = $re_Bankreceivables['mobile'];
        
       // $phone = $mobile;
        $sendurl = $smsapi."sms?u=".$user."&p=".$pass."&m=".$phone."&c=".urlencode($content);
        $result =file_get_contents($sendurl);
   
        if($result==0){
            $data = array();
            $data['mobile']      = $mobile;
            $data['sendcode']      = $code;
            $data['create_time']      = time();
            $data['types']      = 3;
            Db::name('sendcode')->data($data)->insert();
            return successAjax('验证码发送成功',['data'=>['code'=>1]]);
            exit();
        }else{
            return errorAjax('验证码发送失败',['data'=>['code'=>0]]);
            exit();
        }
    }
    
    public function login(){
     
        $username = input('username');
        $password = input('password');
      
        $system_open_time  = explode('|',db('system_config')->where('name','system_open_time')->value('value'));
        if ($system_open_time[2] != 0)return errorAjax($system_open_time[4],['data'=>[]]);
        $today = strtotime(date('Y-m-d'));
//        if ( (time() < $today + $system_open_time[0]*3600) || (time() > $today+$system_open_time[1]*3600)){
//            return errorAjax($system_open_time[3],['data'=>[]]);
//        }

        if(!$username || !$password){
            return errorAjax('请填写账号或密码',['data'=>[]]);
        }

        $user = Users::where(["username"=>$username])->field('id,username,password,is_lock,active,error_login_time,error_count')->find();
        if(!$user)return errorAjax('账号不存在或密码错误',['data'=>[]]);

        if ($user['error_login_time']>0){
            if ( time() - $user['error_login_time'] < 300 ){
                if ($user['error_count']+1>5){
                    Users::where('id',$user['id'])->update([
                        'error_login_time' => time(),
                    ]);
                    return errorAjax('您已连续输错5次密码，请在5分钟后操作',['data'=>[]]);
                }
            }else{
                Users::where('id',$user['id'])->update([
                    'error_login_time' => 0,
                    'error_count' => 0,
                ]);
            }
        }

        if( $user['password'] != md5($password) ){
            Users::where('id',$user['id'])->update([
                'error_login_time' => time(),
                'error_count' => Db::raw('error_count+1'),
            ]);
            return errorAjax('账号不存在或密码错误',['data'=>[]]);
        }

        if($user['is_lock'] == 1)return errorAjax('账号异常已被锁定',['data'=>[]]);
        if($user['active'] != 1)return errorAjax('您还未激活，请联系推荐人激活账户',['data'=>[]]);

        $token  = sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x', mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x3fff) | 0x8000, mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );

        $res = Users::where('id',$user['id'])->update([
            'token' => $token,
            'error_login_time' => 0,
            'error_count' => 0,
        ]);

        if ($res){
            return successAjax('登录成功',['data'=>['token'=>$token,'username'=>$user['username']]]);
        }else{
            return errorAjax('网络超时',['data'=>[]]);
        }

    }
    public function logout(){
        $token = request()->post('token', '');
        if ($token)Users::where('token',$token)->update(['token'=>'']);
        return successAjax('退出登录',['data'=>[]]);
    }
    public function register(){
        $username = request()->post('username', '');
         $mobile = request()->post('mobile', '');
        $password = request()->post('password', '');
        $code = request()->post('code', '');
        $paypassword = request()->post('paypassword', '');
        $rename = request()->post('rename', '');
        $sendCode = request()->post('sendCode', '');
       
        $mobile_temp = $mobile;
        $sendcode_Info = Db::name('sendcode')->where('mobile',$mobile)->order("id desc")->find();
        if($sendcode_Info){
            if($sendcode_Info['sendcode'] != $sendCode || !$sendCode){
             
                return errorAjax('验证码错误',['data'=>[]]);
            }
        }               
        
        $rule = [
            'mobile' => 'length:11|mobile',
            'password' => 'length:6,18|alphaNum',
            'paypassword' => 'length:6,18',
        ];
        $msg = [
            'mobile'        => '手机格式错误',
            'password'        => '密码长度为6-18位，且为字母和数字',
            'paypassword'        => '二级密码长度为6-18位',
        ];
        $data = [
            'mobile' => $mobile,
            'password' => $password,
            'paypassword' => $paypassword,
        ];
        
        $validate   = Validate::make($rule,$msg);        
        $result = $validate->check($data);
        if(!$result) {
            return errorAjax($validate->getError(),['data'=>[]]);
        }
       
        if(!preg_match('/^(?![0-9]+$)(?![a-zA-Z]+$)/', $password))return errorAjax('密码为数字、英文的组合',['data'=>[]]);

        $is_account = Users::where('username',$username)->count();       
        if ($is_account>0)return errorAjax('该账号已被使用',['data'=>[]]);

        # 检测手机号码
        if(Users::where('mobile',$mobile)->count() > 50)
        {
            return errorAjax('手机号不能注册超过50个',['data'=>[]]);
        }

        if (!$rename)return errorAjax('请填写推荐人',['data'=>[]]);
        $reInfo = Users::where('username',$rename)->field('username,id,is_lock,re_path,re_level,active')->find();
        if (!$reInfo)return errorAjax('推荐人不存在',['data'=>[]]);
        if ($reInfo['is_lock'] !=0 )return errorAjax('推荐人已被锁定',['data'=>[]]);
        if ($reInfo['active'] != 1)return errorAjax('推荐人账号还未激活',['data'=>[]]);
        $where = [];
        $where[] = ['mobile','=',$mobile];
        $where[] = ['type','=','register'];
        //$dbCode = MobileCode::where($where)->value('code');
        //if (!$dbCode || $code != $dbCode)return errorAjax('请输入正确的验证码',['data'=>[]]);
        $data = array();
        $data['username']      = $username;
        $data['password']      = md5($password);
        $data['paypwd']        = md5($paypassword);
        $data['reg_time']      = time();
        $data['mobile']        = $mobile;
        $data['re_id']         = $reInfo['id'];
        $data['re_name']       = $reInfo['username'];
        $data['re_path']       = $reInfo['re_path'].$reInfo['id'].',';
        $data['re_level']      = $reInfo['re_level']+1;
        $data['active'] = 1;

        //激活逻辑
//        $data['active'] = 1;
//        $data['aibi'] = 50;
//        $token  = sprintf(
//            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x', mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x3fff) | 0x8000, mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
//        );
//        $data['token']          = $token;
        $result = Users::create($data);
        if ($result){
            MobileCode::where($where)->delete();
                         
            Db::name('sendcode')->where('mobile',$mobile_temp)->delete();
              
            
            return successAjax('注册成功',['data'=>$data]);
        }else{
            return errorAjax('网络错误',['data'=>[]]);
        }
    }
    public function roll_info(){

        $data = [
            'http://'.$_SERVER['HTTP_HOST'].'/rollImage/801.png',
        ];
        return successAjax('',['data'=>$data]);
    }

}