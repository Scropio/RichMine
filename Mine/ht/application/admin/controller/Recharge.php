<?php
namespace app\admin\controller;
use think\db;
class Recharge extends Common{
    public function recharge(){
        $rechargeId = request()->post('rechargeId', '');
        $rechargeMoney = request()->post('rechargeMoney', '');
        $rechargeType = request()->post('rechargeType', '');

        if ( !$rechargeId )return ['code'=>0,'msg'=>'充值会员不能为空'];
        if ( !is_numeric($rechargeMoney) || $rechargeMoney==0 )return ['code'=>0,'msg'=>'充值金额不能为空'];
        $userInfo = Db::name('users')->where('id',$rechargeId)->field('id,username,aixinzhongzi')->find();
        if (!$userInfo)return ['code'=>0,'msg'=>'会员不存在'];

        Db::startTrans();
        try{
            switch ($rechargeType){
                case 'aixinzhongzi':
                    Db::name('users')->where('id', $userInfo['id'])->setInc('aixinzhongzi', $rechargeMoney);
                    $type = 'aixinzhongzi';
                    $remark = '系统充值爱心种子';
                    break;
                case 'aibi':
                    Db::name('users')->where('id', $userInfo['id'])->setInc('aibi', $rechargeMoney);
                    $type = 'aibi';
                    $remark = '系统充值爱心币';
                    break;
                case 'static_wallet':
                    Db::name('users')->where('id', $userInfo['id'])->setInc('static_wallet', $rechargeMoney);
                    $type = 'static_wallet';
                    $remark = '系统充值静态钱包';
                    break;
                case 'dynamic_wallet':
                    Db::name('users')->where('id', $userInfo['id'])->setInc('dynamic_wallet', $rechargeMoney);
                    $type = 'dynamic_wallet';
                    $remark = '系统充值静动态钱包';
                    break;
                default:return ['code'=>0,'msg'=>'类型有误'];
            }
            Db::name('chongzhi')->insert([
                'uid' => $userInfo['id'],
                'username' => $userInfo['username'],
                'type' => $type,
                'money' => $rechargeMoney,
                'createtime' => time(),
            ]);
            if ($rechargeMoney>0){
                $option = 'income';
            }else{
                $option = 'expend';
            }
            Db::name('history')->insert([
                'uid' => $userInfo['id'],
                'username' => $userInfo['username'],
                'money' => $rechargeMoney,
                'type' => $type,
                'remark' => $remark,
                'createtime' => time(),
                'option' => $option,
            ]);
            Db::commit();
            return ['code'=>1,'msg'=>'充值成功'];
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            return ['code'=>0,'msg'=>$e->getMessage()];
        }

    }
}