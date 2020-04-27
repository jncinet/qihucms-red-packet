<?php

namespace Qihucms\RedPacket\Controllers;

use App\Plugins\RedPacketPlugin;
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
        $items = (new RedPacketPlugin())->gettingRedPacket(Auth::id(), $request->input('module_name'), $request->input('module_id'));
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
        $request->validate([
            'amount' => ['required', 'min:1'],
            'money_total' => ['required'],
            'money_type' => ['required', 'in:balance,jewel,integral'],
            'type' => ['required', 'in:default,random'],
            'module_name' => ['required', 'max:56'],
            'module_id' => ['required', 'numeric'],
        ], [
            'required' => ':attribute不能为空',
            'max' => ':attribute最多:max位',
            'min' => ':attribute最少:min位',
            'numeric' => ':attribute有效数字',
            'in' => ':attribute未选择',
        ], [
            'amount' => '红包数量',
            'money_total' => '红包金额',
            'money_type' => '红包类型',
            'type' => '红包类别',
            'module_name' => '所属模块',
            'module_id' => '模块ID',
        ]);
        $result = (new RedPacketPlugin())->createRedPacket($request->all());
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