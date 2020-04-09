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
            $table->string('module_name')->index()->comment('所属模块');
            $table->unsignedBigInteger('module_id')->index()->comment('所属模块内容ID');
            $table->boolean('type')->default(0)->comment('红包类型');
            $table->string('money_type', 56)->index()->comment('红包金额类型');
            $table->unsignedDecimal('money_total', 56)->comment('红包总金额');
            $table->unsignedSmallInteger('amount')->default(0)->comment('红包数量');
            $table->boolean('is_fans')->default(0)->comment('是否粉丝可领取');
            $table->timestamp('start_time')->nullable()->comment('开始时间');
            $table->timestamp('end_time')->nullable()->comment('结速时间');
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
