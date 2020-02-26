<?php
namespace Home\Controller;

use Think\Cache;
use Think\Image;

class IndexController extends BaseController
{
    public function index()
    {
       
        # 获取葫芦数据       
        $data = $this->_curlPost(array('token' => session('token')),C('API_HOST').'/api.php/api/Cucurbita/index');
    
        $adopt_time = $adopt_temp = array();
        $strattime = $endtime =$outendtime =$mixtime =$mixtime_temp = $endtime_id =0;
        $flage=0;
        foreach ($data['data']['data'] as &$item)
        {
            $item['thumb'] = C('HOST_NAME').$item['thumb'];
            $adopt_time = explode('-', $item['adopt_time']);
          //  $adopt_temp[]=array(trim($adopt_time[0]),$item['id']);      
            if($flage==0){
                $strattime = date("Y-m-d").' '.trim($adopt_time[0]).":00";           
                $endtime = date("Y-m-d").' '.trim($adopt_time[1]).":00";           
                $newtime =time();
                if($newtime >= strtotime($strattime) && $newtime <= strtotime($endtime)){
                
                    $outendtime = $adopt_time[0];
                    $endtime_id = $item['id'];
                    $flage=1;
                }else if($newtime <= strtotime($strattime)){
                    if($mixtime ==0){                        
                       $mixtime = abs($newtime - strtotime($strattime));                       
                  
                       $endtime_id = $item['id'];
                       $outendtime = trim($adopt_time[0]);
                    }else{
                        $mixtime_temp = abs($newtime - strtotime($strattime));                
                        if($mixtime > $mixtime_temp){
                            $mixtime = $mixtime_temp;
                            $endtime_id = $item['id'];
                            $outendtime = trim($adopt_time[0]);                        
                        }
                    }
                }
                
            }                     
        } 
                
       // $this->assign('endtime',date('Y-m-d').' '.$endtime.':00');
        $this->assign('endtime',date('Y-m-d').' '.$outendtime.':00');
        $this->assign('endtime_id',$endtime_id);
        $this->assign('endtime_token',session('token'));
        
        if(I('get.suc_msg'))
        {
            $this->assign('suc_msg',I('get.suc_msg'));
        }

        if(I('get.code'))
        {
            $this->assign('code',I('get.code'));
        }

        //检测是否有匹配信息
        if(session('token'))
        {
             $msg_data = $this->_curlPost(array('token' => session('token')),C('API_HOST').'/api.php/api/Match/getppmsg');

            if($msg_data['data'])
            {
                foreach ($msg_data['data'] as $val)
                {
                    echo '<script>alert("'.$val['msg'].'")</script>';
                    $this->_curlPost(array('id' => $val['id']),C('API_HOST').'/api.php/api/Match/setppmsg');
                }
            } 
        }
 
         $this->assign('host_name',C('HOST_NAME'));
        # tab选中效果
        $this->assign('tab','home');
        $this->assign('data',$data);
        $this->display();
    }

    /**
     * 预约葫芦娃
     */
    public function yhl()
    {
        $id = trim(I('get.id'));
        $data = $this->_curlPost(array(
            'cid' => $id,
            'token' => session('token'),
        ),C('API_HOST').'/api.php/api/Match/buy_ac');

        $this->redirect('/home/index/index?code='.$data['code'].'&suc_msg='.$data['msg']);
    }

    /**
     * 自动抢预约葫芦娃
     */
    public function yhlauto()
    {
        $id = trim(I('get.id'));
        $data = $this->_curlPost(array(
            'cid' => $id,
            'token' => session('token'),
        ),C('API_HOST').'/api.php/api/Match/buy_acauto');
    
        $this->redirect('/home/index/index?code='.$data['code'].'&suc_msg='.$data['msg']);
    }
    
