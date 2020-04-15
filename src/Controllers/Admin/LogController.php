<?php

namespace Qihucms\RedPacket\Controllers\Admin;

use App\Admin\Controllers\Controller;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Qihucms\RedPacket\Models\RedPacketLog;

class LogController extends Controller
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '红包日志';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new RedPacketLog);

        $grid->model()->latest();

        $grid->disableCreateButton();

        $grid->column('id', __('ID'))->sortable();
        $grid->column('user.username', __('red_packet::log.user_id'));
        $grid->column('to_user.username', __('red_packet::log.to_user_id'));
        $grid->column('amount', __('red_packet::log.amount'));
        $grid->column('remark', __('red_packet::log.remark'));
        $grid->column('created_at', __('admin.created_at'));
        $grid->column('updated_at', __('admin.updated_at'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed   $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(RedPacketLog::findOrFail($id));

        $show->field('id', __('ID'));
        $show->field('user_id', __('red_packet::log.user_id'));
        $show->field('to_user_id', __('red_packet::log.to_user.id'));
        $show->field('amount', __('red_packet::log.amount'));
        $show->field('remark', __('red_packet::log.remark'));
        $show->field('created_at', __('admin.created_at'));
        $show->field('updated_at', __('admin.updated_at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new RedPacketLog);

        $form->display('id', __('ID'));

        return $form;
    }
}
