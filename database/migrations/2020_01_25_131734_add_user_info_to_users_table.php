<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserInfoToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name')->after('id');
            $table->string('last_name')->after('first_name')->nullable();
            $table->string('phone_no')->after('email')->nullable();
            $table->unsignedBigInteger('country_id')->nullable()->after('phone_no');
            $table->string('city')->nullable()->after('country_id');
            $table->string('street_address')->nullable()->after('city');
            $table->string('zip_code')->nullable()->after('street_address');
            $table->unsignedtinyInteger('is_admin')->default(0)->after('zip_code');
            $table->softDeletes();

            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
