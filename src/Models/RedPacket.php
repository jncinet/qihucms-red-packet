<?php

namespace Qihucms\RedPacket\Models;

use Illuminate\Database\Eloquent\Model;

class RedPacket extends Model
{
    protected $table = 'qihu_red_packets';

    protected $fillable = [
        'user_id', 'module_name', 'module_id', 'type', 'money_type', 'money_total', 'amount',
        'is_fans', 'start_time', 'end_time'
    ];

    protected $casts = [
        'start_time' => 'datetime:Y-m-d',
        'end_time' => 'datetime:Y-m-d',
        'created_at' => 'datetime:Y-m-d',
        'updated_at' => 'datetime:Y-m-d',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
