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
namespace app\common\behavior;

use app\admin\model\Match as MatchModel;
use app\admin\model\Match2 as MatchModel2;
use think\db;
use app\api\model\Users;
use app\api\model\Cucurbita as CucurbitaModel;
class FinishMatchTrader
{

    /** 该钩子用于完成匹配交易
     */
    public function run($param = [])
    {

        Db::startTrans();
        try {
            MatchModel2::where('id', $param['id'])->update([
                'is_pay' => 1,
                'pay_status' => 2,
                'receipt_time' => time(),
            ]);

            $count_in_status = MatchModel2::where('in_order_id', $param['in_order_id'])
                ->where('is_pay', 0)
                ->count() ?: 0;
            if ($count_in_status == 0) {

                $in_match_status = MatchModel::where('order_id', $param['in_order_id'])->field('match_status,id,uid,username,order_id,money,cid,c_name')->find();
                $cucur = CucurbitaModel::where('status',1)->where('id',$in_match_status['cid'])->find();
                if ($in_match_status['match_status'] == 2) {
                    MatchModel::where('id', $in_match_status['id'])->update([
                        'is_pay' => 1,
                        'finish_time' => time(),
                        'shou_time' => time(),
                    ]);
                    
                    //完成交易后的打款金额
                    $tat=db::name('dongjie')->insert([
                        'uid' => $in_match_status['uid'],
                        'username' => $in_match_status['username'],
                        'oid' => $in_match_status['id'],
                        'order_id' => $in_match_status['order_id'],
                        'money' => $in_match_status['money'],
                        'create_time' => time(),
                        'jiedong_time'=> (time()+$cucur['grow_day']*86400)-36000,
                        'cid' => $in_match_status['cid'],
                        'c_name' => $in_match_status['c_name'],
                         
                    ]);
                     Db::name('history')->insert([
                                    'uid' => $in_match_status['uid'],
                                    'username' => $in_match_status['username'],
                                    'money' => $in_match_status['money'],
                                    'type' => 'yuyue',
                                    'remark' => "预约成功",
                                    'createtime' => time(),
                                    'option' => 'expend',
                                    'cid' => $in_match_status['cid'],
                                     'c_name' => $in_match_status['c_name'],
                                ]); 
                    
                    $pgc=Users::where('id',$in_match_status['uid'])->setInc('pgc',$cucur['pgc']);
                    if ($pgc>0) {
                         Db::name('history')->insert([
                                    'uid' => $in_match_status['uid'],
                                    'username' => $in_match_status['username'],
                                    'money' => $in_match_status['money'],
                                    'type' => 'yuyue',
                                    'remark' => "预约成功赠送CBC",
                                    'createtime' => time(),
                                    'option' => 'expend',
                                    ]);
                    }

                  Users::where('id',$in_match_status['uid'])->setInc('buy_totlemoney',$in_match_status['money']);
                   
                  $this->bouse($in_match_status['uid'],$in_match_status['money']*$cucur['gains']/100);
                    
                }
            }

           // $this->user_level($in_match_status['uid']);　//原逻辑
            //$this->new_user_level($in_match_status['uid']);

            $count_out_status = MatchModel2::where('out_order_id', $param['out_order_id'])
                ->where('is_pay', 0)
                ->count() ?: 0;

            if ($count_out_status == 0) {
            
                $out_match_status = MatchModel::where('order_id', $param['out_order_id'])->field('match_status,id')->find();
                if ($out_match_status['match_status'] == 2) {
                    db::name('match')->where('id', $out_match_status['id'])->update([
                        'is_pay' => 1,
                        'finish_time' => time(),
                        'shou_time' => time(),
                    ]);
                }
            }
            Db::commit();
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            return array('status' => false, 'info' => $e->getMessage());
        }
        return array('status' => true, 'info' => 'success');
    }
    public function user_level($uid){
      

      $user =Users::where('id',$uid)->field('id,re_id,re_path,re_level')->find();
        $list =Users::where('id','in',"0{$user['re_path']}0")
         ->where('is_lock',0)
         ->field('id,email,re_level,level')
         ->order('re_level desc')
         ->select();

      foreach ($list as $key => $va) {
          $count=Users::where('re_id',$va['id'])->where('buy_totlemoney','>',0)->count();
          $id=$va['id'];
          $countitem=Users::where("re_path like '%$id%'")->where('buy_totlemoney','>',0)->count();
          $countzhu=Users::where("re_path like '%$id%'")->where('buy_totlemoney','>',0)->where('level',5)->count();

          $A_one=Db::name('user_level')->where('level_id',2)->find();
          $A_two=Db::name('user_level')->where('level_id',3)->find();
          $A_three=Db::name('user_level')->where('level_id',4)->find();
          $A_four=Db::name('user_level')->where('level_id',5)->find();
          $A_five=Db::name('user_level')->where('level_id',6)->find();

          if ($va['level']==1&&$count>=$A_one['bomlimit']&&$A_one['toplimit']>=$countitem) {
              Users::where('id='.$va['id'])->update(['level'=>2]);
          }
          if ($va['level']==2&&$count>=$A_two['bomlimit']&&$A_two['toplimit']>=$countitem) {
              Users::where('id='.$va['id'])->update(['level'=>3]);
          }
          if ($va['level']==3&&$count>=$A_three['bomlimit']&&$A_three['toplimit']>=$countitem) {
              Users::where('id='.$va['id'])->update(['level'=>4]);
          }
          if ($va['level']==4&&$count>=$A_four['bomlimit']&&$A_four['toplimit']>=$countitem) {
              Users::where('id='.$va['id'])->update(['level'=>5]);
          }
          if ($va['level']==5&&$count>=$A_five['bomlimit']&&$A_five['toplimit']>=$countitem&&$countzhu>=2) {
              Users::where('id='.$va['id'])->update(['level'=>6]);
          }

      }   
   }

