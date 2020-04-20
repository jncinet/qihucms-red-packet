<?php

namespace Qihucms\RedPacket\Commands;

use App\Plugins\Plugin;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InstallCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'red-packet:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install red packet plugin';

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
        $plugin = new Plugin();

        if ($this->installedRedPacket()) {
            $this->info('Database table already exists');
        } else {
            // 数据库迁移
            $this->call('migrate');

            // 创建管理菜单
            $plugin->createPluginAdminMenu('红包管理', [
                ['title' => '红包设置', 'uri' => 'plugins/red-packet-config'],
                ['title' => '红包管理', 'uri' => 'plugins/red-packet-index'],
                ['title' => '红包日志', 'uri' => 'plugins/red-packet-log'],
            ]);

            // 缓存版本
            $plugin->setPluginVersion('red-packet', 100);

            $this->info('Install success');
        }
    }

    // 是否安装过
    protected function installedRedPacket()
    {
        // 验证表是否存在
        return Schema::hasTable('qihu_red_packets') || Schema::hasTable('qihu_red_packet_logs') || DB::table('migrations')->where('migration', 'like', '%qihu_red_packets_table')->exists();
    }
}
