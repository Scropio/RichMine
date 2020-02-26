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
use think\db;
class SystemOpenTime
{

    /** 该钩子用于检测系统状态
     */
    public function run($param = [])
    {
//        $system_open_time  = explode('|',db('system_config')->where('name','system_open_time')->value('value'));
//        $today = strtotime(date('Y-m-d'));
//        if ( (time() < $today + $system_open_time[0]*3600) || (time() > $today+$system_open_time[1]*3600) || $system_open_time[2] != 0){
//            //全部会员踢出登录
//            db::name('users')->where('id','>',0)->setField('token',null);
//        }
    }
}
