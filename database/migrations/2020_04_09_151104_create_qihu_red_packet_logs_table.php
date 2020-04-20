<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQihuRedPacketLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qihu_red_packet_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('red_packet_id')->index()->comment('红包ID');
            $table->unsignedBigInteger('user_id')->index()->comment('发送会员ID');
            $table->unsignedBigInteger('to_user_id')->index()->comment('领取会员ID');
            $table->string('money_type', 56)->comment('红包类型');
            $table->unsignedDecimal('amount')->comment('领取的金额');
            $table->string('remark')->nullable()->comment('备注');
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
        Schema::dropIfExists('qihu_red_packet_logs');
    }
}
