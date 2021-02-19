<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('title');
            $table->unsignedBigInteger('permission_id');
            $table->string('icon');
            $table->timestamps();
            $table->unique(['name']);
            $table->foreign('permission_id')
                ->references('id')
                ->on((new \Spatie\Permission\Models\Permission)->getTable())
                ->onDelete('cascade');
        });
        Schema::create('menu_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('title');
            $table->string('route');
            $table->unsignedBigInteger('permission_id');
            $table->string('icon');
            $table->unsignedBigInteger('group_id');
            $table->timestamps();
            $table->unique(['name','route']);
            $table->foreign('group_id')
                ->references('id')
                ->on('menu_groups')
                ->onDelete('cascade');
            $table->foreign('permission_id')
                ->references('id')
                ->on((new \Spatie\Permission\Models\Permission)->getTable())
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('menu_groups');
        Schema::drop('menu_items');
    }
}
