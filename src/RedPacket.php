<?php

namespace Qihucms\RedPacket;

class RedPacket
{
    /**
     * 计算红包金额
     *
     * @param int|float $money 红包金额
     * @param int $amount 红包数量
     * @param int $n 红包平均金额的倍数
     * @param int|float $min 最小金额
     * @return array
     */
    public function computeRedPacketAmount($money, int $amount, int $n = 2, $min = 1)
    {
        $isFloat = false;

        if (is_float($money)) {
            // 以分为单位取值
            $money = bcmul($money, 100);
            $min = bcmul($min, 100);
            $isFloat = true;
        }

        // 剩余一个红包
        if ($amount == 1) {
            $rp = $money;
        } else {
            // 预留最小金额，否则最后一个红包可能会空包
            $money -= $min;
            // 最多红包金额（红包平均值的N倍） = 红包总金额 / 剩余红包数 * N
            $max = bcdiv($money, $amount, 2) * $n;
            // 去掉小数位
            $max = bcmul($max, $n);
            // 因为上面的除法会忽略小数点，可能会出现0，所以最大值最低要等于最小红包金额
            $max = $max < $min ? $min : $max;
            // 区间随机
            $rp = mt_rand($min, $max);
            // 归还预留最小金额
            $money = $money + $min;
        }

        if ($isFloat) {
            $money = bcdiv($money, 100, 2);
            $rp = bcdiv($rp, 100, 2);
        }

        return [
            // 剩余金额
            'money' => $money - $rp,
            // 剩余数量
            'amount' => $amount - 1,
            // 当前红包金额
            'red_packet' => $rp
        ];
    }
}