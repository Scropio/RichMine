<?php
namespace app\admin\controller;
use app\admin\model\Users as UsersModel;
use app\api\model\Bankreceivables as BankreceivablesModel;
use think\facade\Hook;

class Users extends Common{
    //会员列表
    public function index(){
        if(request()->isPost()){
            $key=input('post.key');
            $page =input('page')?input('page'):1;
            $pageSize =input('limit')?input('limit'):config('pageSize');
            $list=db('users')->alias('u')
                ->join(config('database.prefix').'user_level ul','u.level = ul.level_id','left')
                ->field('u.*,ul.level_name')
                ->where('u.email|u.mobile|u.username','like',"%".$key."%")
                ->order('u.id desc')
                ->paginate(array('list_rows'=>$pageSize,'page'=>$page))
                ->toArray();
            foreach ($list['data'] as $k=>$v){
                $list['data'][$k]['reg_time'] = date('Y-m-d H:i',$v['reg_time']);
                $bankont=BankreceivablesModel::where('uid',$v['id'])->find();
                if($bankont){
                    $list['data'][$k]['mobile1'] = $bankont['mobile'];
                }else{
                    $list['data'][$k]['mobile1'] ='';
                }
            }
            return $result = ['code'=>0,'msg'=>'获取成功!','data'=>$list['data'],'count'=>$list['total'],'rel'=>1];
        }
        return $this->fetch();
    }
    //设置会员状态
    public function usersState(){
        $id=input('post.id');
        $is_lock=input('post.is_lock');
        if(db('users')->where('id='.$id)->update(['is_lock'=>$is_lock])!==false){
            if ($is_lock==0){
                db('users')->where('id',$id)->update([
                    'roll_check'=>0,
                    'lock_time'=>0,
                ]);
            }
            return ['status'=>1,'msg'=>'设置成功!'];
        }else{
            return ['status'=>0,'msg'=>'设置失败!'];
        }
    }

    /**
     * 会员激活
     */
    public function jh($id='')
    {
        $user = db('users');
        if ($user->where('id',(int)$id)->update(['active' => 1]))
        {
            # 激活成功
            return $result = ['code'=>1,'msg'=>'激活成功!'];
        }else
        {
            # 激活失败
            return $result = ['code'=>0,'msg'=>'激活成功!'];
        }
    }

    /**
     * 批量激活
     */
    public function plJH()
    {
        $map[] =array('id','IN',input('param.ids/a'));
        db('users')->where($map)->update(['active' => 1]);
        $result['msg'] = '激活成功！';
        $result['code'] = 1;
        $result['url'] = url('index');
        return $result;
    }

    /**
     * 一键激活
     */
    public function yjJH()
    {
        db('users')->where('id','>',0)->update(['active' => 1]);
        $result['msg'] = '激活成功！';
        $result['code'] = 1;
        $result['url'] = url('index');
        return $result;
    }

    /**
     * 批量审核
     */
    public function plSH()
    {
        $map[] =array('id','IN',input('param.ids/a'));
        db('users')->where($map)->update([
            'examine'=>2,
            'examine_agree_time'=>time(),
            'last_buy_time'=>time()
        ]);
        $result['msg'] = '审核成功！';
        $result['code'] = 1;
        $result['url'] = url('index');
        return $result;
    }


    public function edit($id=''){
        if(request()->isPost()){
            $user = db('users');
            $data = input('post.');
            $level =explode(':',$data['level']);
            $data['level'] = $level[1];
            $province =explode(':',$data['province']);
            $data['province'] = isset( $province[1])?$province[1]:'';
            $city =explode(':',$data['city']);
            $data['city'] = isset( $city[1])?$city[1]:'';
            $district =explode(':',$data['district']);
            $data['district'] = isset( $district[1])?$district[1]:'';
            if(empty($data['password'])){
                unset($data['password']);
            }else{
                $data['password'] = md5($data['password']);
            }
            if(empty($data['paypwd'])){
                unset($data['paypwd']);
            }else{
                $data['paypwd'] = md5($data['paypwd']);
            }
            if ($user->update($data)!==false) {
                $result['msg'] = '会员修改成功!';
                $result['url'] = url('index');
                $result['code'] = 1;
            } else {
                $result['msg'] = '会员修改失败!';
                $result['code'] = 0;
            }
            return $result;
        }else{
            $province = db('Region')->where ( array('pid'=>1) )->select ();
            $user_level=db('user_level')->order('sort')->select();
            $info = UsersModel::get($id);
            $this->assign('info',json_encode($info,true));
            $this->assign('title',lang('edit').lang('user'));
            $this->assign('province',json_encode($province,true));
            $this->assign('user_level',json_encode($user_level,true));

            $city = db('Region')->where ( array('pid'=>$info['province']) )->select ();
            $this->assign('city',json_encode($city,true));
            $district = db('Region')->where ( array('pid'=>$info['city']) )->select ();
            $this->assign('district',json_encode($district,true));
            return $this->fetch();
        }
    }

    public function getRegion(){
        $Region=db("region");
        $pid = input("pid");
        $arr = explode(':',$pid);
        $map['pid']=$arr[1];
        $list=$Region->where($map)->select();
        return $list;
    }

