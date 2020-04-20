<?php

namespace Qihucms\RedPacket\Commands;

use App\Plugins\RedPacketPlugin;
use Illuminate\Console\Command;

class UpdateRedPacketCommand extends Command
{
    use RedPacketPlugin;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'red-packet:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'update red packet status';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 清除过期缓存红包，删除缓存并退款到用发布人账户
     *
     * @return mixed
     */
    public function handle()
    {
        $this->clearOverdueRedPacket();

        $this->info('update success.');
    }
}
