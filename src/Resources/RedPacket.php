<?php

namespace Qihucms\RedPacket\Resources;

use App\Http\Resources\User\User;
use Carbon\Carbon;
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
            'user' => new User($this->user),
            'module_name' => $this->module_name,
            'module_name_text' => __('red_packet::lang.module_name.value')[$this->module_name],
            'module_id' => $this->module_id,
            'type' => $this->type,
            'type_text' => __('red_packet::lang.type.value')[$this->type],
            'money_type' => $this->money_type,
            'money_type_name' => __('red_packet::lang.money_type_name.' . $this->money_type),
            'money_type_unit' => __('red_packet::lang.money_type_unit.' . $this->money_type),
            'money_total' => $this->money_total,
            'amount' => $this->amount,
            'message' => $this->message,
            'rule' => $this->rule,
            'end_time' => $this->end_time,
            'status' => $this->status,
            'status_text' => __('red_packet::lang.status.value')[$this->status],
            'created_at' => Carbon::parse($this->created_at)->diffForHumans(),
            'log_count' => $this->log_count,
            'show_url' => route('plugin-red-packet.show', ['id' => $this->id])
        ];
    }
}
