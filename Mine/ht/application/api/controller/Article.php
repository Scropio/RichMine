<?php
namespace app\api\controller;
use app\api\model\Article as ArticleModel;
class Article extends Common{

    public function initialize(){

    }
    public function index(){
        $page = request()->post('page', 1);
        $list = ArticleModel::order('id desc')
            ->limit(100)
            ->page($page)
            ->select();
        foreach ($list as $key=>$value){
            $list[$key]['createtime'] = date('Y-m-d H:i:s',$list[$key]['createtime']);
        }

        return successAjax('内容已更新',['data'=>$list,'page'=>$page]);
    }
    public function details(){
        $newsid = request()->post('newsid', '');
        $token = request()->post('token', '');
        if ($token){
            db('users')->where('token' , $token)->setField('read_news',0);
        }
        $list = ArticleModel::get($newsid);
        $list['createtime'] = date('Y-m-d H:i:s',$list['createtime']);
        return successAjax('内容已更新',['data'=>$list]);
    }
}