<?php

namespace Qihucms\RedPacket\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Qihucms\RedPacket\Models\RedPacket;

class ViewController extends BaseController
{
    // 领取的红包
    public function getRedPacket()
    {
//        Redis::setex('id:1|m:short_video|mid:1=>amount', 10, 9);
//        Redis::set('id:1|m:short_video|mid:1=>money', 100);
//        Redis::decr('id:1|m:short_video|mid:1=>amount');
        $a = Redis::get('id:1|m:short_video|mid:1=>amount');
        $b = Redis::get('id:1|m:short_video|mid:1=>money');
        return $a . '-4-' . $b;
//        dd(Cache::get('plugin_RedPacket_money_types'));
//        dd(Cache::get('plugin_RedPacket_types'));
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