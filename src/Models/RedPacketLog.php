<?php

namespace Qihucms\RedPacket\Models;

use Illuminate\Database\Eloquent\Model;

class RedPacketLog extends Model
{
    protected $table = 'qihu_red_packet_logs';

    protected $fillable = [
        'user_id', 'to_user_id', 'red_packet_id', 'money_type', 'amount', 'remark'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
        'updated_at' => 'datetime:Y-m-d',
    ];

    public function red_packet()
    {
        return $this->belongsTo('Qihucms\RedPacket\Models\RedPacket', 'red_packet_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function to_user()
    {
        return $this->belongsTo('App\Models\User', 'to_user_id', 'id');
    }
}
