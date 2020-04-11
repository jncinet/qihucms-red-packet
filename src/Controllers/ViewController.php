<?php

namespace Qihucms\RedPacket\Controllers;

use Qihucms\RedPacket\Models\RedPacket;

class ViewController extends BaseController
{
    // 领取的红包
    public function getRedPacket()
    {
        $items = RedPacket::get();
        return view('red_packet::get', compact('items'));
    }

    // 发出的红包
    public function gotRedPacket()
    {
        $items = RedPacket::get();
        return view('red_packet::got', compact('items'));
    }

    // 红包详细
    public function show()
    {
        return view('red_packet::show');
    }
}