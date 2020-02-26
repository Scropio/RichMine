<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
namespace app\api\behavior;
use app\api\model\Users;
class CheckIsLock
{

    /** 该钩子用于踢出会员登录
     */
    public function run($param = [])
    {
        $user_info = Users::where('id',$param['uid'])->field('id,is_lock')->find();
        if ($user_info){
            if ($user_info['is_lock'] != 0)Users::where('id',$user_info['id'])->update(['token'=>'']);
        }
    }
}
