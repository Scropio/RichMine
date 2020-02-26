<?php

namespace Home\Widget;

use Think\Controller;

class HeadWidget extends Controller
{
    public function index()
    {
        $this->display('Widget:head');
    }
}
