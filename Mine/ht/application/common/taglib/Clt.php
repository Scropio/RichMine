<?php
namespace app\common\taglib;
use think\template\TagLib;
class Clt extends TagLib {
    protected $tags = array(
        // 标签定义： attr 属性列表 close 是否闭合（0 或者1 默认1） alias 标签别名 level 嵌套层次
        'close'     => ['attr' => 'time,format', 'close' => 0], //闭合标签，默认为不闭合
        'open'      => ['attr' => 'name,type', 'close' => 1],
        'listjoin' => array('attr' => 'db,joindb,order,limit,where,id,key,dbfield,joinfield','close' => 1),
        'list' => array('attr' => 'db,order,limit,where,id,key','close' => 1),
        'info' => array('attr' => 'db,where,id','close' => 1),
    );
    /**
     * 这是一个闭合标签的简单演示
     */
    public function tagClose($tag)
    {
        $format = empty($tag['format']) ? 'Y-m-d H:i:s' : $tag['format'];
        $time = empty($tag['time']) ? time() : $tag['time'];
        $parse = '<?php ';
        $parse .= 'echo date("' . $format . '",' . $time . ');';
        $parse .= ' ?>';
        return $parse;
    }

    /**
     * 这是一个非闭合标签的简单演示
     */
    public function tagOpen($tag, $content)
    {
        $type = empty($tag['type']) ? 0 : 1; // 这个type目的是为了区分类型，一般来源是数据库
        $name = $tag['name']; // name是必填项，这里不做判断了
        $parse = '<?php ';
        $parse .= '$test_arr=[[1,3,5,7,9],[2,4,6,8,10]];'; // 这里是模拟数据
        $parse .= '$__LIST__ = $test_arr[' . $type . '];';
        $parse .= ' ?>';
        $parse .= '{volist name="__LIST__" id="' . $name . '"}';
        $parse .= $content;
        $parse .= '{/volist}';
        return $parse;
    }
    public function tagInfo($attr,$content){
        $db = $attr['db']; //要查询的数据表
        $where = $attr['where']; //查询条件
        $id = $attr['id'];
        $str = '<?php ';
        $str .= '$'.$id.' =db("' . $db . '")->where("' . $where . '")->find();';
        $str .= '?>';
        $str .= $content;
        return $str;
    }
    public function tagListjoin($attr,$content) {
        $db = $attr['db']; //要查询的数据表
        $order = isset($attr['order'])?$attr['order']:'';    //排序
        $limit = isset($attr['limit'])?$attr['limit']:''; //多少条数据
        $where = isset($attr['where'])?$attr['where']:''; //查询条件
        $joindb = $attr['joindb']; //查询条件
        $dbfield = $attr['dbfield']; //查询条件
        $joinfield = $attr['joinfield']; //查询条件
        $id = $attr['id'];
        $key = isset($attr['key'])?$attr['key']:'k';
        $str = '<?php ';
        $str.='$result = db("'.$db.'")->alias("a")->join("'.config("database.prefix").$joindb.' c","a.'.$dbfield.' = c.'.$joinfield.'","left")
            ->where("'.$where.'")
            ->field("a.*,c.catdir,c.catname")
            ->limit('.$limit.')
            ->order("'.$order.'")
            ->select();';
        $str .= 'foreach ($result as $'.$key.'=>$'.$id.'):';
        $str .= '$result[$'.$key.']["time"]= toDate($'.$id.'["createtime"],"Y-m-d");';
        $str .= '$result[$'.$key.']["thumb"]= $'.$id.'["thumb"]?$'.$id.'["thumb"]:"";';
        $str .= '?>';
        $str .= '<?php endforeach; ?>';
        $str .= '<?php ';
        $str .= 'foreach ($result as $'.$key.'=>$'.$id.'):';
        $str .= '?>';
        $str .= $content;
        $str .= '<?php endforeach; ?>';
        /*$str .= '<?php dump($result);?>';*/
        return $str;
    }

    public function tagList($attr,$content) {
        $db = $attr['db']; //要查询的数据表
        $order = isset($attr['order'])?$attr['order']:'';    //排序
        $limit = isset($attr['limit'])?$attr['limit']:''; //多少条数据
        $where = isset($attr['where'])?$attr['where']:''; //查询条件
        $id = $attr['id'];
        $key = isset($attr['key'])?$attr['key']:'k';
        $str = '<?php ';
        $str.='$result = db("'.$db.'")->where("'.$where.'")->limit('.$limit.')->order("'.$order.'")->select();';

        $str .= 'foreach ($result as $'.$key.'=>$'.$id.'):';
        $str .='$result[$'.$key.']["time"]= isset($'.$id.'["createtime"])?toDate($'.$id.'["createtime"]):""';
        $str .= '?>';
        $str .= $content;
        $str .= '<?php endforeach?>';
        return $str;
    }



}