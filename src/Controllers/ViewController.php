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
//        $money = 31;
//        $amount = 20;
//        $n = 2;
//        $min = 1;
//        $data = [
//            '总额' => $money,
//            '总数' => $amount,
//            '平均' => bcdiv($money, $amount),
//            '最小' => 1,
//            '最大' => bcdiv($money, $amount) * $n,
//            '合计' => 0,
//            '最后结果' => 0
//        ];
//        // 预留最小金额，保证最后一个红包的最小金额
//        $money -= $min;
//        for ($i = 0; $i < $amount; $i++) {
//            if ($amount - $i == 1) {
//                // 最后一个红包直接给所有剩余金额
//                $data[$i] = $money + $min;
//            } else {
//                // 最多红包金额（红包平均值的N倍） = 红包总金额 / 剩余红包数 * N
//                $max = bcdiv($money, $amount - $i) * $n;
//                // 因为上面的除法会忽略小数点，可能会出现0，所以最大值最低要等于最小红包金额
//                $max = $max < $min ? $min : $max;
//                // 实际领取的红包金额
//                $data[$i] = mt_rand($min, $max);
//            }
//            $data['最后结果'] = $money;
//            $data['合计'] += $data[$i];
//            // 更新当前红包总金额
//            $money -= $data[$i];
//        }
//        dd($data);
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