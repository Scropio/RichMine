<?php
namespace app\admin\controller;

use Redis;
use think\Db;
use think\Request;

class Agent extends Common
{
    public function auth(Request $request)
    {
        # 查询所有的代理用户
        $userLevels = Db::table('clt_user_level')->order('sort','asc')->select();
        $this->assign('userLevels',$userLevels);

        if($request->isPost())
        {
            $level = (int)$request->param('level');

            $redis = new Redis();
            $redis->connect('127.0.0.1', 6379);

            switch ($level)
            {
                case 1:
                    $dai = 'firstDai';
                    break;

                case 2:
                    $dai = 'secondDai';
                    break;

                case 3:
                    $dai = 'thirdDai';
                    break;

                case 4:
                    $dai = 'forthDai';
                    break;

                case 7:
                    $dai = 'fifthDai';
                    break;
            }

            $data = $redis->lrange($dai,0,-1);

            foreach ($data as &$val)
            {
                $val = unserialize($val);
            }

            $this->assign('slug',1);
            $this->assign('data',$data);
            $this->assign('level',$level);
            $this->assign('title','查询管理');
            return $this->fetch();

        }else
        {
            $this->assign('level',1);
            $this->assign('slug',0);
            $this->assign('title','查询管理');
            return $this->fetch();
        }
    }


}