<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToTransactionTable extends Migration
{
         /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transaction', function (Blueprint $table) {
            $table->foreign('idaccount', 'idtransaction_ibfk_1')->references('id')->on('accounts')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('idoperation', 'idoperation_ibfk_1')->references('id')->on('operation')->onUpdate('RESTRICT')->onDelete('RESTRICT');

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
            $table->dropForeign('idtransaction_ibfk_1');
            $table->dropForeign('idoperation_ibfk_1');
        });
        
    }
}
