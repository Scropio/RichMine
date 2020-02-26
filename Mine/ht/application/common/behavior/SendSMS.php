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
namespace app\common\behavior;

class SendSMS
{

    /** 该钩子用于发送短信
     * smsType 短信端口类型
     */
    public function run($param = [])
    {   
        $config = $this->systemConfig(['configName' => ['juhe_appkey', 'sign', 'sms_platform']]);
         
        switch ($param['smsType']) {
            case '聚合短信':
                $postData = [
                    'key' => $config['juhe_appkey'],          //您申请的APPKEY
                    'mobile' => $param['mobile'],       //接受短信的用户手机号码
                    'tpl_id' => $param['templateID'],    //您申请的短信模板ID，根据实际情况修改
                    'tpl_value' => '#code#=' . $param['code'], //您设置的模板变量随机数，根据实际情况修改
                ];
                $url = "http://v.juhe.cn/sms/send";
                break;
            case '合作短信':
                $sms_platform = explode('|',$config['sms_platform']);

               
                $postData = array
                (
                    'type' => 'send',
                    'username' => $sms_platform[0],
                    'password' => $sms_platform[2],
                    'gwid' => $sms_platform[1],
                    'mobile' => $param['mobile'],
                    'message' => '【'.$config['sign'].'】'.$param['content']
                );
                $url = "http://jk.106api.cn/smsUTF8.aspx";
                break;
            default:
                return true;
        }
        $row = parse_url($url);
        $host = $row['host'];
        $port = isset($row['port']) ? $row['port'] : 80;
        $file = $row['path'];
        $post = "";
        while (list($k, $v) = each($postData)) {
            $post .= rawurlencode($k) . "=" . rawurlencode($v) . "&";
        }
        $post = substr($post, 0, -1);
        $len = strlen($post);
        $fp = @fsockopen($host, $port, $errno, $errstr, 10);
        if (!$fp) {
            return "$errstr ($errno)\n";
        } else {
            $receive = '';
            $out = "POST $file HTTP/1.1\r\n";
            $out .= "Host: $host\r\n";
            $out .= "Content-type: application/x-www-form-urlencoded\r\n";
            $out .= "Connection: Close\r\n";
            $out .= "Content-Length: $len\r\n\r\n";
            $out .= $post;
            fwrite($fp, $out);
            while (!feof($fp)) {
                $receive .= fgets($fp, 128);
            }
            fclose($fp);
            $receive = explode("\r\n\r\n", $receive);
            unset($receive[0]);
            return implode("", $receive);
        }
    }
    public function systemConfig($param = [])
    {
        $dbConfig = db('system_config')
            ->where('name', 'in', $param['configName'])
            ->field('value,name')
            ->select();
        $config = [];
        foreach ($dbConfig as $v) {
            $config[$v['name']] = $v['value'];
        }
        return $config;
    }
}
