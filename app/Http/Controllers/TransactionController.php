<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Account;
use App\Models\Operation;

class TransactionController extends Controller
{

    /**
     * Cria uma transação
     */
    function createTransaction(Request $request) {

        $regras = [
            'idaccount' => 'required|integer',
            'idoperation' => 'required|integer',
            'valor' => 'required'
        ];
       $mensagens = [
            'idaccount.required' => 'O ID da conta não foi informado!',
            'idaccount.integer' => 'O valor informado para o ID da conta é inválido.',
            'idoperation.required' => 'O ID da operação não foi informado!',
            'idoperation.integer' => 'O valor informado para o ID da operação é inválido.',
            'valor.required' => 'Informe o valor da operação!'
       ];

        $request->validate($regras, $mensagens);

       $account = Account::find($request->idaccount);
       if(!isset($account)){
        return response()->json([
            'error' => 'A conta informada não existe. Verifique!'
        ],422);
    }
        $operation = Operation::find($request->idoperation);
        if(!isset($operation)){
            return response()->json([
                'error' => 'A operação informada não existe. Verifique!'
            ],422);
        }

        $transaction = new Transaction();
        $transaction->idaccount = $request->idaccount;
        $transaction->idoperation = $request->idoperation;
        $transaction->valor = formatarValor($request->valor);
        $transaction->save();

        return response()->json([
            'success' => 'Transação realizada com sucesso!'
        ],200);




    }
}
