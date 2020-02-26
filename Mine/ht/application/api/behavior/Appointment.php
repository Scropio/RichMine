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
use app\api\model\SmsQueue;
use think\facade\Hook;
class Appointment
{

    /** 该钩子用于把预匹配的订单在匹配时间段内转为正常状态
     */
    public function run($param = [])
    {
        Hook::add('SendSMS','app\\common\behavior\\SendSMS');
        $time = time();
        //开始时间|结束时间|超时开始时间，在设定时间段内匹配将按照当前匹配时间计算超时，在非设定时间段内匹配则按照当天8点开始计算，超过则按明天8点，在匹配时间段内不可执行打款操作
        $match_time = explode('|',db::name('system_config')->where('name','match_time')->value('value'));
        $today = strtotime(date('Y-m-d'));
        if ( ($time > $today+$match_time[0]*3600) && ($time < $today+$match_time[1]*3600)){
            $cursor = Db::name('match')->where('appointment', 1)->field('id,username')->cursor();
            foreach($cursor as $value){
                $res = Db::name('match')->where('id',$value['id'])->update(['appointment'=>0]);
                if ($res){
                    $sms = SmsQueue::where('mobile',$res['username'])->field('id,mobile,template,smsType')->find();
                    if ($sms){
                        $param_buy = [
                            'mobile'        => $sms['mobile'],
                            'code'          => '',
                            'templateID'    => $sms['template'],
                            'smsType'       => $sms['smsType']
                        ];
                        Hook::listen('SendSMS',$param_buy);
                        SmsQueue::destroy($sms['id']);
                    }
                }
            }
            $cursor2 = Db::name('match2')->where('appointment', 1)->field('id')->cursor();
            foreach($cursor2 as $value){
                Db::name('match2')->where('id',$value['id'])->update(['appointment'=>0]);
            }
        }
    }
}