    /**
     * 抢预约葫芦娃
     */
    public function yhlonline()
    {
        $id = trim(I('get.id'));
        $data = $this->_curlPost(array(
            'cid' => $id,
            'token' => session('token'),
        ),C('API_HOST').'/api.php/api/Match/buy_aconline');
    
        $this->redirect('/home/index/index?code='.$data['code'].'&suc_msg='.$data['msg']);
    }
    
    /**
     * 我的宝藏（个人中心）
     */
    public function baoz()
    {
        # 获取个人信息
        $data = $this->_curlPost(array('token' => session('token')),C('API_HOST').'/api.php/api/User/get_user_info');
        $this->assign('data',$data);

        # tab选中效果
        $this->assign('tab','baoz');
        $this->display();
    }

    /**
     * 交易市场
     */
    public function trade()
    {
        if(IS_AJAX)
        {

            $page = trim(I('get.page',1));
            $token = session('token');

            $data = $this->_sell_in($page,$token);
            //$ajx = json_encode($data);//转换为json
            $data['page'] = $page;

            $this->ajaxReturn($data);

            //$this->assign('page',($page+1));
        }else
        {
            $page = trim(I('get.page',1));
            $token = session('token');

            $data = $this->_sell_in($page,$token);

            $this->assign('token',$token);
            //$this->assign('api_host',C('API_HOST'));
            $this->assign('host_name',C('HOST_NAME'));

            # tab选中效果
            $this->assign('tab','trade');
            $this->assign('data',$data);

            $this->assign('page',$page);

            $this->display();
        }

    }

    /**
     * 我的矿场
     */
    public function kuangc()
    {
        # tab选中效果
        $this->assign('tab','kuangc');
        $this->display();
    }

    /**
     * 买入记录
     */
    private function _sell_in($page,$token)
    {
        return $this->_curlPost(array(
            'page' => $page,
            'token' => $token,
        ),C('API_HOST').'/api.php/api/Match/match_order');
    }

    /**
     * 救爷队友
     */
    public function jiu_ye()
    {
        $data = $this->_curlPost(array(
            'token' => session('token')
        ),C('API_HOST').'/api.php/api/User/my_recommend');

        # tab选中效果
        $this->assign('tab','baoz');
        $this->assign('data',$data);
        $this->display();
    }

    /**
     * 激活队友
     */
    public function active_dy()
    {
        $id = I('get.id');
        $data = $this->_curlPost(array(
            'token' => session('token'),
            'id' => $id,
        ),C('API_HOST').'/api.php/api/User/active');

        $this->redirect('/home/index/jiu_ye');
    }

    /**
     * 邀请好友
     */
    public function invite_dy()
    {
        $data = $this->_curlPost(array(
            'token' => session('token')
        ),C('API_HOST').'/api.php/api/User/recommend_code');

        $this->assign('data',$data);
        $this->assign('tab','baoz');
        $this->display();
    }

    /**
     * 葫芦记录
     */
    public function hulu_record()
    {
        $is_pay = I('get.is_pay',0);
        $page = I('get.page',1);

        $data = $this->_curlPost(array(
            'token' => session('token'),
            'is_pay' => $is_pay,
            'page' => $page,
        ),C('API_HOST').'/api.php/api/Match/match_zhuanrang');

        $this->assign('is_pay',$is_pay);
        $this->assign('page',$page);
        $this->assign('data',$data);
        $this->display();
    }

    /**
     * 葫芦生长
     */
    public function hulu_shengzhang()
    {
        $is_pay = I('get.is_pay',0);
        $page = I('get.page',1);

        $data = $this->_curlPost(array(
            'token' => session('token'),
            'is_pay' => $is_pay,
            'page' => $page,
        ),C('API_HOST').'/api.php/api/User/growlist');

        //var_dump($data);

        if(0 == $is_pay)
        {
            foreach ($data['data']['data'] as &$item)
            {
                $item['now_time'] = time();
                $item['r_jiedong_time'] = strtotime($item['jiedong_time']);
                $item['r_time'] = (int)$item['r_jiedong_time'] - (int)time();
            }
        }

        $this->assign('host_name',C('HOST_NAME'));
        $this->assign('is_pay',$is_pay);
        $this->assign('page',$page);
        $this->assign('data',$data);
        $this->display();
    }

