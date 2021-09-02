<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToAccountsEmpresarialTable extends Migration
{
        /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accounts_empresarial', function (Blueprint $table) {
            $table->foreign('idaccount', 'idaccounts_empresarial_ibfk_1')->references('id')->on('accounts')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('iduser', 'iduser_empresarial_ibfk_1')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('accounts_empresarial', function (Blueprint $table) {
            $table->dropForeign('idaccounts_empresarial_ibfk_1');
            $table->dropForeign('iduser_empresarial_ibfk_1');
            
        });
    }
}
