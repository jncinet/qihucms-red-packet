<?php

namespace Qihucms\RedPacket\Models;

use Illuminate\Database\Eloquent\Model;

class RedPacketLog extends Model
{
    protected $table = 'qihu_red_packet_logs';

    protected $fillable = [
        'user_id', 'red_packet_id', 'amount'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
        'updated_at' => 'datetime:Y-m-d',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