    /**
     * 预约查询
     */
    public function yuyue_chaxun()
    {
        $page = I('get.page',1);
        $data = $this->_curlPost(array(
            'token' => session('token'),
            'type' => 'yuyue',
            'page' => $page,
        ),C('API_HOST').'/api.php/api/User/queryhistory');
        $this->assign('data',$data);
        $this->display();
    }

    /**
     * 葫芦娃
     */
    public function huluwa()
    {
        $page = I('get.page',1);

        $userInfo = $this->_curlPost(array(
            'token' => session('token'),
        ),C('API_HOST').'/api.php/api/User/get_user_info');

        $data = $this->_curlPost(array(
            'token' => session('token'),
            'type' => 'staticmoney',
            'page' => $page,
        ),C('API_HOST').'/api.php/api/User/queryhistory');

        $this->assign('userInfo',$userInfo);
        $this->assign('data',$data);
        $this->display();
    }

    /**
     * 葫芦收益
     */
    public function hulu_shouyi()
    {
        if(I('get.msg'))
        {
            $this->assign('msg',I('get.msg'));
        }
        $page = I('get.page',1);
        $type = I('get.type','iten');

        switch ($type)
        {
            case 'iten':
                $url = C('API_HOST').'/api.php/api/User/queryhistory';
                break;

            case 'yeji':
                $url = C('API_HOST').'/api.php/api/User/queryhistory';
                break;

            case 'fanzhi':
                $url = C('API_HOST').'/api.php/api/Cucurbita/index';
                break;

            default:
                break;
        }

        $data = $this->_hulu_shouyi($page,$type,$url);
        $this->assign('host_name',C('HOST_NAME'));
        $this->assign('type',$type);
        $this->assign('page',$page);
        $this->assign('data',$data);
        $this->display();
    }

    private function _hulu_shouyi($page,$type,$url)
    {
        $data = $this->_curlPost(array(
            'token' => session('token'),
            'type' => $type,
            'page' => $page,
        ),$url);

        return $data;
    }

    /**
     * 葫芦收益——繁殖
     */
    public function hulu_shouyi_fanzhi()
    {
        $cid = I('get.cid');
        $title = I('get.title');
        $password = I('get.password');
        $data = $this->_curlPost(array(
            'token' => session('token'),
            'cid' => $cid,
            'title' => $title,
            'password' => $password
        ),C('API_HOST').'/api.php/api/Match/sell_acdong');
        $this->redirect('/home/index/hulu_shouyi?type=fanzhi&msg='.$data['msg']);
    }


    /**
     * 葫芦总收益
     */
    public function hulu_zongshouyi()
    {
        $page = I('get.page',1);

        $userInfo = $this->_curlPost(array(
            'token' => session('token'),
        ),C('API_HOST').'/api.php/api/User/get_user_info');

        $data = $this->_curlPost(array(
            'token' => session('token'),
            'type' => 'dynamic',
            'page' => $page,
        ),C('API_HOST').'/api.php/api/User/queryhistory');

        $this->assign('userInfo',$userInfo);
        $this->assign('data',$data);
        $this->display();
    }

    /*
     * 葫芦
     */
    public function hulu()
    {
        $page = I('get.page',1);

        $userInfo = $this->_curlPost(array(
            'token' => session('token'),
        ),C('API_HOST').'/api.php/api/User/get_user_info');

        $data = $this->_curlPost(array(
            'token' => session('token'),
            'type' => 'aibi',
            'page' => $page,
        ),C('API_HOST').'/api.php/api/User/queryhistory');

        $this->assign('userInfo',$userInfo);
        $this->assign('data',$data);
        $this->display();
    }

    /**
     * PGC
     */
    public function pgc()
    {
        $this->display();
    }

    /**
     * 安全中心
     */
    public function anquanzhongxin()
    {
        $this->display();
    }

