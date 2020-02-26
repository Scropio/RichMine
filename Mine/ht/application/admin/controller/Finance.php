<?php
namespace app\admin\controller;
use think\db;
use app\admin\model\History;
class Finance extends Common{
    public function history(){
        if(request()->isPost()){
            $key=input('post.key');
            $page =input('page')?input('page'):1;
            $where = [];
            if ($key)$where[] = ['username','=',$key];
            $pageSize =input('limit')?input('limit'):config('pageSize');
            $list= History::where($where)->order('id desc')
                ->paginate(array('list_rows'=>$pageSize,'page'=>$page))
                ->toArray();
            foreach ($list['data'] as $k=>$v){
                $list['data'][$k]['createtime'] = date('Y-m-d H:i:s',$v['createtime']);
            }
            return $result = ['code'=>0,'msg'=>'获取成功!','data'=>$list['data'],'count'=>$list['total'],'rel'=>1];
        }
        return $this->fetch();
    }
}