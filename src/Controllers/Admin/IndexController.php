<?php

namespace Qihucms\RedPacket\Controllers\Admin;

use App\Admin\Controllers\Controller;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Qihucms\RedPacket\Models\RedPacket;

class IndexController extends Controller
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '红包管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new RedPacket);

        $grid->model()->latest();

        $grid->disableCreateButton();

        $grid->column('id', __('ID'))->sortable();
        $grid->column('user.username', __('user.username'));
        $grid->column('module_name', __('red_packet::lang.module_name.label'))
            ->using(__('red_packet::lang.module_name.value'));
        $grid->column('type', __('red_packet::lang.type.label'))
            ->using(__('red_packet::lang.type.value'));
        $grid->column('money_type', __('red_packet::lang.money_type'))->using([
            'balance' => Cache::get('config_balance_alias', '余额') . '红包',
            'jewel' => Cache::get('config_jewel_alias', '钻石') . '红包',
            'integral' => Cache::get('config_integral_alias', '积分') . '红包',
        ]);
        $grid->column('money_total', __('red_packet::lang.money_total'));
        $grid->column('amount', __('red_packet::lang.amount'))
            ->display(function () {
                if ($this->status == 1) {
                    return (Redis::get('rid:' . $this->module_name . '-' . $this->module_id . ':Amount') ?? 0) . '/' . $this->amount . '个';
                }
                return $this->amount . '个';
            });
        $grid->column('rule', __('red_packet::lang.rule.label'))
            ->using(__('red_packet::lang.rule.value'));
        $grid->column('end_time', __('red_packet::lang.end_time'));
        $grid->column('status', __('red_packet::lang.status.label'))
            ->using(__('red_packet::lang.status.value'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(RedPacket::findOrFail($id));

        $show->field('id', __('ID'));
        $show->field('user_id', __('user.id'));
        $show->field('module_name', __('red_packet::lang.module_name.label'))
            ->using(__('red_packet::lang.module_name.value'));
        $show->field('module_id', __('red_packet::lang.module_id'));
        $show->field('type', __('red_packet::lang.type.label'))
            ->using(__('red_packet::lang.type.value'));
        $show->field('money_type', __('red_packet::lang.money_type'))->using([
            'balance' => Cache::get('config_balance_alias', '余额') . '红包',
            'jewel' => Cache::get('config_jewel_alias', '钻石') . '红包',
            'integral' => Cache::get('config_integral_alias', '积分') . '红包',
        ]);
        $show->field('money_total', __('red_packet::lang.money_total'));
        $show->field('amount', __('red_packet::lang.amount'));
        $show->field('message', __('red_packet::lang.message'));
        $show->field('rule', __('red_packet::lang.rule.label'))
            ->using(__('red_packet::lang.rule.value'));
        $show->field('end_time', __('red_packet::lang.end_time'));
        $show->field('created_at', __('admin.created_at'));
        $show->field('updated_at', __('admin.updated_at'));

        $show->field('status', __('red_packet::lang.status.label'))
            ->using(__('red_packet::lang.status.value'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new RedPacket);

        $form->display('id', __('ID'));

        return $form;
    }
}
