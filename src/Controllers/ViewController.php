<?php

namespace Qihucms\RedPacket\Controllers;

use Illuminate\Support\Facades\Auth;
use Qihucms\RedPacket\Models\RedPacket;
use Qihucms\RedPacket\Models\RedPacketLog;

class ViewController extends BaseController
{
    // 领取的红包
    public function getRedPacket()
    {
        $get_balance = RedPacketLog::where('to_user_id', Auth::id())->where('money_type', 'balance')->sum('amount');
        $get_jewel = RedPacketLog::where('to_user_id', Auth::id())->where('money_type', 'jewel')->sum('amount');
        $get_integral = RedPacketLog::where('to_user_id', Auth::id())->where('money_type', 'integral')->sum('amount');
        return view('red_packet::get', compact('get_balance', 'get_jewel', 'get_integral'));
    }

    // 发出的红包
    public function gotRedPacket()
    {
        $got_balance = RedPacketLog::where('user_id', Auth::id())->where('money_type', 'balance')->sum('amount');
        $got_jewel = RedPacketLog::where('user_id', Auth::id())->where('money_type', 'jewel')->sum('amount');
        $got_integral = RedPacketLog::where('user_id', Auth::id())->where('money_type', 'integral')->sum('amount');
        return view('red_packet::got', compact('got_balance', 'got_jewel', 'got_integral'));
    }

    // 红包详细
    public function show($id)
    {
        $red_packet = RedPacket::withCount('log')->findOrFail($id);
        return view('red_packet::show', compact('red_packet'));
    }
}