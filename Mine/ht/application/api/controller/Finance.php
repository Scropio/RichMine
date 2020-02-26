<?php
namespace app\api\controller;
use app\api\model\Users;
use app\api\model\History;
class Finance extends Common{

    public function initialize(){

    }
    public function flow(){
        $token = request()->post('token', '');
        if (!$token)return errorAjax('请登录',['data'=>[]]);
        $user_info = Users::where('token' , $token)->field('id')->find();
        if (!$user_info)return errorAjax('请登录',['data'=>[]]);
        $page = request()->post('page', 1);
        $page2 = request()->post('page2', 1);
        $list = History::where('uid',$user_info['id'])
            ->where('option','income')
            ->order('id desc')
            ->limit(100)
            ->page($page)
            ->select();
        foreach ($list as $key=>$value){
            switch ($list[$key]['type']){
                case 'aixinzhongzi':$list[$key]['type'] = '爱种子';
                    break;
                case 'aibi':$list[$key]['type'] = '爱心币';
                    break;
                case 'static_wallet':$list[$key]['type'] = '静态钱包';
                    break;
                case 'dynamic_wallet':$list[$key]['type'] = '动态钱包';
                    break;
            }
            $list[$key]['createtime'] = date('Y-m-d H:i:s',$list[$key]['createtime']);
        }
        $list2 = History::where('uid',$user_info['id'])
            ->where('option','expend')
            ->order('id desc')
            ->limit(100)
            ->page($page2)
            ->select();
        foreach ($list2 as $key=>$value){
            switch ($list2[$key]['type']){
                case 'aixinzhongzi':$list2[$key]['type'] = '爱种子';
                    break;
                case 'aibi':$list2[$key]['type'] = '爱心币';
                    break;
                case 'static_wallet':$list2[$key]['type'] = '静态钱包';
                    break;
                case 'dynamic_wallet':$list2[$key]['type'] = '动态钱包';
                    break;
            }
            $list2[$key]['createtime'] = date('Y-m-d H:i:s',$list2[$key]['createtime']);
        }
        return successAjax('数据获取成功',['data'=>$list,'page'=>$page,'data2'=>$list2,'page2'=>$page2]);
    }
}