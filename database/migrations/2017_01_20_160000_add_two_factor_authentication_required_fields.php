<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTwoFactorAuthenticationRequiredFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(config('2fa-config.table'), function (Blueprint $table) {
            $table->smallInteger('is_two_factor_enabled')->nullable()->default(0)->before('created_at');
            $table->string('two_factor_provisioned_uri')->nullable()->after('is_two_factor_enabled');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(config('2fa-config.table'), function (Blueprint $table) {
            $table->dropColumn('is_two_factor_enabled');
            $table->dropColumn('two_factor_provisioned_uri');
        });
    }
}