    /**
     * 实名认证
     */
    public function shimingrenzheng()
    {
        # 获取用户信息，检测用户是否已经认证
        $data = $this->_curlPost(array(
            'token' => session('token'),
        ),C('API_HOST').'/api.php/api/User/get_user_info');
        file_put_contents(dirname(__FILE__).'/tian1.txt','sql==>>data:'.print_r($data,1)."\r\n", FILE_APPEND);
        file_put_contents(dirname(__FILE__).'/tian1.txt','sql==>>code:'.print_r($data['data']['data']['code'],1)."\r\n", FILE_APPEND);
        if($data['data']['data']['code']==0){
           $this->redirect('/home/index/add_bankcard?msg='.$data['msg']);
        }else if(2 == $data['data']['data']['examine'])
        {
            # 实名认证过
            $this->display('Index/has_shimingrenzheng');
        }elseif (1 == $data['data']['data']['examine'])
        {
            # 实名认证审核中
            $this->display('Index/will_shimingrenzheng');
        }
        else
        {
            # 未实名认证
            $code = I('get.code',0);
            $msg = I('get.msg','');

            if($code)
            {
                $this->assign('code',$code);
            }

            if($msg)
            {
                $this->assign('msg',$msg);
            }
          
          $this->assign('host_name',C('HOST_NAME'));
          
            $this->assign('token',session('token'));
            $this->assign('api_host',C('API_HOST'));
            $this->display();
        }
    }


    /**
     * 实名认证
     */
    public function doshimingrenzheng()
    {
        $realname = I('post.realname','');
        $mobile = I('post.mobile','');
        $IDcard = I('post.IDcard','');
        $IDcardimg1 = I('post.IDcardimg1','');
        $IDcardimg2 = I('post.IDcardimg2','');

        $data = $this->_curlPost(array(
            'token' => session('token'),
            'realname' => $realname,
            'mobile' => $mobile,
            'IDcard' => $IDcard,
            'IDcardimg1' => $IDcardimg1,
            'IDcardimg2' => $IDcardimg2,
        ),C('API_HOST').'/api.php/api/User/personal_dataac');

        $this->redirect('/home/index/shimingrenzheng?code='.$data['code'].'&msg='.$data['msg']);
    }


    /**
     * 银行卡
     */
    public function yinhangka()
    {
        $msg = I('get.msg','');
        $data = $this->_curlPost(array(
            'token' => session('token'),
        ),C('API_HOST').'/api.php/api/Bankreceivables/index');

        $this->assign('msg',$msg);
        $this->assign('api_host',C('API_HOST'));
        $this->assign('host_name',C('HOST_NAME'));
        $this->assign('data',$data);
        $this->display();
    }
    /**
     * 默认银行卡
     */
    public function moren()
    {

        $id = I('get.id');

        $data = $this->_curlPost(array(
            'token' => session('token'),
            'id'=>$id,
            'moren'=>1,
        ),C('API_HOST').'/api.php/api/Bankreceivables/moren');

        $this->redirect('/home/index/yinhangka');
    }


    /**
     * 删除银行卡
     */
    public function del_bankcard()
    {
        $id = I('get.id');
        $password = I('get.password');
        $data = $this->_curlPost(array(
            'token' => session('token'),
            'id'=>$id,
            'password'=>$password
        ),C('API_HOST').'/api.php/api/Bankreceivables/del');        
       // $this->redirect('/home/index/hulu_shouyi?type=fanzhi&msg='.$data['msg']);
     
        $this->redirect('/home/index/yinhangka?msg='.$data['msg']);
       // $this->redirect('/home/index/yinhangka');
    }

    /**
     * 添加银行卡
     */
    public function add_bankcard()
    {
        $this->assign('host_name',C('HOST_NAME'));
        $this->assign('api_host',C('API_HOST'));
        $this->assign('token',session('token'));
        $this->display();
    }

