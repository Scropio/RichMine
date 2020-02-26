<?php

namespace app\admin\controller;
use think\Db;
use think\facade\Env;
use app\admin\model\Users as UsersModel;
class Index extends Common
{
    public function initialize(){
        parent::initialize();
    }
    public function index(){
        //导航
        // 获取缓存数据
        $authRule = cache('authRule');
        if(!$authRule){
            $authRule = db('auth_rule')->where('menustatus=1')->order('sort')->select();
            cache('authRule', $authRule, 3600);
       }
        //声明数组
       
        $menus = array();
        foreach ($authRule as $key=>$val){
            $authRule[$key]['href'] = url($val['href']);
            if($val['pid']==0){
                if(session('aid')!=1){
                    if(in_array($val['id'],$this->adminRules)){
                        $menus[] = $val;
                    }
                }else{
                    $menus[] = $val;
                }
            }
        }
        foreach ($menus as $k=>$v){
            foreach ($authRule as $kk=>$vv){
                if($v['id']==$vv['pid']){
                    if(session('aid')!=1) {
                        if (in_array($vv['id'], $this->adminRules)) {
                            $menus[$k]['children'][] = $vv;
                        }
                    }else{
                        $menus[$k]['children'][] = $vv;
                    }
                }
            }
        }
        $this->assign('menus',json_encode($menus,true));
        return $this->fetch();
    }
    public function main(){
        $version = Db::query('SELECT VERSION() AS ver');
        $config  = [
//            'url'             => $_SERVER['HTTP_HOST'],
//            'document_root'   => $_SERVER['DOCUMENT_ROOT'],
//            'server_os'       => PHP_OS,
//            'server_port'     => $_SERVER['SERVER_PORT'],
//            'server_ip'       => $_SERVER['SERVER_ADDR'],
//            'server_soft'     => $_SERVER['SERVER_SOFTWARE'],
//            'php_version'     => PHP_VERSION,
//            'mysql_version'   => $version[0]['ver'],
//            'max_upload_size' => ini_get('upload_max_filesize'),
//            'thinkphp_version'=> \think\facade\App::version(),

            'total_member'    => db::name('users')->count(),
            'today_new_add'   => db::name('users')->where('reg_time','>',strtotime(date('Y-m-d')))->count(),
            'unmatched_pay_money' => db::name('match')->where(['is_pay'=>0,'order_type'=>0])->sum('unmatched'),
            'unmatched_currency_money' => db::name('match')->where(['is_pay'=>0,'order_type'=>1])->sum('unmatched'),
            'today_pay_money' => db::name('match')->where([['order_type','=',0],['create_time','>',strtotime(date('Y-m-d'))]])->sum('money'),
            'today_currency_money' => db::name('match')->where([['order_type','=',1],['create_time','>',strtotime(date('Y-m-d'))]])->sum('money'),
        ];
        $this->assign('config', $config);
        return $this->fetch();
    }
    public function navbar(){
        return $this->fetch();
    }
    public function nav(){
        return $this->fetch();
    }
    public function clear(){
        $R = Env::get('runtime_path');
        if ($this->_deleteDir($R)) {
            $result['info'] = '清除缓存成功!';
            $result['status'] = 1;
        } else {
            $result['info'] = '清除缓存失败!';
            $result['status'] = 0;
        }
        $result['url'] = url('admin/index/index');
        return $result;
    }
    private function _deleteDir($R)
    {
        $handle = opendir($R);
        while (($item = readdir($handle)) !== false) {
            if ($item != '.' and $item != '..') {
                if (is_dir($R . '/' . $item)) {
                    $this->_deleteDir($R . '/' . $item);
                } else {
                    if (!unlink($R . '/' . $item))
                        die('error!');
                }
            }
        }
        closedir($handle);
        return rmdir($R);
    }

    //退出登陆
    public function logout(){
        session(null);
        $this->redirect('login/index');
    }
    public function delete_data(){
        //上线之后必须检查是否禁止该功能
//        die('ERROR');
//        db('admin')->where('admin_id',1)->update(['username'=>'admin','pwd'=>md5('123456')]);
//        db('admin')->where('admin_id','>',1)->delete();
//        db('article')->where('id','>',0)->delete();
//        db('chongzhi')->where('id','>',0)->delete();
//        db('dongjie')->where('id','>',0)->delete();
//        db('history')->where('id','>',0)->delete();
//        db('match')->where('id','>',0)->delete();
//        db('match2')->where('id','>',0)->delete();
//        db('mobile_code')->where('create_time','>',0)->delete();
//        db('history')->where('id','>',0)->delete();
//        db('system_history')->where('id','>',0)->delete();
//        db('user_match')->where('id','>',0)->delete();
//        db('xfhistory')->where('id','>',0)->delete();
//        db('users')->where('id','>',1)->delete();
//        db('users')->where('id',1)->update(['password'=>md5('123456'),'paypwd'=>md5('123456')]);
//
//        $this->success('操作成功');
    }
}
?>
