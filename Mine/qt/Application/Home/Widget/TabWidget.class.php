<?php

namespace Home\Widget;

use Think\Controller;

class TabWidget extends Controller
{
    public function index()
    {
        $this->display('Widget:index');
    }
}
