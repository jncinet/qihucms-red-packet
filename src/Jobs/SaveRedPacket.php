<?php

namespace Qihucms\RedPacket\Jobs;

use App\Models\Comment;
use App\Models\ShortVideo;
use App\Models\User;
use App\Repositories\AccountRepository;
use App\Repositories\ShortVideoRepository;
use App\Repositories\UserRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Qihucms\RedPacket\Models\RedPacket;
use Qihucms\RedPacket\Models\RedPacketLog;

class SaveRedPacket implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new job instance.
     *
     * @param array $data
     * @return void
     */
    public function __construct($data = [])
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $redPacket = RedPacket::find($this->data['red_packet_id']);
        // 红包是否存在
        if ($redPacket) {
            // 领取记录不存在
            if (RedPacketLog::where('to_user_id', $this->data['to_user_id'])
                ->where('red_packet_id', $this->data['red_packet_id'])->doesntExist()) {
                // 入账操作
                $account = new AccountRepository();
                switch ($redPacket->money_type) {
                    case 'balance':
                        $account->updateBalance($this->data['to_user_id'], $this->data['money'], 'red_packet_get');
                        break;
                    case 'jewel':
                        $account->updateJewel($this->data['to_user_id'], $this->data['money'], 'red_packet_get');
                        break;
                    case 'integral':
                        $account->updateIntegral($this->data['to_user_id'], $this->data['money'], 'red_packet_get');
                        break;
                }

                // 后续操作
                if (is_array($redPacket->rule)) {
                    foreach ($redPacket->rule as $value) {
                        // 后续效果
                        switch ($value) {
                            // 点赞
                            case 'fans':
                                $user = User::find($this->data['to_user_id']);
                                if ($user) {
                                    $userRepository = new UserRepository($user);
                                    $userRepository->follow($user->id, $redPacket->user_id);
                                }
                                break;
                            case 'like':
                                if ($redPacket->module_name == 'short_video') {
                                    $short_video = ShortVideo::find($redPacket->module_id);
                                    $shortVideoRepository = new ShortVideoRepository($short_video);
                                    $shortVideoRepository->like($this->data['to_user_id'], $short_video->id);
                                }
                                break;
                            case 'comment':
                                if ($redPacket->module_name == 'short_video') {
                                    Comment::create([
                                        'content_type' => 'short_video',
                                        'content_id' => $redPacket->module_id,
                                        'to_user_id' => $redPacket->user_id,
                                        'user_id' => $this->data['to_user_id'],
                                        'content' => $redPacket->message,
                                        'status' => 1
                                    ]);
                                }
                                break;
                        }
                    }
                }

                // 日志入库
                RedPacketLog::create([
                    'user_id' => $redPacket->user_id,
                    'to_user_id' => $this->data['to_user_id'],
                    'red_packet_id' => $redPacket->id,
                    'money_type' => $redPacket->money_type,
                    'amount' => $this->data['money'],
                ]);
            }
        }
    }
}
