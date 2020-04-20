<?php

namespace Qihucms\RedPacket\Controllers;

use App\Http\Controllers\Controller;
use App\Plugins\RedPacketPlugin;

class BaseController extends Controller
{
    use RedPacketPlugin;

    public function __construct()
    {
        // 扩展文件和包版本不统一
        if ($this->pluginVersion() !== 100) {
            exit('页面不存在');
        }
    }
}