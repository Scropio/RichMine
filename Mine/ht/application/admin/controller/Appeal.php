<?php
/**
 * Created by PhpStorm.
 * User: lzx
 * Date: 2019/7/16
 * Time: 10:17
 */

namespace app\admin\controller;
use think\Db;

class Appeal extends Common
{
    public function initialize(){
        parent::initialize();
    }
    public function index(){

        $data = DB::name('appeal')->order('time','desc')->paginate(100);

        $this->assign('data',$data);
        return $this->fetch();
    }

    public function status(){
        $id = input('id');

        $res = DB::name('appeal')->update(['id'=>$id,'status'=>1]);
        if($res){
            $this->success('处理成功');
        }else{
            $this->error('处理失败');
        }
    }
}