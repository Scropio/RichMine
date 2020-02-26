<?php

namespace Home\Widget;

use Think\Controller;

class BodyWidget extends Controller
{
    public function index()
    {
        $this->display('Widget:body');
    }
}
