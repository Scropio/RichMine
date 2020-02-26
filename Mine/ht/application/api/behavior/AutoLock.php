<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
namespace app\api\behavior;
use think\db;
use app\api\model\Users;
use app\api\model\SystemHistory;
use app\api\model\Cucurbita as CucurbitaModel;
class AutoLock
{

    /** 该钩子用于自动锁定会员
     * 审核后超过设定天数不续排自动封号|超过设定天数不联系后台解封团队自动跳转上级
     */
    public function run($param = [])
    {
      $uid=$param['uid'];
      $sellautomatic = db::name('system_config')->where('name','sellautomatic')->value('value');
       Db::startTrans();
        try {
              $time=time();
              $list = Db::name('dongjie')->where('uid',$uid)
                    ->where('jiedong_time','<',time())
                    ->where('is_pay',0)
                    ->where('tixian',0)
                    ->order('id desc')
                    ->select(); 
              foreach ($list as $key => $va) {
                 $cucur = CucurbitaModel::where('status',1)->where('id',$va['cid'])->find();
                  $set=Db::name('dongjie')->where('id',$va['id'])->update(['is_pay'=>1]);
                  if ($set>0) {
                         $inten=$va['money']*$cucur['gains']/100;
                         $moneyint=$va['money']+$inten;
                         $that=Db::name('dongjie')->where('id',$va['id'])->update(['moneyint'=>$moneyint]); 
                         if ($that>0) {
                              Users::where('id',$va['uid'])->setInc('staticmoney',$inten);
                               Db::name('history')->insert([
                                            'uid' => $va['uid'],
                                            'username' => $va['username'],
                                            'money' => $inten,
                                            'type' => 'staticmoney',
                                            'remark' => "花收益",
                                            'createtime' => time(),
                                            'option' => 'expend',
                                            ]);
                         }  
                   }


               }

            if ($sellautomatic>0) {
                  $listlast = Db::name('dongjie')->where('is_pay',1)
                    ->where('tixian',0)
                    ->order('id desc')
                    ->limit(10)
                    ->select(); 

                  foreach ($listlast as $key => $val) {
                         $dat=Db::name('dongjie')->where('id',$val['id'])->update(['tixian'=>1]); 
                          
                          $cucurbita = Db::name('cucurbita')->where('status',1)
                          ->field('id,title,price_one,price_two')
                          ->order('id asc')
                          ->select();
                          $money=$val['moneyint'];
                          foreach($cucurbita as $key => $vo) {
                                if ($money>=$vo['price_one']&&$money<=$vo['price_two']) {
                                     $cid=$vo['id'];
                                     $c_name=$vo['title'];
                                }

                           } 
                          

                         if ($dat>0&&$val['moneyint']>0&&$cid>0) {
                              $order_id = 'C'.date('YmdHis').rand(1,9).$val['uid'];
                              $data         = array();
                              $data['order_id']   = $order_id;
                              $data['uid']        = $val['uid'];
                              $data['username']   = $val['username'];
                              $data['create_time']  = time();        //订单创建时间
                              $data['money']        = $val['moneyint'];          //订单金额
                              $data['unmatched']    = $val['moneyint'];          //未匹配的金额
                              $data['order_type']   = 1;    // 0=>排单，1=>提现
                              $data['match_status'] = 0;    //0=>未匹配，1=>部分匹配，2=>全部匹配
                              $data['pay_status']   = 0;    //0=>未打款，1=>已打款，2=>确认收款
                              $data['currency_type']  = 1;
                              $data['cid']            = $cid;    //0=>未打款，1=>已打款，2=>确认收款
                              $data['c_name']         = $c_name;
                              Db::name('match')->insert($data);
                            
                              Db::name('history')->insert([
                                  'uid' => $val['id'],
                                  'username' => $val['username'],
                                  'money' => -$val['moneyint'],
                                  'type' => 'jingtai',
                                  'remark' => '静态提现',
                                  'createtime' => time(),
                                  'option' => 'expend',
                              ]);    
                        } 
 
                  }
            }   
            
         




            Db::commit();
        } catch (\Exception $e) {
            Db::rollback();
        }       
        
    }
}
