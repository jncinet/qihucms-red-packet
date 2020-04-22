<?php

namespace Qihucms\RedPacket\Controllers\Admin;

use App\Plugins\Plugin;
use Encore\Admin\Widgets\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SettingForm extends Form
{
    /**
     * The form title.
     *
     * @var string
     */
    public $title = '红包配置';

    /**
     * Handle the form request.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request)
    {
        $data = $request->all();

        $message = '保存成功';

        $plugin = new Plugin();

        // 授权激活
        if ($request->has('red-packetLicenseKey') && Cache::get('red-packetLicenseKey') != $data['red-packetLicenseKey']) {
            $result = $plugin->registerPlugin('red-packet', $data['red-packetLicenseKey']);
            if ($result) {
                $message .= '；授权激活成功';
            } else {
                $message .= '；授权激活失败';
            }
        }

        unset($data['red-packetLicenseKey']);

        foreach ($data as $key => $value) {
            if ($request->hasFile($key)) {
                // 删除原文件
                if (Cache::get($key) && Storage::exists(Cache::get($key))) {
                    Storage::delete(Cache::get($key));
                }
                $file = $request->file($key);
                Cache::put($key, Storage::putFile('red-packet', $file));
            } else {
                Cache::put($key, $value);
            }
        }

        admin_success($message);

        return back();
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        $this->divider('基础');
        $this->radio('plugin_RedPacket_status', '是否启用红包')
            ->options(['关闭', '开启']);
        $this->checkbox('plugin_RedPacket_types', '红包类型')
            ->options(__('red_packet::lang.type.value'));
        $this->checkbox('plugin_RedPacket_money_types', '红包金额类型')
            ->options([
                'balance' => Cache::get('config_balance_alias', '余额') . '红包',
                'jewel' => Cache::get('config_jewel_alias', '钻石') . '红包',
                'integral' => Cache::get('config_integral_alias', '积分') . '红包',
            ]);
        $this->checkbox('plugin_RedPacket_rules', '普通会员红包效果')
            ->options(__('red_packet::lang.rule.value'));
        $this->checkbox('plugin_RedPacket_vip_rules', 'VIP会员红包效果')
            ->options(__('red_packet::lang.rule.value'));

        $this->divider('权重');
        $this->number('plugin_RedPacket_balance_pr', Cache::get('config_balance_alias', '余额') . '红包权重值')
            ->help('1' . Cache::get('config_balance_unit', '元') . '可以增加内容权重数，下同');
        $this->number('plugin_RedPacket_jewel_pr', Cache::get('config_jewel_alias', '钻石') . '红包权重值');
        $this->number('plugin_RedPacket_integral_pr', Cache::get('config_integral_alias', '积分') . '红包权重值');

        $this->divider('背景图片');
        $this->image('plugin_RedPacket_balance_bg', Cache::get('config_balance_alias', '余额') . '红包图')
            ->help('红包弹窗背景图片');
        $this->image('plugin_RedPacket_jewel_bg', Cache::get('config_jewel_alias', '余额') . '红包图');
        $this->image('plugin_RedPacket_integral_bg', Cache::get('config_integral_alias', '余额') . '红包图');

        $this->divider('服务费');
        $this->rate('plugin_RedPacket_balance_fee', Cache::get('config_balance_alias', '余额') . '红包服务费')
            ->help('会员发送红包时，服务费百分比');
        $this->rate('plugin_RedPacket_jewel_fee', Cache::get('config_jewel_alias', '余额') . '红包服务费');
        $this->rate('plugin_RedPacket_integral_fee', Cache::get('config_integral_alias', '余额') . '红包服务费');

        $this->divider('授权');
        $this->text('red-packetLicenseKey', '插件授权')
            ->help('购买授权地址：<a href="http://ka.qihucms.com/product/" target="_blank">http://ka.qihucms.com</a>');
    }

    /**
     * The data of the form.
     *
     * @return array $data
     */
    public function data()
    {
        return [
            'plugin_RedPacket_status' => Cache::get('plugin_RedPacket_status'),
            'plugin_RedPacket_types' => Cache::get('plugin_RedPacket_types'),
            'plugin_RedPacket_money_types' => Cache::get('plugin_RedPacket_money_types'),

            'plugin_RedPacket_rules' => Cache::get('plugin_RedPacket_rules'),
            'plugin_RedPacket_vip_rules' => Cache::get('plugin_RedPacket_vip_rules'),

            'plugin_RedPacket_balance_pr' => Cache::get('plugin_RedPacket_balance_pr'),
            'plugin_RedPacket_jewel_pr' => Cache::get('plugin_RedPacket_jewel_pr'),
            'plugin_RedPacket_integral_pr' => Cache::get('plugin_RedPacket_integral_pr'),

            'plugin_RedPacket_balance_bg' => Cache::get('plugin_RedPacket_balance_bg'),
            'plugin_RedPacket_jewel_bg' => Cache::get('plugin_RedPacket_jewel_bg'),
            'plugin_RedPacket_integral_bg' => Cache::get('plugin_RedPacket_integral_bg'),

            'plugin_RedPacket_balance_fee' => Cache::get('plugin_RedPacket_balance_fee'),
            'plugin_RedPacket_jewel_fee' => Cache::get('plugin_RedPacket_jewel_fee'),
            'plugin_RedPacket_integral_fee' => Cache::get('plugin_RedPacket_integral_fee'),

            'red-packetLicenseKey' => Cache::get('red-packetLicenseKey'),
        ];
    }
}