    public function usersDel(){
        db('users')->delete(['id'=>input('id')]);
        db('oauth')->delete(['uid'=>input('id')]);
        return $result = ['code'=>1,'msg'=>'删除成功!'];
    }
    public function delall(){
        $map[] =array('id','IN',input('param.ids/a'));
        db('users')->where($map)->delete();
        $result['msg'] = '删除成功！';
        $result['code'] = 1;
        $result['url'] = url('index');
        return $result;
    }

    /***********************************会员组***********************************/
    public function userGroup(){
        if(request()->isPost()){
            $userLevel=db('user_level');
            $list=$userLevel->order('sort')->select();
            return $result = ['code'=>0,'msg'=>'获取成功!','data'=>$list,'rel'=>1];
        }
        return $this->fetch();
    }
    public function groupAdd(){
        if(request()->isPost()){
            $data = input('post.');
            db('user_level')->insert($data);
            $result['msg'] = '会员组添加成功!';
            $result['url'] = url('userGroup');
            $result['code'] = 1;
            return $result;
        }else{
            $this->assign('title',lang('add')."会员组");
            $this->assign('info','null');
            return $this->fetch('groupForm');
        }
    }
    public function groupEdit(){
        if(request()->isPost()) {
            $data = input('post.');
            db('user_level')->update($data);
            $result['msg'] = '会员组修改成功!';
            $result['url'] = url('userGroup');
            $result['code'] = 1;
            return $result;
        }else{
            $map['level_id'] = input('param.level_id');
            $info = db('user_level')->where($map)->find();
            $this->assign('title',lang('edit')."会员组");
            $this->assign('info',json_encode($info,true));
            return $this->fetch('groupForm');
        }
    }
    public function groupDel(){
        $level_id=input('level_id');
        if (empty($level_id)){
            return ['code'=>0,'msg'=>'会员组ID不存在！'];
        }
        db('user_level')->where(array('level_id'=>$level_id))->delete();
        return ['code'=>1,'msg'=>'删除成功！'];
    }
    public function groupOrder(){
        $userLevel=db('user_level');
        $data = input('post.');
        $userLevel->update($data);
        $result['msg'] = '排序更新成功!';
        $result['url'] = url('userGroup');
        $result['code'] = 1;
        return $result;
    }
    public function check_personal_data(){
        if(request()->isPost()){
            $key=input('post.key');
            $page =input('page')?input('page'):1;
            $pageSize =input('limit')?input('limit'):config('pageSize');
            $list=db('users')
                ->where('examine','>=',1)
                ->where('realname|username','like',"%".$key."%")
                ->order('examine asc,id desc')
                ->paginate(array('list_rows'=>$pageSize,'page'=>$page))
                ->toArray();
            foreach ($list['data'] as $k=>$v){
                $list['data'][$k]['reg_time'] = date('Y-m-d H:i',$v['reg_time']);
                if ($v['examine_apply_time']>0){
                    $list['data'][$k]['examine_apply_time'] = date('Y-m-d H:i:s',$v['examine_apply_time']);
                }else{
                    $list['data'][$k]['examine_apply_time'] = '--';
                }
                if ($v['examine_agree_time']>0){
                    $list['data'][$k]['examine_agree_time'] = date('Y-m-d H:i:s',$v['examine_agree_time']);
                }else{
                    $list['data'][$k]['examine_agree_time'] = '--';
                }
                if ($v['examine'] == 0){
                    $list['data'][$k]['examine'] = '未申请';
                }
                if ($v['examine'] == 1){
                    $list['data'][$k]['examine'] = '申请中';
                }
                if ($v['examine'] == 2){
                    $list['data'][$k]['examine'] = '已审核';
                }
            }
            return $result = ['code'=>0,'msg'=>'获取成功!','data'=>$list['data'],'count'=>$list['total'],'rel'=>1];
        }
        return $this->fetch();
    }
    public function check_personal_save(){
        $id = input('id');
        $info = db('users')->where('id',$id)->field('id,examine,username')->find();
        if ($info['examine'] == 0)return $result = ['code'=>0,'msg'=>'该会员还未提交申请!'];
        if ($info['examine'] == 2)return $result = ['code'=>0,'msg'=>'该会员已审核成功，无需重复审核!'];
        db('users')->update([
            'id'=>input('id'),
            'examine'=>2,
            'examine_agree_time'=>time(),
            'last_buy_time'=>time()
        ]);
        Hook::add('SendSMS','app\\common\behavior\\SendSMS');
        $param_sell = [
            'mobile'        => $info['username'],
            'code'       => '',
            'templateID'    => 155502,
            'smsType'       => '聚合短信'
        ];
        Hook::listen('SendSMS',$param_sell);
        return $result = ['code'=>1,'msg'=>'审核成功!'];
    }
    public function set_power(){
        $id = input('id');
        $info = db('users')->where('id',$id)->field('id,currency_power')->find();
        if ($info['currency_power']==0){
            db('users')->update(['id'=>input('id'),'currency_power'=>1]);
            return $result = ['code'=>1,'msg'=>'开启成功!'];
        }
        if ($info['currency_power']==1){
            db('users')->update(['id'=>input('id'),'currency_power'=>0]);
            return $result = ['code'=>1,'msg'=>'关闭成功!'];
        }


    }
}