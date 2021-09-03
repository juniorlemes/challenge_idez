<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsPessoalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts_pessoal', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('cpf')->unique();      
            $table->biginteger('idaccount')->unsigned();  
            $table->biginteger('iduser')->unsigned()->unique();    
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts_pessoal');
    }
}
