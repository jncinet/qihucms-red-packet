<?php

namespace Qihucms\RedPacket\Models;

use Illuminate\Database\Eloquent\Model;

class RedPacket extends Model
{
    protected $table = 'qihu_red_packets';

    protected $fillable = [
        'user_id', 'module_name', 'module_id', 'type', 'money_type', 'money_total', 'amount',
        'message', 'rule', 'start_time', 'end_time'
    ];

    protected $casts = [
        'start_time' => 'datetime:Y-m-d',
        'end_time' => 'datetime:Y-m-d',
        'created_at' => 'datetime:Y-m-d',
        'updated_at' => 'datetime:Y-m-d',
        'rule' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function log()
    {
        return $this->hasMany('Qihucms\RedPacket\Models\RedPacketLog', 'red_packet_id', 'id');
    }
}
