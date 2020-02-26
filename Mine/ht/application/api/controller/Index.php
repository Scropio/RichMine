<?php
namespace app\api\controller;
class Index extends Common{
    public function initialize(){
        parent::initialize();
    }
    public function index(){
        $this->assign('title','会员中心');
        return $this->fetch();
    }
    public function app_update(){
        $updateUrl = 'http://'.$_SERVER['HTTP_HOST'].'/app.html';
        $appid = $_GET['appid'];
        $version = $_GET['version'];//客户端版本号
        $rsp = array('status' => 0);//默认返回值，不需要升级
        if (isset($appid) && isset($version)) {
//            if($appid == "__UNI__5EE4B69"){//校验appid
            //这里是示例代码，真实业务上，最新版本号及relase notes可以存储在数据库或文件中
            if($version !== "1.0.1"){
                $rsp['status'] = 1;
                $rsp['title'] = "发现新版本";
                $rsp['note'] = "- 优化用户体验\n- 修复已知体验问题";//release notes，支持换行
                $rsp['url'] = $updateUrl;//应用升级包下载地址
            }
//            }
        }
        exit(json_encode($rsp));
    }
   
}