<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQihuRedPacketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qihu_red_packets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index()->comment('发布红包的会员');
            $table->unsignedBigInteger('module_id')->index()->comment('所属模块内容ID');
            $table->string('module_name', 56)->index()->comment('所属模块名称');
            $table->string('type', 56)->default('default')->comment('红包类型');
            $table->string('money_type', 56)->index()->comment('红包金额类型');
            $table->unsignedDecimal('money_total', 56)->comment('红包总金额');
            $table->unsignedSmallInteger('amount')->default(0)->comment('红包数量');
            $table->string('message')->nullable()->comment('消息');
            $table->json('rule')->nullable()->comment('可领取规则');
            $table->timestamp('end_time')->nullable()->comment('结束时间');
            $table->boolean('status')->default(1)->comment('状态');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('qihu_red_packets');
    }
}
