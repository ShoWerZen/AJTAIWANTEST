<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use \App\Astro;

class CreateAstroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('astro', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('birth');
            $table->timestamps();
        });

        $astro = config("astro");

        foreach ($astro as $item) {
            Astro::create($item);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('astro');
    }
}
