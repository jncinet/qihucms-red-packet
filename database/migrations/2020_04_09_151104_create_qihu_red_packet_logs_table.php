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
            $table->unsignedBigInteger('user_id')->index()->comment('红包领取ID');
            $table->unsignedDecimal('amount')->comment('领取的金额');
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
