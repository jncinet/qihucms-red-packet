<?php

namespace Qihucms\RedPacket\Resources;

use App\Http\Resources\User\User;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class RedPacketLog extends JsonResource
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
            'to_user' => new User($this->to_user),
            'red_packet' => new RedPacket($this->red_packet),
            'money_type' => $this->money_type,
            'money_type_text' => __('red_packet::log.money_type.' . $this->money_type),
            'amount' => $this->amount,
            'remark' => $this->remark,
            'created_at' => Carbon::parse($this->created_at)->diffForHumans()
        ];
    }
}
