<?php
namespace app\api\controller;
use app\api\model\Users;
use app\api\model\Bankreceivables as BankreceivablesModel;
use think\facade\Hook;
use think\db;
class Bankreceivables extends Common{

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
    public function index(){
        
         $token = request()->post('token', '');
        if (!$token)return errorAjax('请登录',['data'=>[]]);
        $user_info = Users::where('token' , $token)->field('id')->find();

        $page = request()->post('page', 1);
        $list = BankreceivablesModel::where('uid',$user_info['id'])
            ->order('id asc')
            ->limit(300)
            ->page($page)
            ->select();
         
        return successAjax('数据获取成功',['data'=>$list,'page'=>$page]);

    }
    public function add(){
        $token = request()->post('token', '');
        if (!$token)return errorAjax('请登录',['data'=>[]]);
        $user_info = Users::where('token' , $token)->field('id,paypwd')->find();

        $type = request()->post('type', '');
        $code = request()->post('code', '');
        $name = request()->post('name', '');
        $mobile = request()->post('mobile', '');
        $sendCode = request()->post('sendCode', '');
        $password= request()->post('pwd2', '');  
     
        if ($user_info['paypwd']!== md5($password)) {  
          
            return errorAjax('密码输入有误',['data'=>['code1'=>0]]);
        } else{
            
        }
        $sendcode_Info = Db::name('sendcode')->where('mobile',$mobile)->where('types',1)->order("id desc")->find();
        if($sendcode_Info){       
            if($sendcode_Info['sendcode'] != $sendCode || !$sendCode){              
                return errorAjax('验证码错误',['data'=>['code2'=>0]]);
            }
        }
        $subbranch = request()->post('subbranch', '');
        $img = request()->post('img', '');
        $bankont=BankreceivablesModel::where('uid',$user_info['id'])->where('moren',1)->find(); 
        if($bankont) {
            $moren=0;
        }else{
            $moren=1;
        }
        
        $data                   = array();
        $data['uid']            = $user_info['id'];
        $data['create_time']    = time();        //订单创建时间
        $data['type']           = $type;          //订单金额
        $data['code']           = $code;          //未匹配的金额
        $data['name']           = $name;    // 0=>排单，1=>提现
        $data['mobile']         = $mobile;    //0=>未匹配，1=>部分匹配，2=>全部匹配
        $data['subbranch']      = $subbranch;    //0=>未打款，1=>已打款，2=>确认收款
        $data['img']            = $img;
        $data['moren']           = $moren;
        $set=Db::name('bankreceivables')->insert($data);
        if ($set>0) {
            Db::name('sendcode')->where('mobile',$mobile)->delete();
        	 return successAjax("添加成功",['data'=>[]]);
        }else{
        	return errorAjax("错误：".$e->getMessage(),['data'=>[]]);
        }
    }  
    public function moren(){
    	 $token = request()->post('token', '');
        if (!$token)return errorAjax('请登录',['data'=>[]]);
        $user_info = Users::where('token' , $token)->field('id')->find();
        $moren = request()->post('moren', '');
        $id = request()->post('id', '');
        $find=BankreceivablesModel::where('uid',$user_info['id'])->where('moren',1)->find();
        if (!empty($find)) {
        	BankreceivablesModel::where('uid',$user_info['id'])->where('id',$find['id'])->update(['moren'=>0]);
        }
        if ($id) {
        	$up=BankreceivablesModel::where('uid',$user_info['id'])->where('id',$id)->update(['moren'=>1]);
        }

        if ($up>0) {
        	return successAjax("成功",['data'=>[]]);
        }else{
        	return errorAjax("错误：".$e->getMessage(),['data'=>[]]);
        }
    }
    public function del(){
        
        $token = request()->post('token', '');
        if (!$token)return errorAjax('请登录',['data'=>[]]);
        $user_info = Users::where('token' , $token)->field('id,paypwd')->find();
        $id = request()->post('id', '');
        
        $password= request()->post('password', '');
        if ($user_info['paypwd']!== md5($password)) {
            return errorAjax("密码输入有误",['data'=>[]]);
        }        

        $bankdel=BankreceivablesModel::where('id',$id)->where('uid',$user_info['id'])->delete(); 
        if ($bankdel>0) {
            return successAjax("成功",['data'=>[]]);
        }else{
            return errorAjax("错误：".$e->getMessage(),['data'=>[]]);
        }

    }

}