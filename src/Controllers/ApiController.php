<?php

namespace Qihucms\RedPacket\Controllers;

use Illuminate\Http\Request;
use Qihucms\RedPacket\Models\RedPacket;

class ApiController extends BaseController
{
    // 领取的红包
    public function getRedPacket()
    {
        $items = RedPacket::get();
        return view('red_packet::get', compact('items'));
    }

    // 发出的红包
    public function gotRedPacket(Request $request)
    {
        $items = RedPacket::get();
        if ($request->isJson()) {

        }
        return view('red_packet::got', compact('items'));
    }

    // 红包详细
    public function show()
    {
        return view('red_packet::show');
    }
}