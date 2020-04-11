<?php

namespace Qihucms\RedPacket\Controllers;

use App\Http\Controllers\Controller;
use App\Plugins\Plugin;
use App\Plugins\RedPacketPlugin;

class BaseController extends Controller
{
    use Plugin, RedPacketPlugin;
}