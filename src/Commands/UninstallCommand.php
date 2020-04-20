<?php

namespace Qihucms\RedPacket\Commands;

use App\Plugins\Plugin;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Schema;

class UninstallCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'red-packet:uninstall';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Upgrade red packet plugin';

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
        // 清理REDIS
        Redis::del('rid:*');

        // 删除migrate记录
        DB::table('migrations')->where('migration', 'like', '%qihu_red_packets%_table')
            ->delete();

        // 删除表
        Schema::dropIfExists('qihu_red_packets');
        Schema::dropIfExists('qihu_red_packet_logs');

        // 删除菜单
        $root = DB::table('admin_menu')->where('uri', 'plugins/red-packet-config')
            ->value('parent_id');
        DB::table('admin_menu')->where('parent_id', $root)->orWhere('id', $root)->delete();

        // 清除插件缓存
        (new Plugin())->clearPluginCache('red-packet');

        $this->info('Uninstall successful.');
    }
}
