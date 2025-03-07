<?php
namespace app\api\controller;
use app\api\model\Users;
use app\api\model\Cucurbita as CucurbitaModel;
use app\api\model\Match as MatchModel;
use think\facade\Hook;
use think\db;
class Cucurbita extends Common{

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
        $list = CucurbitaModel::where('status',1)
            ->order('id asc')
            ->limit(300)
            ->page($page)
            ->select();
           
        foreach ($list as $key => $value) {
            $order=MatchModel::where('cid',$value['id'])->where('uid',$user_info['id'])->where('order_type',0)->where('is_pay',0)->find();
 
            $ordersell=MatchModel::where('cid',$value['id'])->where('uid',$user_info['id'])->where('order_type',1)->where('is_pay',0)->find();          
          if (!empty($order)) {
                $list[$key]['yuyue'] =1;
                $list[$key]['is_vip'] =$order['is_vip'];
                $list[$key]['is_online'] =$order['is_online'];
                $list[$key]['is_show'] =$order['is_show'];
            }else{
                $list[$key]['yuyue'] =0; 
                $list[$key]['`is_vip'] =0;
                $list[$key]['is_online'] =0;
                $list[$key]['is_show'] ='-1';
            }
            
            $list[$key]['tixian'] = 0;
           
        }    
     
        return successAjax('数据获取成功',['data'=>$list,'page'=>$page]);

    }

  

}