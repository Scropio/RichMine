<?php
namespace app\admin\controller;
use think\Db;
use think\facade\Request;
class Course extends Common
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
            $list = Db::table(config('database.prefix') . 'article')->alias('a')
                ->join(config('database.prefix').'category c','a.catid = c.id','left')
                ->field('a.id,a.title,a.createtime,c.catdir,c.catname')
                ->where('a.title', 'like', "%" . $key . "%")
                ->where('a.catid=7')
                ->order('a.createtime desc')
                ->paginate(array('list_rows'=>$pageSize,'page'=>$page))
                ->toArray();

            foreach ($list['data'] as $k=>$v){
                $list['data'][$k]['createtime'] = date('Y-m-d H:s',$v['createtime']);
            }

            return $result = ['code'=>0,'msg'=>'获取成功!','data'=>$list['data'],'count'=>$list['total'],'rel'=>1];
        }
        return $this->fetch();
    }
    public function add(){
        if(Request::isAjax()) {
            //构建数组
            $data = Request::except('file');
            $data['createtime'] = time();
            db('article')->insert($data);
            $result['code'] = 1;
            $result['msg'] = '添加成功!';
            cache('adList', NULL);
            $result['url'] = url('index');
            return $result;
        }else{
             $adtypeList=db('category')->where("catdir='course'")->order('id')->select();
            $this->assign('adtypeList',json_encode($adtypeList,true));

            $this->assign('title',lang('add').lang('article'));
            $this->assign('info','null');
            $this->assign('selected', 'null');
            return $this->fetch('form');
        }
    }
    public function edit(){
        if(Request::isAjax()) {
            $data = Request::except('file');
            db('article')->update($data);
            $result['code'] = 1;
            $result['msg'] = '修改成功!';
            cache('adList', NULL);
            $result['url'] = url('index');
            return $result;
        }else{
            $adtypeList=db('category')->where("catdir='course'")->order('id')->select();
            $id=input('id');
            $adInfo=db('article')->where(array('id'=>$id))->find();
            $this->assign('adtypeList',json_encode($adtypeList,true));
           
            $selected = db('category')->where('id',$adInfo['catid'])->where("catdir='course'")->find();
            $this->assign('selected',json_encode($selected,true));
            
            $this->assign('info',json_encode($adInfo,true));
            $this->assign('title',lang('edit').lang('article'));
            return $this->fetch('form');
        }
    }

    public function del(){
        db('article')->where(array('id'=>input('id')))->delete();
        cache('adList', NULL);
        return ['code'=>1,'msg'=>'删除成功！'];
    }
    public function delall(){
        $map[] =array('id','in',input('param.ids/a'));
        
        db('article')->where($map)->delete();
        cache('adList', NULL);
        $result['msg'] = '删除成功！';
        $result['code'] = 1;
        $result['url'] = url('index');
        return $result;
    }

    /***************************位置*****************************/
   
}