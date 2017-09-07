<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $connection =  config('database.default');

        //后台用户表
        Schema::connection($connection)->create('admin_user', function (Blueprint $table) {
            $table->increments('id')->comment('ID');
            $table->string('username', 50)->nullable()->comment('用户名');
            $table->string('nikename', 50)->comment('用户昵称');
            $table->string('password', 100)->comment('密码');
            $table->string('name',50)->comment('姓名');
            $table->string('avatar')->nullable()->comment('头像');
            $table->string('mobile',50)->nullable()->comment('手机');
            $table->string('wx',50)->nullable()->comment('微信');
            $table->string('remember_token', 100)->nullable()->comment('token');
            $this->timesopen($table);//生效
            $table->string('invitation_code',50)->unique()->comment('唯一邀请码');
            $table->unsignedInteger('operator_id')->default(0)->comment('开户操作人');
            $table->timestamps();
        });
        //后台菜单表
        Schema::connection($connection)->create('admin_menu', function (Blueprint $table) {
            $table->increments('id')->comment('ID');
            $table->unsignedInteger('parent_id')->default(0)->comment('父菜单');
            $table->unsignedInteger('order')->default(0)->comment('排序');
            $table->string('title', 50)->comment('菜单标题');
            $table->string('icon', 50);
            $table->string('uri', 50);
            $table->timestamps();
        });
        //菜单角色表
        Schema::connection($connection)->create('admin_role_menu', function (Blueprint $table) {
            $table->unsignedInteger('role_id');
            $table->unsignedInteger('menu_id');
            $table->index(['role_id', 'menu_id']);
            $table->timestamps();
        });

        //角色表
        Schema::connection($connection)->create('admin_role', function (Blueprint $table) {
            $table->increments('id')->comment('ID');
            $table->string('name', 50)->comment('角色名');
            $table->string('slug', 60)->unique()->comment('角色标识');
            $table->timestamps();
        });
        //权限表
        Schema::connection($connection)->create('admin_permission', function (Blueprint $table) {
            $table->increments('id')->comment('ID');
            $table->string('name', 50)->comment('权限名');
            $table->string('slug', 60)->unique()->comment('权限标识');
            $table->timestamps();
        });

        //权限角色对应表
        Schema::connection($connection)->create('admin_role_permission', function (Blueprint $table) {
            $table->unsignedInteger('role_id')->comment('角色ID');
            $table->unsignedInteger('permission_id')->comment('角色ID');
            $table->index(['role_id', 'permission_id']);
            $table->timestamps();
        });
        //用户角色对应表
        Schema::connection($connection)->create('admin_role_user', function (Blueprint $table) {
            $table->unsignedInteger('role_id')->comment('角色ID');
            $table->unsignedInteger('user_id')->comment('用户ID');
            $table->index(['role_id', 'user_id']);
            $table->timestamps();
        });

    }
    /**
     * 生效开始时间，结束时间
     */
    public function timesopen(Blueprint $table)
    {
        $table->timestamp('begin_at')->nullable();
        $table->timestamp('end_at')->nullable();
        $table->boolean('status')->default(0)->comment('状态');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $connection = config('database.default');
        Schema::connection($connection)->dropIfExists('admin_user');
        Schema::connection($connection)->dropIfExists('admin_role_user');
        Schema::connection($connection)->dropIfExists('admin_role');
        Schema::connection($connection)->dropIfExists('admin_menu');
        Schema::connection($connection)->dropIfExists('admin_role_menu');
        Schema::connection($connection)->dropIfExists('admin_permission');
        Schema::connection($connection)->dropIfExists('admin_role_permission');
    }
}
