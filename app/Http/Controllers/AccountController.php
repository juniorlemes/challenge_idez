<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\AccountPessoal;
use App\Models\AccountEmpresarial;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{

    const tipoContaPessoal = 1;
    const tipoContaEmpresarial = 2;

    /**
     * Cria uma conta do tipo Pessoal (Person)
     */
    function createPessoal(Request $request) {

        $regras = [
            'agencia' => 'required',
            'numero' => 'required',
            'cpf' => 'required|unique:accounts_pessoal',
            'nome' => 'required',
            'iduser' => 'unique:accounts_pessoal'
        ];
       $mensagens = [
            'agencia.required' => 'Informe a agência!',
            'numero.required' => 'Informe o número da conta!',
            'cpf.required' => 'Informe o CPF!',
            'cpf.unique' => 'O CPF informado já está cadastrado no sistema!',
            'nome.required' => 'Informe o nome!',
            'iduser.unique' => 'O usuário informado já possuí uma conta pessoal!'
       ];

        $request->validate($regras, $mensagens);

        $user = User::find($request->iduser);
        if(!isset($user)){
         return response()->json([
             'error' => 'O usuário informado não existe. Verifique!'
         ],422);
        }

        $account = new Account();
        $account->idtipo_accounts = self::tipoContaPessoal;
        $account->agencia = $request->agencia;
        $account->numero = $request->numero;
        $account->digito = $request->digito;
        $account->save();

        $accountPessoal = new AccountPessoal();
        $accountPessoal->idaccount = $account->id;
        $accountPessoal->iduser = $request->iduser;
        $accountPessoal->nome = $request->nome;
        $accountPessoal->cpf = somenteNumeros($request->cpf);
        $accountPessoal->save();

        return response()->json([
            'success' => 'Conta Pessoal criada com sucesso!'
        ]);


    }

    /**
     * Cria uma conta do tipo Empresarial (Company)
     */
    function createEmpresarial(Request $request) {

        $regras = [
            'agencia' => 'required',
            'numero' => 'required',
            'cnpj' => 'required|unique:accounts_empresarial',
            'nome_fantasia' => 'required',
            'razao_social' => 'required',
            'iduser' => 'unique:accounts_empresarial'
        ];
       $mensagens = [
            'agencia.required' => 'Informe a agência!',
            'numero.required' => 'Informe o número da conta!',
            'cnpj.required' => 'Informe o CNPJ!',
            'cnpj.unique' => 'O CNPJ informado já está cadastrado no sistema!',
            'nome_fantasia.required' => 'Informe o nome fantasia!',
            'razao_social.required' => 'Informe a razão social!',
            'iduser.unique' => 'O usuário informado já possuí uma conta empresarial!'
       ];

        $request->validate($regras, $mensagens);

        $user = User::find($request->iduser);
        if(!isset($user)){
         return response()->json([
             'error' => 'O usuário informado não existe. Verifique!'
         ],422);
        }

        $account = new Account();
        $account->idtipo_accounts = self::tipoContaEmpresarial;
        $account->agencia = $request->agencia;
        $account->numero = $request->numero;
        $account->digito = $request->digito;
        $account->save();

        $accountEmpresarial = new AccountEmpresarial();
        $accountEmpresarial->idaccount = $account->id;
        $accountEmpresarial->iduser = $request->iduser;
        $accountEmpresarial->razao_social = $request->razao_social;
        $accountEmpresarial->nome_fantasia = $request->nome_fantasia;
        $accountEmpresarial->cnpj = somenteNumeros($request->cnpj);
        $accountEmpresarial->save();

        return response()->json([
            'success' => 'Conta Empresarial criada com sucesso!'
        ]);
    }

    /**
     * Lista a conta com usuários e transações
     * vinculados a ela
     * @param integer $id
     * @return json
     */
    function listAccounts($id){
        $account = DB::table('accounts as a');
        $account->join('tipo_account as ta', 'ta.id','=','a.idtipo_accounts');
        $account->addSelect('a.id');
        $account->addSelect('ta.id as idtipo');
        $account->addSelect('ta.tipo');
        $account->addSelect('a.agencia');
        $account->addSelect('a.numero');
        $account->addSelect('a.digito');
        $account->where('a.id', $id);

        $resultAccount = [];
        $resultAccount[$id] = $account->get();

        if($account->count() > 0){
            if($resultAccount[$id][0]->idtipo  == self::tipoContaPessoal) {
                $accountPessoal = DB::table('accounts_pessoal as ap');
                $accountPessoal->addSelect('ap.nome');
                $accountPessoal->addSelect('ap.cpf');
                $accountPessoal->where('ap.idaccount', $id);

                $resultAccount[$id]['Usuários'] = $accountPessoal->get();
            }

            if($resultAccount[$id][0]->idtipo == self::tipoContaEmpresarial) {
                $accountEmpresarial = DB::table('accounts_empresarial as ae');
                $accountEmpresarial->addSelect('ae.nome_fantasia');
                $accountEmpresarial->addSelect('ae.razao_social');
                $accountEmpresarial->addSelect('ae.cnpj');
                $accountEmpresarial->where('ae.idaccount', $id);
                $resultAccount[$id]['Usuários'] = $accountEmpresarial->get();
            }

            $transcaction = DB::table('transaction as t');
            $transcaction->join('operation as o', 'o.id', '=', 't.idoperation');
            $transcaction->addSelect('o.operation');
            $transcaction->addSelect('t.valor');
            $transcaction->addSelect('t.created_at');
            $transcaction->where('t.idaccount', $id);

            $resultAccount[$id]['Transações'] = $transcaction->get();

            return response()->json([
                'resposta' => $resultAccount
            ]);

        }

        return response()->json([
            'resposta' => 'Nenhuma conta encontrada!'
        ]);
    }
}
