<?php
namespace app\admin\controller;
use think\Db;
use think\facade\Request;
class Cucurbita extends Common
{
    public function initialize(){
        parent::initialize();
    }
    //广告列表
    public function index(){
        if(Request::isAjax()) {
            $key = input('post.key');
            $this->assign('testkey', $key);
            $page =input('page')?input('page'):1;
            $pageSize =input('limit')?input('limit'):config('pageSize');
            $list = db('cucurbita')->where('title', 'like', "%" . $key . "%")
                ->order('id asc')
                ->paginate(array('list_rows'=>$pageSize,'page'=>$page))
                ->toArray();

            foreach ($list['data'] as $k=>$v){
                $list['data'][$k]['addtime'] = date('Y-m-d H:s',$v['addtime']);
            }

            return $result = ['code'=>0,'msg'=>'获取成功!','data'=>$list['data'],'count'=>$list['total'],'rel'=>1];
        }
        return $this->fetch();
    }
    public function add(){
        if(Request::isAjax()) {
            //构建数组
            $data = Request::except('file');
            $data['addtime'] = time();
            db('cucurbita')->insert($data);
            $result['code'] = 1;
            $result['msg'] = '添加成功!';
            cache('adList', NULL);
            $result['url'] = url('index');
            return $result;
        }else{
             $adtypeList=db('category')->where("catdir='news'")->order('id')->select();
            $this->assign('adtypeList',json_encode($adtypeList,true));

            $this->assign('title',lang('add').lang('花'));
            $this->assign('info','null');
            $this->assign('selected', 'null');
            return $this->fetch('form');
        }
    }
    public function edit(){
        if(Request::isAjax()) {
            $data = Request::except('file');
            db('cucurbita')->update($data);
            $result['code'] = 1;
            $result['msg'] = '修改成功!';
            cache('adList', NULL);
            $result['url'] = url('index');
            return $result;
        }else{
            $adtypeList=db('category')->where("catdir='news'")->order('id')->select();
            $id=input('id');
            $adInfo=db('cucurbita')->where(array('id'=>$id))->find();
            $this->assign('adtypeList',json_encode($adtypeList,true));
           
            $selected = db('category')->where('id',$adInfo['catid'])->where("catdir='news'")->find();
            $this->assign('selected',json_encode($selected,true));
            
            $this->assign('info',json_encode($adInfo,true));
            $this->assign('title',lang('edit').lang('花'));
            return $this->fetch('form');
        }
    }
    //设置广告状态

    public function del(){
        db('cucurbita')->where(array('id'=>input('id')))->delete();
        cache('adList', NULL);
        return ['code'=>1,'msg'=>'删除成功！'];
    }
    public function delall(){
        $map[] =array('id','in',input('param.ids/a'));
        
        db('cucurbita')->where($map)->delete();
        cache('adList', NULL);
        $result['msg'] = '删除成功！';
        $result['code'] = 1;
        $result['url'] = url('index');
        return $result;
    }

   
}