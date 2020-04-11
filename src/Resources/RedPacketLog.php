<?php

namespace Qihucms\RedPacket\Resources;

use App\Http\Resources\User\User;
use App\Models\UserFollow;
use App\Models\UserLikeVideo;
use App\Services\PhotoService;
use App\Services\ToolsService;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

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
            'desc' => $this->desc,
            'cover' => $cover,
            'src' => Storage::url($src),
            'tags' => $tags,
            'city' => $this->city,
            'link' => $this->link,
            'exif' => $this->exif,
            'heat' => $this->heat,
            'look' => $toolsService->format_number($this->look),
            'like' => $toolsService->format_number($this->like),
            'share' => $this->share,
            'comment' => $this->comment,
            'price' => $this->price,
            'remark' => $remark,
            'is_like' => UserLikeVideo::where('user_id', Auth::id())->where('short_video_id', $this->id)->where('status', 1)->exists()
        ];
    }
}
