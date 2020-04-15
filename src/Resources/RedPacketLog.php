<?php

namespace Qihucms\RedPacket\Resources;

use App\Http\Resources\User\User;
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
            'user_id' => new User($this->user),
            'to_user_id' => new User($this->to_user),
            'red_packet_id' => new RedPacket($this->red_packet),
            'amount' => $this->amount,
            'remark' => $this->remark
        ];
    }
}
