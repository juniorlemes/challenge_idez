<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToAccountsPessoalTable extends Migration
{
          /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accounts_pessoal', function (Blueprint $table) {
            $table->foreign('idaccount', 'idaccounts_pessoal_ibfk_1')->references('id')->on('accounts')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('iduser', 'iduser_pessoal_ibfk_1')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('accounts_pessoal', function (Blueprint $table) {
            $table->dropForeign('idaccounts_pessoal_ibfk_1');
            $table->dropForeign('iduser_pessoal_ibfk_1');
        });
        
    }
}
