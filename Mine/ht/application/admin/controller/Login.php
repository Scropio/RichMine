<?php
namespace app\admin\controller;
use think\Controller;
use app\api\model\Users;
use think\db;
use app\admin\model\Admin;
use app\api\model\Cucurbita as CucurbitaModel;
use think\captcha\Captcha;
class Login extends Controller
{
    private $cache_model,$system;
    public function initialize(){
        if (session('aid')) {
            $this->redirect('admin/index/index');
        }
        $this->cache_model=array('Module','AuthRule','Category','Posid','Field','System');
        $this->system = cache('System');
        $this->assign('system',$this->system);
        if(empty($this->system)){
            foreach($this->cache_model as $r){
                savecache($r);
            }
        }
    }
    public function index(){
        if(request()->isPost()) {
            $data = input('post.');
            $admin = new Admin();
            $return = $admin->login($data,$this->system['code']);
            return ['code' => $return['code'], 'msg' => $return['msg']];
        }else{
            return $this->fetch();
        }
    }
    public function verify(){
        $config =    [
            // 验证码字体大小
            'fontSize'    =>    25,
            // 验证码位数
            'length'      =>    4,
            // 关闭验证码杂点
            'useNoise'    =>    false,
            'bg'          =>    [255,255,255],
        ];
        $captcha = new Captcha($config);
        return $captcha->entry();
    }
    public function run()
    {
      
      $sellautomatic = db::name('system_config')->where('name','sellautomatic')->value('value');
       Db::startTrans();
        try {
              $time=time();
              $list = Db::name('dongjie')
                    ->where('jiedong_time','<',time())
                    ->where('is_pay',0)
                    ->where('tixian',0)
                    ->order('id desc')
                    ->limit(10)
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
           
               echo "1";
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
                              $order_id = 'C'.date('YmdHis').rand(1,9).rand(10,99).rand(100,999).$val['uid'];
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
                            
//                              Db::name('history')->insert([
//                                  'uid' => $val['id'],
//                                  'username' => $val['username'],
//                                  'money' => -$val['moneyint'],
//                                  'type' => 'jingtai',
//                                  'remark' => '静态提现',
//                                  'createtime' => time(),
//                                  'option' => 'expend',
//                              ]);
                        } 
                   echo "2";
                  }
            }   
    

           echo "成功";

            Db::commit();
        } catch (\Exception $e) {
            Db::rollback();
        }       
        
    }
  
  
  //出场某个订单
  public function yinshen_run()
    {
      
      $sellautomatic = db::name('system_config')->where('name','sellautomatic')->value('value');
       Db::startTrans();
        try {
              $time=time();
              $list = Db::name('dongjie')
                    //->where('jiedong_time','<',time())
                    ->where('is_pay',0)
                    ->where('tixian',0)
                	//->where('cid',2)
                	->where('order_id','T2019071011111095222')
                    ->order('id desc')
                    ->limit(10)
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
           
               echo "1";
               }

            if ($sellautomatic>0) {
                  $listlast = Db::name('dongjie')->where('is_pay',1)
                    ->where('tixian',0)
                    ->where('order_id','T2019071011111095222')
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
                              $order_id = 'C'.date('YmdHis').rand(1,9).rand(10,99).rand(100,999).$val['uid'];
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
                   echo "2";
                  }
            }   
    

           echo "成功";

            Db::commit();
        } catch (\Exception $e) {
            Db::rollback();
        }       
        
    }
  
  //出场某个花粉
    //select * from clt_dongjie where cid = 4 and is_pay = 0 and tixian = 0 and jiedong_time < 1563465600
    public function hulu_run()
    {
      
      $sellautomatic = db::name('system_config')->where('name','sellautomatic')->value('value');
       Db::startTrans();
        try {
              $time=time();
              $list = Db::name('dongjie')
                    ->where('jiedong_time','<',1563724800)
                	->where('cid',5)
                    ->where('is_pay',0)
                    ->where('tixian',0)
                    ->order('id desc')
                    ->limit(10)
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
           
               echo "1";
               }

            if ($sellautomatic>0) {
                  $listlast = Db::name('dongjie')->where('is_pay',1)
                    ->where('jiedong_time','<',1563724800)
                  	->where('cid',5)
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
                              $order_id = 'C'.date('YmdHis').rand(1,9).rand(10,99).rand(100,999).$val['uid'];
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
                            
//                              Db::name('history')->insert([
//                                  'uid' => $val['uid'],
//                                  'username' => $val['username'],
//                                  'money' => -$val['moneyint'],
//                                  'type' => 'jingtai',
//                                  'remark' => '静态提现',
//                                  'createtime' => time(),
//                                  'option' => 'expend',
//                              ]);
                        } 
                   echo "2";
                  }
            }   
    

           echo "成功";

            Db::commit();
        } catch (\Exception $e) {
            Db::rollback();
        }       
        
    }


    //出场宝花粉
    public function baohulu_run()
    {

        $sellautomatic = db::name('system_config')->where('name','sellautomatic')->value('value');
        Db::startTrans();
        try {
            //$time=((int)time()-14400); //提前 4 个小时
          	$time = (int)strtotime(date('Y-m-d 23:59:59',time()));
            $list = Db::name('dongjie')
                ->where('jiedong_time','<',$time)
                ->where('cid',1)
                ->where('is_pay',0)
                ->where('tixian',0)
                ->order('id desc')
                ->limit(1000)
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

                echo "1";
            }

            if ($sellautomatic>0) {
                $listlast = Db::name('dongjie')->where('is_pay',1)
                    ->where('jiedong_time','<',$time)
                    ->where('cid',1)
                    ->where('tixian',0)
                    ->order('id desc')
                    ->limit(1000)
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
                        $order_id = 'C'.date('YmdHis').rand(1,9).rand(10,99).rand(100,999).$val['uid'];
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

//                              Db::name('history')->insert([
//                                  'uid' => $val['uid'],
//                                  'username' => $val['username'],
//                                  'money' => -$val['moneyint'],
//                                  'type' => 'jingtai',
//                                  'remark' => '静态提现',
//                                  'createtime' => time(),
//                                  'option' => 'expend',
//                              ]);
                    }
                    echo "2";
                }
            }


            echo "成功";

            Db::commit();
        } catch (\Exception $e) {
            Db::rollback();
        }

    }

    //出场水娃子
    public function shuiwazi_run()
    {

        $sellautomatic = db::name('system_config')->where('name','sellautomatic')->value('value');
        Db::startTrans();
        try {
            //$time=((int)time()-14400); //提前 4 个小时
          	$time = (int)strtotime(date('Y-m-d 23:59:59',time()));
            $list = Db::name('dongjie')
                ->where('jiedong_time','<',$time)
                ->where('cid',3)
                ->where('is_pay',0)
                ->where('tixian',0)
                ->order('id desc')
                ->limit(1000)
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

                echo "1";
            }

            if ($sellautomatic>0) {
                $listlast = Db::name('dongjie')->where('is_pay',1)
                    ->where('jiedong_time','<',$time)
                    ->where('cid',3)
                    ->where('tixian',0)
                    ->order('id desc')
                    ->limit(1000)
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
                        $order_id = 'C'.date('YmdHis').rand(1,9).rand(10,99).rand(100,999).$val['uid'];
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

//                              Db::name('history')->insert([
//                                  'uid' => $val['uid'],
//                                  'username' => $val['username'],
//                                  'money' => -$val['moneyint'],
//                                  'type' => 'jingtai',
//                                  'remark' => '静态提现',
//                                  'createtime' => time(),
//                                  'option' => 'expend',
//                              ]);
                    }
                    echo "2";
                }
            }


            echo "成功";

            Db::commit();
        } catch (\Exception $e) {
            Db::rollback();
        }

    }


    //出场火娃子
    public function huowazi_run()
    {

        $sellautomatic = db::name('system_config')->where('name','sellautomatic')->value('value');
        Db::startTrans();
        try {
            //$time=((int)time()-14400); //提前 4 个小时
          	$time = (int)strtotime(date('Y-m-d 23:59:59',time()));
            $list = Db::name('dongjie')
                ->where('jiedong_time','<',$time)
                ->where('cid',4)
                ->where('is_pay',0)
                ->where('tixian',0)
                ->order('id desc')
                ->limit(1000)
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

                echo "1";
            }

            if ($sellautomatic>0) {
                $listlast = Db::name('dongjie')->where('is_pay',1)
                    ->where('jiedong_time','<',$time)
                    ->where('cid',4)
                    ->where('tixian',0)
                    ->order('id desc')
                    ->limit(1000)
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
                        $order_id = 'C'.date('YmdHis').rand(1,9).rand(10,99).rand(100,999).$val['uid'];
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

//                              Db::name('history')->insert([
//                                  'uid' => $val['uid'],
//                                  'username' => $val['username'],
//                                  'money' => -$val['moneyint'],
//                                  'type' => 'jingtai',
//                                  'remark' => '静态提现',
//                                  'createtime' => time(),
//                                  'option' => 'expend',
//                              ]);
                    }
                    echo "2";
                }
            }


            echo "成功";

            Db::commit();
        } catch (\Exception $e) {
            Db::rollback();
        }

    }


    //出场千里眼
    public function qianliyan_run()
    {

        $sellautomatic = db::name('system_config')->where('name','sellautomatic')->value('value');
        Db::startTrans();
        try {
            //$time=((int)time()-14400); //提前 4 个小时
          	$time = (int)strtotime(date('Y-m-d 23:59:59',time()));
            $list = Db::name('dongjie')
                ->where('jiedong_time','<',$time)
                ->where('cid',5)
                ->where('is_pay',0)
                ->where('tixian',0)
                ->order('id desc')
                ->limit(1000)
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

                echo "1";
            }

            if ($sellautomatic>0) {
                $listlast = Db::name('dongjie')->where('is_pay',1)
                    ->where('jiedong_time','<',$time)
                    ->where('cid',5)
                    ->where('tixian',0)
                    ->order('id desc')
                    ->limit(1000)
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
                        $order_id = 'C'.date('YmdHis').rand(1,9).rand(10,99).rand(100,999).$val['uid'];
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

//                              Db::name('history')->insert([
//                                  'uid' => $val['uid'],
//                                  'username' => $val['username'],
//                                  'money' => -$val['moneyint'],
//                                  'type' => 'jingtai',
//                                  'remark' => '静态提现',
//                                  'createtime' => time(),
//                                  'option' => 'expend',
//                              ]);
                    }
                    echo "2";
                }
            }


            echo "成功";

            Db::commit();
        } catch (\Exception $e) {
            Db::rollback();
        }

    }




    /*
 * @
 * @ 新自动匹配  2019-07-10
 */
    public function new_automatic_matching(){

        $where[] = ['is_pay','=',0];
        $where[] = ['match_status','<',2];

        $order = DB::name('match')->where($where)->select();

        if(empty($order)){
            $this -> error('无需要匹配的订单');
        }
        // 分等级
        for($i=0;$i<count($order);$i++){
            $new_order['jb'.$order[$i]['cid']][] = $order[$i];
        }
        // 分类型
        for($i=1;$i<=count($new_order);$i++){
            for($j=0;$j<count($new_order['jb'.$i]);$j++){
                if($new_order['jb'.$i][$j]['order_type'] == 0){
                    $new_order2['jb'.$i]['in'][] = $new_order['jb'.$i][$j];
                }else{
                    $new_order2['jb'.$i]['out'][] = $new_order['jb'.$i][$j];
                }
            }
            // 如果 买入 or 卖出 没有信息，删除该级别
            if(empty($new_order2['jb'.$i]['in']) || empty($new_order2['jb'.$i]['out'])){
                unset($new_order2['jb'.$i]);
            }
        }

        if(empty($new_order2)){
            $this -> error('无需要匹配的订单');
        }
        // 计数
        $nums = 0;
        // 循环执行每一类
        for($i=1;$i<=count($new_order2);$i++){
            for($j=0;$j<count($new_order2['jb'.$i]['out']);$j++){
                // 卖出的订单 “每隔7条”、“随机”匹配一个 买入的订单
                $rand = mt_rand($j*7,($j+1)*7-1);
                $num = 0;

                for($n=0;$n<count($new_order2['jb'.$i]['in']);$n++){
                    // 一个卖出订单 匹配 两个买入订单是因为 这两个卖出订单的用户 匹配到买入订单的用户相同，rand随机数也相同（已解决）
                    // 内循环匹配过的项 为空，再匹配到的话 就直接 $num +1 或者 往下执行
                    // 存在问题：当前外循环若匹配到了空的内循环时，将不能进行匹配
                    if($new_order2['jb'.$i]['in'][$n] == ''){
                        $num = $num+1;
                    }else{
                        // 验证 卖出订单的用户 与 买入订单的用户不同，$num +1
                        if($new_order2['jb'.$i]['out'][$j]['uid'] != $new_order2['jb'.$i]['in'][$n]['uid']){
                            $num = $num+1;
                        }
                    }

                    if($rand == $num){
                        $nums = $nums+1;// 计数
                        $this -> _pipei(['out'=>$new_order2['jb'.$i]['out'][$j],'in'=>$new_order2['jb'.$i]['in'][$n]]);
                        // 执行成功后修改当前内循环 - 键 对应的 值 为空（不能直接删除内循环中的项，因为会打乱内循环数组的键[顺序]）
                        $new_order2['jb'.$i]['in'][$n] = '';
                        break ;
                    }
                }
            }
        }
        $data['nums'] = $nums;

        $this -> success('自动匹配已完成','match/manual_match',$data);
    }

    /*
     * 匹配
     */
    private function _pipei($data){

        $order_in = $data['in'];
        $order_out = $data['out'];

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

        $epoints=$order_out['money'];

        // 开启事务
        Db::startTrans();
        try{
            Db::name('match')->update([
                'id'=>$order_in['id'],
                'match_status'=>2,
                'match_time'=>$time,
                'money'=>Db::raw('money+'.$epoints),
                'appointment'=>$appointment
            ]);

            Db::name('match')->update([
                'id'=>$order_out['id'],
                'match_status'=>2,
                'match_time'=>$time,
                'unmatched'=>Db::raw('unmatched-'.$epoints),
                'appointment'=>$appointment
            ]);

            $matchOrderId = 'M'.date('YmdHis').mt_rand(1,9).mt_rand(10,99).mt_rand(100,999);

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
            // 提交事务
            Db::commit();
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            $this->error("错误：".$e->getMessage());
        }
        // 获取 默认银行卡绑定的手机号，若没有再获取用户信息中的手机号
        $mobile_in = DB::name('bankreceivables')->where(['uid'=>$order_in['uid'],'moren'=>1])->field('mobile')->find();
        $mobile_out = DB::name('bankreceivables')->where(['uid'=>$order_out['uid'],'moren'=>1])->field('mobile')->find();
        if(empty($mobile_in)){
            $mobile_in = DB::name('users')->where(['id'=>$order_in['uid']])->field('mobile')->find();
        }
        if(empty($mobile_out)){
            $mobile_out = DB::name('users')->where(['id'=>$order_out['uid']])->field('mobile')->find();
        }
        /*
         * curl 请求 发送短信接口。返回   0  发送成功
         * 'u' => config('sms_username'),
         * 'p' => config('sms_password'),
         * 'm' => $order_in['mobile'],
         * 'c' => "【花粉兄弟】您的订单已经预约成功请登录查看。账号：".$order_in['username']." 时间：".date('Y-m-d h:i:s',$time),
         */

        $this->_curlPost(array(),config('API_HOST').'/sms?u='.config('sms_username').'&p='.config('sms_password').'&m='.$mobile_in['mobile'].'&c=【花粉兄弟】您的订单已经预约成功请登录查看。账号：'.$order_in['username'].' 时间：'.date('Y-m-d h:i:s',$time));

        //$this->_curlPost(array(),config('API_HOST').'/sms?u='.config('sms_username').'&p='.config('sms_password').'&m='.$mobile_out['mobile'].'&c=【花粉兄弟】您的订单已经预约成功请登录查看。账号：'.$order_out['username'].' 时间：'.date('Y-m-d h:i:s',$time));

        //实时匹配发送短信
        if ($appointment==0){
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
    }
  

}