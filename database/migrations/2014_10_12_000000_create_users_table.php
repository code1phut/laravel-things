<?php

use App\Enums\UserRoles;
use App\Enums\UserStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_name');
            $table->string('full_name');
            $table->string('phone_number')->nullable();
            $table->string('address', 255)->nullable();
            $table->string('avatar')->nullable();
            $table->string('role')->default(UserRoles::ADMIN);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('status')->default(UserStatus::ACTIVE);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes('banned_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