    /**
     * 添加银行卡ing
     */
    public function add_dobankcard()
    {
        $data = $this->_curlPost(array(
            'img'=>I('post.img'),
            'type'=>I('post.type'),
            'code'=>I('post.code'),
            'name'=>I('post.name'),
            'mobile'=>I('post.mobile'),
            'sendCode'=>I('post.sendCode'),
            'subbranch'=>'',
            'token' => session('token'),
        ),C('API_HOST').'/api.php/api/Bankreceivables/add');   
      
        if($data['code']==0)
        {             
            $this->error('验证码错误', '/index.php/home/index/add_bankcard');
            exit();
        }else
        {
          
            $this->redirect('/home/index/yinhangka');
            exit();
        }
       
        //$this->redirect('/home/index/yinhangka');
    }

    /**
     * 系统消息
     */
    public function xitongxiaoxi()
    {
        $data = $this->_curlPost(array(
            'token' => session('token'),
        ),C('API_HOST').'/api.php/api/User/notes');

        $this->assign('data',$data);
        $this->display();
    }

    /**
     * 修改登录密码
     */
    public function uploginpwd()
    {
        $msg = I('get.msg','');
        $this->assign('msg',$msg);

        $this->display();
    }

    /**
     * 修改登录密码
     */
    public function dologinpwd()
    {
        $oldpassword = trim(I('post.oldpassword'));
        $newpassword = trim(I('post.newpassword'));
        $mobile = trim(I('post.mobile'));
        $sendCode = trim(I('post.sendCode'));
        $data = $this->_curlPost(array(
            'token' => session('token'),
            'oldpassword'=>$oldpassword,
            'newpassword'=>$newpassword,
            'mobile'=>$mobile,
            'sendCode'=>$sendCode,
        ),C('API_HOST').'/api.php/api/user/change_password');

        $this->redirect('/home/index/uploginpwd?msg='.$data['msg']);
    }

    /**
     * 修改二级密码
     */
    public function uptwopwd()
    {
        $msg = I('get.msg','');
        $this->assign('msg',$msg);

        $this->display();
    }

    /**
     * 修改二级密码
     */
    public function douptwopwd()
    {
        $oldpassword = trim(I('post.oldpassword'));
        $newpassword = trim(I('post.newpassword'));
        $mobile = trim(I('post.mobile'));
        $sendCode = trim(I('post.sendCode'));
        $data = $this->_curlPost(array(
            'token' => session('token'),
            'oldpassword'=>$oldpassword,
            'newpassword'=>$newpassword,
            'mobile'=>$mobile,
            'sendCode'=>$sendCode,
        ),C('API_HOST').'/api.php/api/user/change_paypwd');

        $this->redirect('/home/index/uptwopwd?msg='.$data['msg']);
    }

    /**
     * 转出
     */
    public function zhuanchu()
    {
        $msg = I('get.msg','');

        if(!empty($msg))
        {
            $this->assign('msg',$msg);
        }

        $userInfo = $this->_curlPost(array(
            'token' => session('token'),
        ),C('API_HOST').'/api.php/api/User/get_user_info');

        $this->assign('userInfo',$userInfo);
        $this->display();
    }

    public function dozhuanchu(){

        $nums = I('post.nums','');
        $username = I('post.username','');
        $paypassword = I('post.paypassword','');

        $data = $this->_curlPost(array(
            'token' => session('token'),
            'nums' => $nums,
            'username' => $username,
            'paypassword' => $paypassword,
        ),C('API_HOST').'/api.php/api/User/zhuanchu');


        $this->redirect('/home/index/zhuanchu?msg='.$data['msg']);
    }

