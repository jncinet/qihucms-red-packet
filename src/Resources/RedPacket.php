<?php

namespace Qihucms\RedPacket\Resources;

use App\Http\Resources\User\User;
use Illuminate\Http\Resources\Json\JsonResource;

class RedPacket extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => new User($this->user),
            'module_name' => $this->module_name,
            'module_id' => $this->module_id,
            'type' => $this->type,
            'money_type' => $this->money_type,
            'money_total' => $this->money_total,
            'amount' => $this->amount,
            'message' => $this->message,
            'rule' => $this->rule,
            'end_time' => $this->end_time,
            'status' => $this->status,
            'status_text' => __('red_packet::lang.status.value')[$this->status]
        ];
    }
}
