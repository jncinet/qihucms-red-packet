<?php

namespace Qihucms\RedPacket\Controllers;

use App\Http\Controllers\Controller;
use App\Plugins\RedPacketPlugin;

class BaseController extends Controller
{
    public function __construct()
    {
        // 扩展文件和包版本不统一
        if ((new RedPacketPlugin())->pluginVersion() !== 100) {
            exit('页面不存在');
        }
    }
}