    /**
     * 转增记录
     */
    public function zhuanzengjilu()
    {
        if(IS_AJAX) {
            $page = I('get.page',1);
            $new_page = $page + 1;
            cookie('page',$new_page);

            $userInfo = $this->_curlPost(array(
                'token' => session('token'),
            ),C('API_HOST').'/api.php/api/User/get_user_info');

            $data = $this->_curlPost(array(
                'token' => session('token'),
                'page' => $new_page,
            ),C('API_HOST').'/api.php/api/User/get_zhuanzhang');

            $this->assign('userInfo',$userInfo);
            $this->assign('data',$data);
            $this->display('zhuanzengjilus');
        }else{
            $page = I('get.page',1);
            cookie('page',$page);

            $userInfo = $this->_curlPost(array(
                'token' => session('token'),
            ),C('API_HOST').'/api.php/api/User/get_user_info');

            $data = $this->_curlPost(array(
                'token' => session('token'),
                'page' => $page,
            ),C('API_HOST').'/api.php/api/User/get_zhuanzhang');

            $this->assign('userInfo',$userInfo);
            $this->assign('data',$data);
            $this->display();
        }
    }


    /**
     * 匹配详情
     */
    public function pipeixiangqing()
    {
        $id = I('get.id',0);
        $match_time = I('get.match_time',0);
        $order_type = I('get.order_type',0); // 0为买入，1为卖出

        # 根据id查获取匹配详情
        $data = $this->_curlPost(array(
            'token' => session('token'),
            'id' => $id,
        ),C('HOST_NAME').'/api.php/api/Match/match_details');

        $this->assign('api_host',C('API_HOST'));
        $this->assign('host_name',C('HOST_NAME'));
        $this->assign('token',session('token'));
        $this->assign('data',$data);
        $this->assign('match_time',$match_time);
        $this->assign('id',$id);
        $this->assign('order_type',$order_type);
        $this->display();
    }
    
    /**
     * 确认打款
     */
    public function dakuan()
    {
        $type = I('get.type','pay');
        $match_id = I('get.match_id',0);
        $token = session('token');

        $match_time = I('get.match_time');
        $id = I('get.id');

        $data = $this->_curlPost(array(
            'token' => $token,
            'match_id' => $match_id,
            'type' => $type,
        ),C('API_HOST').'/api.php/api/Match/pay_order');

        $this->redirect('/home/index/pipeixiangqing?match_time='.$match_time.'&id='.$id);
    }

    /**
     * 立即收款
     */
    public function lijishoukuan()
    {
        $type = I('get.type','receipt');
        $match_id = I('get.match_id',0);
        $token = session('token');

        $match_time = I('get.match_time');
        $id = I('get.id');

        $data = $this->_curlPost(array(
            'token' => $token,
            'match_id' => $match_id,
            'type' => $type,
        ),C('API_HOST').'/api.php/api/Match/pay_order');

        $this->redirect('/home/index/pipeixiangqing?match_time='.$match_time.'&id='.$id);
    }

    public function getdkimg()
    {
        $id = I('get.id');
        $token = session('token');

        $data = $this->_curlPost(array(

            'id' => $id,
            'token' => $token,

        ),C('API_HOST').'/api.php/api/Match/images');

        $this->ajaxReturn(array('data' => $data,'host_name' => C('HOST_NAME')));
    }

    /**
     * 申诉
     */
    public function shensu()
    {
        $order_id = I('get.order_id','');
        $msg = I('get.msg','');

        if(!empty($msg))
        {
            $this->assign('msg',$msg);
        }

        $this->assign('order_id',$order_id);
        $this->assign('host_name',C('HOST_NAME'));
        $this->assign('token',session('token'));
        $this->assign('api_host',C('API_HOST'));
        $this->display();
    }

    /**
     * 申诉
     */
    public function doshensu()
    {
        $order_id = I('post.order_id','');
        $content = I('post.content','');
        $IDcardimg1 = I('post.IDcardimg1','');

        $data = $this->_curlPost(array(
            'token' => session('token'),
            'order_id' => $order_id,
            'content' => $content,
            'IDcardimg1' => $IDcardimg1,
        ),C('API_HOST').'/api.php/api/User/shensu');

        $this->redirect('/home/index/shensu?order_id='.$data['data']['data']['order_id'].'&msg='.$data['msg']);
    }







}