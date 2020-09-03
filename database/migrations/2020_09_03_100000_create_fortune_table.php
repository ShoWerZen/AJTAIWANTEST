<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFortuneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fortune', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('astro_id');
            $table->date('dailyDate');
            $table->integer("overallStar");
            $table->integer("loveStar");
            $table->integer("careerStar");
            $table->integer("wealthStar");
            $table->longText("overallText");
            $table->longText("loveText");
            $table->longText("careerText");
            $table->longText("wealthText");
            $table->foreign('astro_id')->references('id')->on("astro")->onDelete('cascade');
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
        Schema::dropIfExists('fortune');
    }
}
