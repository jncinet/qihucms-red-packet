<?php

namespace Qihucms\RedPacket;

use Illuminate\Support\Facades\Log;
use Qihucms\RedPacket\Models\RedPacket as RedPacketModel;

class RedPacket
{
    // 发红包
    public function gotRedPacket($a = '')
    {
        Log::info(1);
        return RedPacketModel::create([]);
    }

    // 领红包
    public function getRedPacket($a = '')
    {
        return $a;
    }
}