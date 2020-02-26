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
use app\api\model\Match;
use app\api\model\Match2;
use app\api\model\History;
class CheckOrderOut
{

    /** 该钩子用于检查订单超时
     */
    public function run($param = [])
    {
        $time_out = explode('|',db::name('system_config')->where('name','time_out')->value('value'));
      
        $time = time();
        $buyTimeOut   = $time - $time_out[0] * 86000;
        $sellTimeOut = $time - $time_out[1] * 86000;
       
        Db::startTrans();
        try {
            //未打款检查
            $pay[] = ['uid|bid','=',$param['uid']];
            $pay[] = ['is_pay','=',0];
            $pay[] = ['complaint','=',0];
            $pay[] = ['pay_status','=',0];
            $pay[] = ['create_time','<',$buyTimeOut];
            $inOrder = Match2::where($pay)->lock(true)->field('id,uid,money,out_order_id,in_order_id')->select();
            if ($inOrder){
                foreach ($inOrder as $item){
                    if ( $item['uid']>1 ){
                        Users::where('id',$item['uid'])->where('is_lock',0)->update([
                            'is_lock' => 1,
                            'lock_time' => $time,
                        ]);
                    }
                    //返回出场匹配金额
                    Match::where('order_id',$item['out_order_id'])->update([
                        'unmatched' => Db::raw('unmatched+'.$item['money']),
                    ]);
                    $newData = Match::where('order_id',$item['out_order_id'])
                        ->field('money,unmatched')
                        ->find();
                    if ($newData['money'] == $newData['unmatched'] && $newData['unmatched']>0){
                        Match::where('order_id',$item['out_order_id'])->update([
                            'match_status' => 0,
                        ]);
                    }
                    if ($newData['money'] > $newData['unmatched'] && $newData['unmatched']>0){
                        Match::where('order_id',$item['out_order_id'])->update([
                            'match_status' => 1,
                        ]);
                    }

                    //删除进场订单
                    Match::where('order_id',$item['in_order_id'])->delete();

                    //删除匹配订单
                    Match2::where('id',$item['id'])->delete();
                }
            }

            //未收款检查
            $sell[] = ['uid|bid','=',$param['uid']];
            $sell[] = ['is_pay','=',0];
            $sell[] = ['pay_status','=',1];
            $sell[] = ['complaint','=',0];
            $sell[] = ['is_check','=',0];
            $sell[] = ['pay_time','<',$sellTimeOut];
            $outOrder = Match2::where($sell)->lock(true)->field('id,bid,busername,out_order_id')->select();
            if ($outOrder){
                foreach ($outOrder as $value){
                    Match2::where('id',$value['id'])->update([
                        'is_check' => 1
                    ]);
                    if ( $value['bid']>1 ){
                        Users::where('id',$value['bid'])->where('is_lock',0)->update([
                            'is_lock' => 1,
                            'lock_time' => $time,
                        ]);
                    }
                    // if ($time_out[2]>0){
                    //     Users::where('id',$value['bid'])->update([
                    //         'aibi' => db::raw('aibi-'.$time_out[2])
                    //     ]);
                    //     History::create([
                    //         'uid' => $value['bid'],
                    //         'username' => $value['busername'],
                    //         'money' => -$time_out[2],
                    //         'type' => 'aibi',
                    //         'remark' => '【'.$value['out_order_id'].'】超时收款',
                    //         'createtime' => $time,
                    //         'option' => 'expend',
                    //     ]);
                    // }

                }
            }

            Db::commit();
        } catch (\Exception $e) {
            Db::rollback();
        }

        //所有会员登录都会检测撤销被封号会员的打款订单
        $lock = Users::where('is_lock',1)->lock(true)->field('id')->find();
        if ($lock){
            $inOrderList = Match2::where('is_pay',0)->where('uid',$lock['id'])->lock(true)->field('id,uid,money,out_order_id,in_order_id')->select();
            if ($inOrderList){
                foreach ($inOrderList as $item){
                    //返回出场匹配金额
                    Match::where('order_id',$item['out_order_id'])->update([
                        'unmatched' => Db::raw('unmatched+'.$item['money']),
                    ]);
                    $newData = Match::where('order_id',$item['out_order_id'])
                        ->field('money,unmatched')
                        ->find();
                    if ($newData['money'] == $newData['unmatched'] && $newData['unmatched']>0){
                        Match::where('order_id',$item['out_order_id'])->update([
                            'match_status' => 0,
                        ]);
                    }
                    if ($newData['money'] > $newData['unmatched'] && $newData['unmatched']>0){
                        Match::where('order_id',$item['out_order_id'])->update([
                            'match_status' => 1,
                        ]);
                    }

                    //删除进场订单
                    Match::where('order_id',$item['in_order_id'])->delete();
                    //删除匹配订单
                    Match2::where('id',$item['id'])->delete();
                }
                Match::where('uid',$lock['id'])->where('is_pay',0)->where('match_status',0)->where('order_type',0)->delete();
            }
        }

    }
}
