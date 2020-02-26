<?php
namespace Home\Controller;

use Think\Controller;
use Think\Image;
//use Think\Session;

class UserController extends Controller
{
    public function tests()
    {
        exit('asdfasdfsd');
    }

    public function login()
    {
        if(I('get.err_msg'))
        {
            $this->assign('err_msg',I('get.err_msg'));
        }

        # 检测是否有登录的cookie
        if(! empty($_COOKIE['username']))
        {
            $this->assign('username',$_COOKIE['username']);
        }else
        {
            $this->assign('username','');
        }

        if(! empty($_COOKIE['password']))
        {
            $this->assign('password',$_COOKIE['password']);
        }else
        {
            $this->assign('password','');
        }

        $this->display();
    }

    public function doLogin()
    {
        $username = trim(I('get.username'));
        $password = trim(I('get.password'));


        # curl 请求登录接口
        $data = $this->_curlPost(array(
            'username' => $username,
            'password' => $password,
        ),C('API_HOST').'/api.php/api/Login/login');

        # 是否记住密码
        if(I('get.remeber'))
        {
            setcookie("username",$username,time()+3600*24*365);
            setcookie("password",$password,time()+3600*24*365);
        }

        if(1 === (int)$data['code'] && isset($data['data']['data']))
        {
            session('token',$data['data']['data']['token']);
            $this->redirect('/home/index/index?suc_msg='.$data['msg']);
        }else
        {
            $this->redirect('/home/user/login?err_msg='.$data['msg']);
        }
    }

    /**
     * 退出登录
     */
    public function logout()
    {
        session(null);
        $this->redirect('/home/user/login');
    }

    /**
     * 注册
     */
    public function register()
    {
        $code = I('get.code','');
        $this->assign('code',$code);
        $this->display();
    }

