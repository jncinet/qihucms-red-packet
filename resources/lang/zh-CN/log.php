<?php
return [
    'user_id' => '发送会员',
    'to_user_id' => '领取会员',
    'red_packet_id' => '红包详细',
    'money_type' => [
        'label' => '红包类型',
        'value' => [
            'balance' => cache('config_balance_alias') . '红包',
            'jewel' => cache('config_jewel_alias') . '红包',
            'integral' => cache('config_integral_alias') . '红包',
        ]
    ],
    'amount' => '领取金额',
    'remark' => '备注'
];