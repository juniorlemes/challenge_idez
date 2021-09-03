<?php

use Illuminate\Database\Seeder;
use App\Models\TipoAccount;

class TipoAccountsSeeder extends Seeder
{
    /**
     * Insere no banco os tipos de contas.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipo_account')->delete();
        TipoAccount::insert(['id' => 1, 'tipo' => 'Person', 'created_at' => date('Y-m-d H:i:s')]);
        TipoAccount::insert(['id' => 2, 'tipo' => 'Company', 'created_at' => date('Y-m-d H:i:s')]);
    }
}
