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
            $table->string('icon');
            $table->unsignedInteger('arrangement');
            $table->timestamps();
            $table->unique(['name']);
        });

        Schema::create('menu_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('title');
            $table->string('route');
            $table->string('icon');
            $table->unsignedInteger('arrangement');
            $table->unsignedBigInteger('group_id');
            $table->timestamps();
            $table->unique(['name','route']);
            $table->foreign('group_id')
                ->references('id')
                ->on('menu_groups')
                ->onDelete('cascade');
        });

        Schema::create('menu_groups_permissions', function (Blueprint $table) {
            $table->unsignedBigInteger('group_id');
            $table->unsignedBigInteger('permission_id');

            $table->foreign('group_id')
                ->references('id')
                ->on('menu_groups')
                ->onDelete('cascade');

            $table->foreign('permission_id')
                ->references('id')
                ->on((new \Spatie\Permission\Models\Permission)->getTable())
                ->onDelete('cascade');

            $table->primary(['group_id','permission_id']);
        });

        Schema::create('menu_items_permissions', function (Blueprint $table) {
            $table->unsignedBigInteger('item_id');
            $table->unsignedBigInteger('permission_id');

            $table->foreign('item_id')
                ->references('id')
                ->on('menu_items')
                ->onDelete('cascade');

            $table->foreign('permission_id')
                ->references('id')
                ->on((new \Spatie\Permission\Models\Permission)->getTable())
                ->onDelete('cascade');

            $table->primary(['item_id','permission_id']);
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
