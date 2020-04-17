<?php
return [
    'module_id' => '模块ID',
    'module_name' => [
        'label' => '模块名称',
        'value' => [
            'video' => '长视频',
            'short_video' => '短视频',
            'article' => '文章',
            'mall' => '商城',
            'other' => '其它'
        ]
    ],
    'type' => [
        'label' => '红包类型',
        'value' => ['default' => '普通红包', 'random' => '拼手气红包']
    ],
    'money_type' => '红包金额类型',
    'money_total' => '红包金额',
    'amount' => '红包数量',
    'message' => '口令',
    'rule' => [
        'label' => '红包效果',
        'value' => [
            'fans' => '领取后自动关注发布者',
            'like' => '领取后自动点赞内容',
            'comment' => '领取后自动回复口令（发红包人自定义）',
        ]
    ],
    'end_time' => '过期时间',
    'status' => [
        'label' => '状态',
        'value' => ['已过期', '发放中']
    ]
];