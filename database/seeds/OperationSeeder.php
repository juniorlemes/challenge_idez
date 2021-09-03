<?php

use Illuminate\Database\Seeder;
use App\Models\Operation;

class OperationSeeder extends Seeder
{
    /**
     * Insere no banco os tipos de operações.
     *
     * @return void
     */
    public function run()
    {
        DB::table('operation')->delete();

        Operation::insert(['id' => 1, 'operation' => 'Pagamento de Conta', 'created_at' => date('Y-m-d H:i:s')]);
        Operation::insert(['id' => 2, 'operation' => 'Depósito', 'created_at' => date('Y-m-d H:i:s')]);
        Operation::insert(['id' => 3, 'operation' => 'Transferência', 'created_at' => date('Y-m-d H:i:s')]);
        Operation::insert(['id' => 4, 'operation' => 'Recarga de Celular', 'created_at' => date('Y-m-d H:i:s')]);
        Operation::insert(['id' => 5, 'operation' => 'Compra (Crédito)', 'created_at' => date('Y-m-d H:i:s')]);

    }

}
