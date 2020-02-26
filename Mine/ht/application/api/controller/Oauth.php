<?php
namespace app\api\controller;
use kuange\qqconnect\QC;
use think\Controller;
class Oauth extends Controller{
    public function qq()
    {
        $qc = new QC();
        return redirect($qc->qq_login());
    }

}