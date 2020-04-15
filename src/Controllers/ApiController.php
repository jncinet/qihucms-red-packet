<?php

namespace Qihucms\RedPacket\Controllers;

use Illuminate\Http\Request;
use Qihucms\RedPacket\Models\RedPacket;

class ApiController extends BaseController
{
    // 领红包
    public function getRedPacket()
    {
        $items = RedPacket::get();
        return view('red_packet::get', compact('items'));
    }

    // 发红包
    public function gotRedPacket(Request $request)
    {
        $result = $this->createRedPacket($request->all());
        return $this->successJson('发送成功', $result);
    }

    // 红包详细
    public function show()
    {
        return view('red_packet::show');
    }
}