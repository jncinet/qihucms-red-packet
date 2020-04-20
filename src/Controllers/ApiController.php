<?php

namespace Qihucms\RedPacket\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Qihucms\RedPacket\Models\RedPacket;
use Qihucms\RedPacket\Models\RedPacketLog;
use Qihucms\RedPacket\Resources\RedPacketCollection;
use Qihucms\RedPacket\Resources\RedPacketLogCollection;

class ApiController extends BaseController
{
    // 领红包
    public function getRedPacket(Request $request)
    {
        $items = $this->gettingRedPacket(Auth::id(), $request->input('module_name'), $request->input('module_id'));
        return response()->json($items);
    }

    // 领红包记录
    public function getLog()
    {
        $items = RedPacketLog::where('to_user_id', Auth::id())->latest()->paginate(15);
        return new RedPacketLogCollection($items);
    }

    // 发红包
    public function gotRedPacket(Request $request)
    {
        $result = $this->createRedPacket($request->all());
        if ($result['status'] == 'success') {
            return $this->successJson('发布成功', $result['data']);
        }
        return $this->errorJson($result['message']);
    }

    // 发红包记录
    public function gotLog()
    {
        $items = RedPacket::withCount('log')->where('user_id', Auth::id())->latest()->paginate(15);
        return new RedPacketCollection($items);
    }

    // 红包领取记录
    public function show($id)
    {
        $items = RedPacketLog::where('red_packet_id', $id)->latest()->paginate(15);
        return new RedPacketLogCollection($items);
    }
}