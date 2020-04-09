<?php

namespace Qihucms\RedPacket\Controllers;

use Qihucms\RedPacket\Models\RedPacket;

class HomeController extends BaseController
{
    public function index()
    {
        $items = RedPacket::get();
        return view('red_packet::hello', compact('items'));
    }
}