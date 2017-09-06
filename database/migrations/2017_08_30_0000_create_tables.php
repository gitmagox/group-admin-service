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
        //权限表
        Schema::connection($connection)->create('admin_org', function (Blueprint $table) {
            $table->increments('id')->comment('ID');
            $table->string('name', 50)->unique()->comment('机构名');
            $table->string('domain', 50)->comment('机构域名');
            $table->string('slug', 60)->unique()->comment('机构标识');
            $this->timesopen($table);//生效
            $table->timestamps();
        });
        //后台用户表
        Schema::connection($connection)->create('admin_user', function (Blueprint $table) {
            $table->increments('id')->comment('ID');
            $table->unsignedInteger('org_id')->default(0)->comment('机构ID，默认为0平台方');
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
        //机构菜单表
        Schema::connection($connection)->create('admin_menu', function (Blueprint $table) {
            $table->increments('id')->comment('ID');
            $table->unsignedInteger('org_id')->default(0)->comment('机构ID，默认为0平台方');
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
            $table->unsignedInteger('org_id')->default(0)->comment('机构ID，默认为0平台方');
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

        //服务接口表
        Schema::connection($connection)->create('auth_service_api', function (Blueprint $table) {
            $table->increments('id')->comment('ID');
            $table->unsignedInteger('service_id')->comment('服务ID');
            $table->string('name', 50)->comment('接口名');
            $table->string('slug', 60)->unique()->comment('接口标识');
            $table->string('path', 190)->comment('接口地址');
            $table->timestamps();
        });
        //服务表
        Schema::connection($connection)->create('auth_service', function (Blueprint $table) {
            $table->increments('id')->comment('ID');
            $table->string('name', 50)->comment('服务名');
            $table->string('service_key', 100)->comment('服务密码');
            $table->string('slug', 60)->unique()->comment('服务标识');
            $table->string('remember_token', 100)->nullable()->comment('服务token');
            $table->timestamps();
        });
        //权限接口对应表
        Schema::connection($connection)->create('auth_service_api_permission', function (Blueprint $table) {
            $table->unsignedInteger('api_id')->comment('接口ID');
            $table->unsignedInteger('permission_id')->comment('权限ID');
            $table->timestamps();
        });

        //团队表
        Schema::connection($connection)->create('admin_org_team', function (Blueprint $table) {
            $table->increments('id')->comment('ID');
            $table->string('name', 50)->comment('团队名');
            $table->string('slug', 60)->unique()->comment('团队标识');
            $table->unsignedInteger('org_id')->comment('机构ID，默认为0平台方');
            $table->unsignedInteger('numbers')->default(0)->comment('团队人数,冗余字段');
            $table->boolean('status')->default(1)->comment('状态');
            $table->unsignedInteger('leader_id')->comment('团队负责人ID');
            $table->string('leader_name', 50)->comment('团队负责人姓名');
            $table->timestamps();
        });

        //团队成员
        Schema::connection($connection)->create('admin_team_seller', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->primary()->comment('用户ID');
            $table->unsignedInteger('team_id')->comment('团队ID');
            $table->string('seller_name', 50)->comment('成员名');
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
        Schema::connection($connection)->dropIfExists('admin_org');
        Schema::connection($connection)->dropIfExists('admin_user');
        Schema::connection($connection)->dropIfExists('admin_role_type');
        Schema::connection($connection)->dropIfExists('admin_role_user');
        Schema::connection($connection)->dropIfExists('admin_role');
        Schema::connection($connection)->dropIfExists('admin_menu');
        Schema::connection($connection)->dropIfExists('admin_role_menu');
        Schema::connection($connection)->dropIfExists('admin_permission');
        Schema::connection($connection)->dropIfExists('admin_role_permission');
        Schema::connection($connection)->dropIfExists('auth_service_api');
        Schema::connection($connection)->dropIfExists('auth_service');
        Schema::connection($connection)->dropIfExists('auth_service_api_permission');
        Schema::connection($connection)->dropIfExists('admin_org_team');
        Schema::connection($connection)->dropIfExists('admin_team_seller');
    }
}