    /**
     * 新的升级逻辑
     */
   public function new_user_level($uid)
   {
       $user =Users::where('id',$uid)->field('id,re_id,re_path,re_level')->find();
       $list =Users::where('id','in',"0{$user['re_path']}0")
           ->where('is_lock',0)
           ->field('id,email,re_level,level')
           ->order('re_level desc')
           ->select();

       foreach ($list as $key => $va) {
           //上级拉的人头数并且带消费的
           $count=Users::where('re_id',$va['id'])->count();
           $id=$va['id'];
           //获取团队人数并且带消费的
           $countitem=Users::where("re_path like '%$id%'")->count();
           $countzhu=Users::where("re_path like '%$id%'")->where('buy_totlemoney','>',0)->where('level',5)->count();

           $A_one=Db::name('user_level')->where('level_id',1)->find();
           $A_two=Db::name('user_level')->where('level_id',2)->find();
           $A_three=Db::name('user_level')->where('level_id',3)->find();
           $A_four=Db::name('user_level')->where('level_id',4)->find();
           $A_five=Db::name('user_level')->where('level_id',7)->find();

           if ($va['level']==1&&$count>=$A_one['bomlimit']&&$A_one['toplimit']>=$countitem) {
               Users::where('id='.$va['id'])->update(['level'=>2]);
           }
           if ($va['level']==2&&$count>=$A_two['bomlimit']&&$A_two['toplimit']>=$countitem) {
               Users::where('id='.$va['id'])->update(['level'=>3]);
           }
           if ($va['level']==3&&$count>=$A_three['bomlimit']&&$A_three['toplimit']>=$countitem) {
               Users::where('id='.$va['id'])->update(['level'=>4]);
           }
           if ($va['level']==4&&$count>=$A_four['bomlimit']&&$A_four['toplimit']>=$countitem) {
               Users::where('id='.$va['id'])->update(['level'=>7]);
           }
//           if ($va['level']==5&&$count>=$A_five['bomlimit']&&$A_five['toplimit']>=$countitem) {
//               Users::where('id='.$va['id'])->update(['level'=>6]);
//           }

       }
   }

//   public function bouse($uid,$money){
//
//     $config = $this->systemConfig(['configName' => ['recommend_bonus', 'yeji']]);
//
//     $recommend_bonus = explode('|',$config['recommend_bonus']);
//     $yeji = explode('|',$config['yeji']);
//
//
//
//    $user_info = Users::where('id',$uid)->field('id,username,re_id,re_path,re_level,buy_totlemoney')->find();
//     $leve=$user_info['re_level']-12;
//
//     $list = Users::where('id','in',"0{$user_info['re_path']}0")
//     ->where('re_level','>',$leve)
//     ->where('is_lock',0)
//     ->field('id,username,re_level,level,buy_totlemoney')
//     ->order('re_level desc')
//     ->select();
//
//
//     foreach ($list as $key => $va) {
//     $level = $user_info['re_level'] - $va['re_level'];
//     $dai=Db::name('user_level')->where('level_id',$va['level'])->find();
//
//
//       if ($level==1&&$dai['dai']>=1&&$va['level']>=2&&$va['buy_totlemoney']>0) {
//             if ($va['buy_totlemoney']<$user_info['buy_totlemoney']) {
//              $money=0;
//             }
//             $money_one=$money*$recommend_bonus[0]/100;
//            if ($money_one>0) {
//               $one=Users::where('id',$va['id'])->setInc('dynamic_wallet',$money_one);
//               $tend=Users::where('id',$va['id'])->setInc('dynamic',$money_one);
//             }
//
//            if ($one>0&&$money_one>0) {
//                Db::name('history')->insert([
//                    'uid' => $va['id'],
//                    'username' => $va['username'],
//                    'money' => +$money_one,
//                    'type' => 'dynamic',
//                    'remark' => $level."代领导奖",
//                    'createtime' => time(),
//                    'option' => 'expend',
//                ]);
//                 Db::name('history')->insert([
//                    'uid' => $va['id'],
//                    'username' => $va['username'],
//                    'money' => +$money_one,
//                    'type' => 'iten',
//                    'remark' => $level."代领导奖",
//                    'createtime' => time(),
//                    'option' => 'expend',
//                ]);
//             }
//
//         }
//         if ($level==2&&$dai['dai']>=2&&$va['level']>=3&&$va['buy_totlemoney']>0) {
//             if ($va['buy_totlemoney']<$user_info['buy_totlemoney']) {
//              $money=0;
//             }
//             $money_two=$money*$recommend_bonus[1]/100;
//            if ($money_two>0) {
//               $one=Users::where('id',$va['id'])->setInc('dynamic_wallet',$money_two);
//               $tend=Users::where('id',$va['id'])->setInc('dynamic',$money_two);
//             }
//
//            if ($one>0&&$money_two>0) {
//                Db::name('history')->insert([
//                    'uid' => $va['id'],
//                    'username' => $va['username'],
//                    'money' => +$money_two,
//                    'type' => 'dynamic',
//                    'remark' => $level."代领导奖",
//                    'createtime' => time(),
//                    'option' => 'expend',
//                ]);
//                 Db::name('history')->insert([
//                    'uid' => $va['id'],
//                    'username' => $va['username'],
//                    'money' => +$money_two,
//                    'type' => 'iten',
//                    'remark' => $level."代领导奖",
//                    'createtime' => time(),
//                    'option' => 'expend',
//                ]);
//             }
//
//         }
//        if ($level==3&&$dai['dai']>=3&&$va['level']>=3&&$va['buy_totlemoney']>0) {
//             if ($va['buy_totlemoney']<$user_info['buy_totlemoney']) {
//              $money=0;
//             }
//             $money_three=$money*$recommend_bonus[2]/100;
//            if ($money_three>0) {
//               $one=Users::where('id',$va['id'])->setInc('dynamic_wallet',$money_three);
//               $tend=Users::where('id',$va['id'])->setInc('dynamic',$money_three);
//             }
//
//            if ($one>0) {
//                Db::name('history')->insert([
//                    'uid' => $va['id'],
//                    'username' => $va['username'],
//                    'money' => +$money_three,
//                    'type' => 'dynamic',
//                    'remark' => $level."代领导奖",
//                    'createtime' => time(),
//                    'option' => 'expend',
//                ]);
//                 Db::name('history')->insert([
//                    'uid' => $va['id'],
//                    'username' => $va['username'],
//                    'money' => +$money_three,
//                    'type' => 'iten',
//                    'remark' => $level."代领导奖",
//                    'createtime' => time(),
//                    'option' => 'expend',
//                ]);
//             }
//
//         }
//         if ($level==4&&$dai['dai']>=4&&$va['level']>=4&&$va['buy_totlemoney']>0) {
//              if ($va['buy_totlemoney']<$user_info['buy_totlemoney']) {
//              $money=0;
//             }
//             $money_three=$money*$recommend_bonus[3]/100;
//            if ($money_three>0) {
//               $one=Users::where('id',$va['id'])->setInc('dynamic_wallet',$money_three);
//               $tend=Users::where('id',$va['id'])->setInc('dynamic',$money_three);
//             }
//
//            if ($one>0&&$money_three>0) {
//                Db::name('history')->insert([
//                    'uid' => $va['id'],
//                    'username' => $va['username'],
//                    'money' => +$money_three,
//                    'type' => 'dynamic',
//                    'remark' => $level."代领导奖",
//                    'createtime' => time(),
//                    'option' => 'expend',
//                ]);
//                 Db::name('history')->insert([
//                    'uid' => $va['id'],
//                    'username' => $va['username'],
//                    'money' => +$money_three,
//                    'type' => 'iten',
//                    'remark' => $level."代领导奖",
//                    'createtime' => time(),
//                    'option' => 'expend',
//                ]);
//             }
//
//         }
//         if ($level==5&&$dai['dai']>=5&&$va['level']>=4&&$va['buy_totlemoney']>0) {
//             if ($va['buy_totlemoney']<$user_info['buy_totlemoney']) {
//              $money=0;
//             }
//             $money_five=$money*$recommend_bonus[4]/100;
//            if ($money_five>0) {
//               $one=Users::where('id',$va['id'])->setInc('dynamic_wallet',$money_five);
//               $tend=Users::where('id',$va['id'])->setInc('dynamic',$money_five);
//             }
//
//            if ($one>0&&$money_five>0) {
//                Db::name('history')->insert([
//                    'uid' => $va['id'],
//                    'username' => $va['username'],
//                    'money' => +$money_five,
//                    'type' => 'dynamic',
//                    'remark' => $level."代领导奖",
//                    'createtime' => time(),
//                    'option' => 'expend',
//                ]);
//                Db::name('history')->insert([
//                    'uid' => $va['id'],
//                    'username' => $va['username'],
//                    'money' => +$money_five,
//                    'type' => 'iten',
//                    'remark' => $level."代领导奖",
//                    'createtime' => time(),
//                    'option' => 'expend',
//                ]);
//             }
//
//         }
//
//          if ($level<=5&&$dai['dai']>=5&&$va['level']>=5&&$va['buy_totlemoney']>0) {
//              if ($va['buy_totlemoney']<$user_info['buy_totlemoney']) {
//              $money=0;
//             }
//             $money_zhu=$money*$yeji[0]/100;
//            if ($money_zhu>0) {
//               $one=Users::where('id',$va['id'])->setInc('dynamic_wallet',$money_zhu);
//               $tend=Users::where('id',$va['id'])->setInc('dynamic',$money_zhu);
//             }
//
//            if ($one>0&&$money_zhu>0) {
//                Db::name('history')->insert([
//                    'uid' => $va['id'],
//                    'username' => $va['username'],
//                    'money' => +$money_zhu,
//                    'type' => 'dynamic',
//                    'remark' => $level."代业绩奖",
//                    'createtime' => time(),
//                    'option' => 'expend',
//                ]);
//                  Db::name('history')->insert([
//                    'uid' => $va['id'],
//                    'username' => $va['username'],
//                    'money' => +$money_zhu,
//                    'type' => 'yeji',
//                    'remark' => $level."代业绩奖",
//                    'createtime' => time(),
//                    'option' => 'expend',
//                ]);
//             }
//
//         }
//
//         if ($level<=10&&$dai['dai']>=10&&$va['level']>=6&&$va['buy_totlemoney']>0) {
//             if ($va['buy_totlemoney']<$user_info['buy_totlemoney']) {
//              $money=0;
//             }
//             $money_jing=$money*$yeji[1]/100;
//            if ($money_jing>0) {
//               $one=Users::where('id',$va['id'])->setInc('dynamic_wallet',$money_jing);
//                $tend=Users::where('id',$va['id'])->setInc('dynamic',$money_jing);
//             }
//
//            if ($one>0&&$money_jing>0) {
//                Db::name('history')->insert([
//                    'uid' => $va['id'],
//                    'username' => $va['username'],
//                    'money' => +$money_jing,
//                    'type' => 'dynamic',
//                    'remark' => $level."代业绩奖",
//                    'createtime' => time(),
//                    'option' => 'expend',
//                ]);
//                Db::name('history')->insert([
//                    'uid' => $va['id'],
//                    'username' => $va['username'],
//                    'money' => +$money_jing,
//                    'type' => 'yeji',
//                    'remark' => $level."代业绩奖",
//                    'createtime' => time(),
//                    'option' => 'expend',
//                ]);
//             }
//
//         }
//
//
//     }
//
//   }