    /**
     * 生成验证码
     */
    public function vcode()
    {
        $Verify = new \Think\Verify(array(
            'fontSize'    =>    30,    // 验证码字体大小
            'length'      =>    3,     // 验证码位数
            'useNoise'    =>    false, // 关闭验证码杂点
        ));
        $Verify->codeSet = '0123456789';
        $Verify->entry();
    }
    public function getCode()
    {
        $mobile = trim(I('post.mobile'));     
        # curl 请求登录接口
        $data = $this->_curlPost(array(
        'mobile' => $mobile,       
        ),C('API_HOST').'/api.php/api/Login/getCode');
        if($data['code']==1)
        {
            $this->ajaxReturn(array(
                'code' => 1,
                'msg' => '验证码发送成功',
            ));
            exit();
        }else
        {
            $this->ajaxReturn(array(
                'code' => 0,
                'msg' => '验证码发送失败',
            ));
            exit();
        }
        
       /*  $smsapi = "http://api.smsbao.com/";
        $user = "18645813623"; //短信平台帐号
        $pass = md5("895623147"); //短信平台密码
        $code = mt_rand(100000, 999999);
        $_SESSION[$mobile]=$code;
        $content='【名花有主】您的验证码为'.$code.'，请于5分钟内正确输入，如非本人操作，请忽略此短信';//"短信内容";//要发送的短信内容
        $phone = $mobile;//要发送短信的手机号码
        $sendurl = $smsapi."sms?u=".$user."&p=".$pass."&m=".$phone."&c=".urlencode($content);
        $result =file_get_contents($sendurl) ;
        file_put_contents(dirname(__FILE__).'/tian1.txt','getCode==>>result:'.print_r($result,1)."\r\n", FILE_APPEND);
        
        file_put_contents(dirname(__FILE__).'/tian1.txt','getCode==>>mobile:'.print_r($mobile,1)."\r\n", FILE_APPEND);
        file_put_contents(dirname(__FILE__).'/tian1.txt','getCode==>>mobile——code0:'.print_r($_SESSION[$mobile],1)."\r\n", FILE_APPEND);
        session($mobile,$code);
        file_put_contents(dirname(__FILE__).'/tian1.txt','getCode==>>mobile——code1:'.print_r( session($mobile),1)."\r\n", FILE_APPEND);
        $_COOKIE[$mobile]= $code;
        file_put_contents(dirname(__FILE__).'/tian1.txt','getCode==>>COOKIE——code1:'.print_r( $_COOKIE[$mobile],1)."\r\n", FILE_APPEND); */
        if($result==0){
            $this->ajaxReturn(array(
                'code' => 1,
                'msg' => '验证码发送成功',
            ));
            exit();
        }else{
            $this->ajaxReturn(array(
                'code' => 0,
                'msg' => '验证码发送失败',
            ));
            exit();
        }
    }
    public function getbankcardCode()
    {
        $mobile = trim(I('post.mobile'));
        # curl 请求登录接口
        $data = $this->_curlPost(array(
        'mobile' => $mobile,
        ),C('API_HOST').'/api.php/api/Login/getbankcardCode');    
        if($data['code']==1)
        {
            $this->ajaxReturn(array(
                'code' => 1,
                'msg' => '验证码发送成功',
            ));
            exit();
        }else
        {
            $this->ajaxReturn(array(
                'code' => 0,
                'msg' => '验证码发送失败',
            ));
            exit();
        }       
    }
    public function getuploginCode()
    {
         $mobile = trim(I('post.mobile'));
        # curl 请求登录接口
        $data = $this->_curlPost(array(
        'token' => session('token'),
        'mobile' => $mobile,
        ),C('API_HOST').'/api.php/api/Login/getuploginCode');
        if($data['code']==1)
        {
            $this->ajaxReturn(array(
                'code' => 1,
                'msg' => '验证码发送成功',
            ));
            exit();
        }else
        {
            $this->ajaxReturn(array(
                'code' => 0,
                'msg' => '验证码发送失败',
            ));
            exit();
        } 
    }
   public function getuptwoCode()
   {
        $mobile = trim(I('post.mobile'));
        # curl 请求登录接口
        $data = $this->_curlPost(array(
        'token' => session('token'),
        'mobile' => $mobile,
        ),C('API_HOST').'/api.php/api/Login/getuptwoCode');
        if($data['code']==1)
        {
            $this->ajaxReturn(array(
                'code' => 1,
                'msg' => '验证码发送成功',
            ));
            exit();
        }else
        {
            $this->ajaxReturn(array(
                'code' => 0,
                'msg' => '验证码发送失败',
            ));
            exit();
        } 
    }
    /**
     * 实现注册
     */
    public function doRegister()
    {
        $username = trim(I('post.username'));
        $mobile = trim(I('post.mobile'));
        $password = trim(I('post.password'));
        $paypassword = trim(I('post.paypassword'));
        $rename = trim(I('post.rename'));
        $code = trim(I('post.code'));
        $sendCode = trim(I('post.sendCode'));       
    

//        //验证码
//        $verify = new \Think\Verify();
//        if(! $verify->check($code, ''))
//        {
//            # 验证码不通过
//            $this->ajaxReturn(array(
//                'code' => 0,
//                'msg' => '验证码错误',
//            ));
//            exit();
//        }

        $data = $this->_curlPost(array(

            'username' => $username,
            'mobile' => $mobile,
            'password' => $password,
            'paypassword' => $paypassword,
            'rename' => $rename,
            'code' => $code,
            'sendCode' =>$sendCode,

        ),C('API_HOST').'/api.php/api/Login/register');

        if($data['code'])
        {
            $this->ajaxReturn(array(
                'code' => 1,
                'msg' => '注册成功',
            ));
            exit();
        }else
        {
            $this->ajaxReturn(array(
                'code' => 0,
                'msg' => $data['msg'],
            ));
            exit();
        }
    }

    /**
     * @param $post_data
     * @param $url
     * @return mixed
     */
    private function _curlPost($post_data,$url)
    {
        $data  = json_encode($post_data);
        $headerArray =array("Content-type:application/json;charset='utf-8'","Accept:application/json");
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,FALSE);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl,CURLOPT_HTTPHEADER,$headerArray);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return json_decode($output,true);
    }


}