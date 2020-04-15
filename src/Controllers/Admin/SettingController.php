<?php

namespace Qihucms\RedPacket\Controllers\Admin;

use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    public function setting(Content $content)
    {
        return $content->title('红包设置')->body(new SettingForm());
    }
}