    public function bouse($uid,$money){

        $config = $this->systemConfig(['configName' => ['recommend_bonus', 'yeji']]);

        $recommend_bonus = explode('|',$config['recommend_bonus']);
        $yeji = explode('|',$config['yeji']);



        $user_info = Users::where('id',$uid)->field('id,username,re_id,re_path,re_level,buy_totlemoney')->find();
        $leve=$user_info['re_level']-12;

        $list = Users::where('id','in',"0{$user_info['re_path']}0")
            ->where('re_level','>',$leve)
            ->where('is_lock',0)
            ->field('id,username,re_level,level,buy_totlemoney,participate_order')
            ->order('re_level desc')
            ->select();


        foreach ($list as $key => $va) {
            $level = $user_info['re_level'] - $va['re_level'];
            $dai=Db::name('user_level')->where('level_id',$va['level'])->find();


            if ($level==1&&$dai['dai']>=1&&$va['level']>=2&&$va['participate_order']==1) {
//                if ($va['buy_totlemoney']<$user_info['buy_totlemoney']) {
//                    $money=0;
//                }
                $money_one=$money*$recommend_bonus[0]/100;
                if ($money_one>0) {
                    $one=Users::where('id',$va['id'])->setInc('dynamic_wallet',$money_one);
                    $tend=Users::where('id',$va['id'])->setInc('dynamic',$money_one);
                }

                if ($one>0&&$money_one>0) {
                    Db::name('history')->insert([
                        'uid' => $va['id'],
                        'username' => $va['username'],
                        'money' => +$money_one,
                        'type' => 'dynamic',
                        'remark' => $level."代领导奖",
                        'createtime' => time(),
                        'option' => 'expend',
                    ]);
                    Db::name('history')->insert([
                        'uid' => $va['id'],
                        'username' => $va['username'],
                        'money' => +$money_one,
                        'type' => 'iten',
                        'remark' => $level."代领导奖",
                        'createtime' => time(),
                        'option' => 'expend',
                    ]);
                }

            }
            if ($level==2&&$dai['dai']>=2&&$va['level']>=3&&$va['participate_order']==1) {
//                if ($va['buy_totlemoney']<$user_info['buy_totlemoney']) {
//                    $money=0;
//                }
                $money_two=$money*$recommend_bonus[1]/100;
                if ($money_two>0) {
                    $one=Users::where('id',$va['id'])->setInc('dynamic_wallet',$money_two);
                    $tend=Users::where('id',$va['id'])->setInc('dynamic',$money_two);
                }

                if ($one>0&&$money_two>0) {
                    Db::name('history')->insert([
                        'uid' => $va['id'],
                        'username' => $va['username'],
                        'money' => +$money_two,
                        'type' => 'dynamic',
                        'remark' => $level."代领导奖",
                        'createtime' => time(),
                        'option' => 'expend',
                    ]);
                    Db::name('history')->insert([
                        'uid' => $va['id'],
                        'username' => $va['username'],
                        'money' => +$money_two,
                        'type' => 'iten',
                        'remark' => $level."代领导奖",
                        'createtime' => time(),
                        'option' => 'expend',
                    ]);
                }

            }
            if ($level==3&&$dai['dai']>=3&&$va['level']>=3&&$va['participate_order']==1) {
//                if ($va['buy_totlemoney']<$user_info['buy_totlemoney']) {
//                    $money=0;
//                }
                $money_three=$money*$recommend_bonus[2]/100;
                if ($money_three>0) {
                    $one=Users::where('id',$va['id'])->setInc('dynamic_wallet',$money_three);
                    $tend=Users::where('id',$va['id'])->setInc('dynamic',$money_three);
                }

                if ($one>0) {
                    Db::name('history')->insert([
                        'uid' => $va['id'],
                        'username' => $va['username'],
                        'money' => +$money_three,
                        'type' => 'dynamic',
                        'remark' => $level."代领导奖",
                        'createtime' => time(),
                        'option' => 'expend',
                    ]);
                    Db::name('history')->insert([
                        'uid' => $va['id'],
                        'username' => $va['username'],
                        'money' => +$money_three,
                        'type' => 'iten',
                        'remark' => $level."代领导奖",
                        'createtime' => time(),
                        'option' => 'expend',
                    ]);
                }

            }
            if ($level==4&&$dai['dai']>=4&&$va['level']>=4&&$va['participate_order']==1) {
//                if ($va['buy_totlemoney']<$user_info['buy_totlemoney']) {
//                    $money=0;
//                }
                $money_three=$money*$recommend_bonus[3]/100;
                if ($money_three>0) {
                    $one=Users::where('id',$va['id'])->setInc('dynamic_wallet',$money_three);
                    $tend=Users::where('id',$va['id'])->setInc('dynamic',$money_three);
                }

                if ($one>0&&$money_three>0) {
                    Db::name('history')->insert([
                        'uid' => $va['id'],
                        'username' => $va['username'],
                        'money' => +$money_three,
                        'type' => 'dynamic',
                        'remark' => $level."代领导奖",
                        'createtime' => time(),
                        'option' => 'expend',
                    ]);
                    Db::name('history')->insert([
                        'uid' => $va['id'],
                        'username' => $va['username'],
                        'money' => +$money_three,
                        'type' => 'iten',
                        'remark' => $level."代领导奖",
                        'createtime' => time(),
                        'option' => 'expend',
                    ]);
                }

            }
            if ($level==7&&$dai['dai']>=5&&$va['level']>=4&&$va['participate_order']==1) {
//                if ($va['buy_totlemoney']<$user_info['buy_totlemoney']) {
//                    $money=0;
//                }
                $money_five=$money*$recommend_bonus[4]/100;
                if ($money_five>0) {
                    $one=Users::where('id',$va['id'])->setInc('dynamic_wallet',$money_five);
                    $tend=Users::where('id',$va['id'])->setInc('dynamic',$money_five);
                }

                if ($one>0&&$money_five>0) {
                    Db::name('history')->insert([
                        'uid' => $va['id'],
                        'username' => $va['username'],
                        'money' => +$money_five,
                        'type' => 'dynamic',
                        'remark' => $level."代领导奖",
                        'createtime' => time(),
                        'option' => 'expend',
                    ]);
                    Db::name('history')->insert([
                        'uid' => $va['id'],
                        'username' => $va['username'],
                        'money' => +$money_five,
                        'type' => 'iten',
                        'remark' => $level."代领导奖",
                        'createtime' => time(),
                        'option' => 'expend',
                    ]);
                }

            }

            if ($level<=5&&$dai['dai']>=5&&$va['level']>=5&&$va['participate_order']==1) {
//                if ($va['buy_totlemoney']<$user_info['buy_totlemoney']) {
//                    $money=0;
//                }
                $money_zhu=$money*$yeji[0]/100;
                if ($money_zhu>0) {
                    $one=Users::where('id',$va['id'])->setInc('dynamic_wallet',$money_zhu);
                    $tend=Users::where('id',$va['id'])->setInc('dynamic',$money_zhu);
                }

                if ($one>0&&$money_zhu>0) {
                    Db::name('history')->insert([
                        'uid' => $va['id'],
                        'username' => $va['username'],
                        'money' => +$money_zhu,
                        'type' => 'dynamic',
                        'remark' => $level."代业绩奖",
                        'createtime' => time(),
                        'option' => 'expend',
                    ]);
                    Db::name('history')->insert([
                        'uid' => $va['id'],
                        'username' => $va['username'],
                        'money' => +$money_zhu,
                        'type' => 'yeji',
                        'remark' => $level."代业绩奖",
                        'createtime' => time(),
                        'option' => 'expend',
                    ]);
                }

            }

            if ($level<=10&&$dai['dai']>=10&&$va['level']>=6&&$va['participate_order']==1) {
//                if ($va['buy_totlemoney']<$user_info['buy_totlemoney']) {
//                    $money=0;
//                }
                $money_jing=$money*$yeji[1]/100;
                if ($money_jing>0) {
                    $one=Users::where('id',$va['id'])->setInc('dynamic_wallet',$money_jing);
                    $tend=Users::where('id',$va['id'])->setInc('dynamic',$money_jing);
                }

                if ($one>0&&$money_jing>0) {
                    Db::name('history')->insert([
                        'uid' => $va['id'],
                        'username' => $va['username'],
                        'money' => +$money_jing,
                        'type' => 'dynamic',
                        'remark' => $level."代业绩奖",
                        'createtime' => time(),
                        'option' => 'expend',
                    ]);
                    Db::name('history')->insert([
                        'uid' => $va['id'],
                        'username' => $va['username'],
                        'money' => +$money_jing,
                        'type' => 'yeji',
                        'remark' => $level."代业绩奖",
                        'createtime' => time(),
                        'option' => 'expend',
                    ]);
                }

            }


        }

    }

    public function systemConfig($param = [])
    {
        $dbConfig = Db::name('system_config')
            ->where('name', 'in', $param['configName'])
            ->field('value,name')
            ->select();
        $config = [];
        foreach ($dbConfig as $v) {
            $config[$v['name']] = $v['value'];
        }
        return $config;
    }
}
