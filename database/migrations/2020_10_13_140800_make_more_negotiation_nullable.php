<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeMoreNegotiationNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('article_negotiations', function (Blueprint $table) {
            $table->string('amount')->unsigned()->nullable()->change();
            $table->string('status')->unsigned()->nullable()->change();
            $table->string('message')->unsigned()->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('article_negotiations', function (Blueprint $table) {
            //
        });
    }
}
