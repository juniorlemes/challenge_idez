<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\AccountPessoal;
use App\Models\AccountEmpresarial;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{

    const tipoContaPessoal = 1;
    const tipoContaEmpresarial = 2;

    function createPessoal(Request $request) {

        $regras = [
            'tipo_accounts' => 'required',
            'agencia' => 'required',
            'numero' => 'required',
            'cpf' => 'required|unique:accounts_pessoal,users',
            'nome' => 'required',
            'iduser' => 'unique:accounts_pessoal'
        ];
       $mensagens = [
            'tipo_accounts.required' => 'Informe o tipo da conta (Pessoal ou Empresarial)!',
            'agencia.required' => 'Informe a agência!',
            'numero.required' => 'Informe o número da conta!',
            'cpf.required' => 'Informe o CPF!',
            'cpf.unique' => 'O CPF informado já está cadastrado no sistema!',
            'nome.required' => 'Informe o nome!',
            'iduser.unique' => 'O usuário informado já possuí uma conta pessoal!'
       ];

        $request->validate($regras, $mensagens);


        $account = new Account();
        $account->tipo_accounts = $request->tipo_accounts;
        $account->agencia = $request->agencia;
        $account->numero = $request->numero;
        $account->digito = $request->digito;
        $account->save();

        $accountPessoal = new AccountPessoal();
        $accountPessoal->idaccount = $account->id;
        $accountPessoal->iduser = $request->user()->id;
        $accountPessoal->nome = $request->nome;
        $accountPessoal->cpf = somenteNumeros($request->cpf);
        $accountPessoal->save();

        return response()->json([
            'success' => 'Conta Pessoal criada com sucesso!'
        ]);


    }

    function createEmpresarial(Request $request) {

        $regras = [
            'tipo_accounts' => 'required|string',
            'agencia' => 'required|string',
            'numero' => 'required|string',
            'cnpj' => 'required|unique:accounts_empresarial,users',
            'nome_fantasia' => 'required|string',
            'razao_social' => 'required|string',
            'iduser' => 'unique:accounts_empresarial'
        ];
       $mensagens = [
            'tipo_accounts.required' => 'Informe o tipo da conta (Pessoal ou Empresarial)!',
            'agencia.required' => 'Informe a agência!',
            'numero.required' => 'Informe o número da conta!',
            'cnpj.required' => 'Informe o CNPJ!',
            'cnpj.unique' => 'O CNPJ informado já está cadastrado no sistema!',
            'nome_fantasia.required' => 'Informe o nome fantasia!',
            'razao_social.required' => 'Informe a razão social!',
            'iduser.unique' => 'O usuário informado já possuí uma conta empresarial!'
       ];

        $request->validate($regras, $mensagens);

        $account = new Account();
        $account->tipo_accounts = $request->tipo_accounts;
        $account->agencia = $request->agencia;
        $account->numero = $request->numero;
        $account->digito = $request->digito;
        $account->save();

        $accountEmpresarial = new AccountEmpresarial();
        $accountEmpresarial->idaccount = $account->id;
        $accountEmpresarial->iduser = $request->user()->id;
        $accountEmpresarial->razao_social = $request->razao_social;
        $accountEmpresarial->nome_fantasia = $request->nome_fantasia;
        $accountEmpresarial->cnpj = somenteNumeros($request->cnpj);
        $accountEmpresarial->save();

        return response()->json([
            'success' => 'Conta Empresarial criada com sucesso!'
        ]);
    }

    function listAccounts($id){



        $account = DB::table('accounts as a');
        $account->addSelect('a.id');
        $account->addSelect('a.tipo_accounts');
        $account->addSelect('a.agencia');
        $account->addSelect('a.numero');
        $account->addSelect('a.digito');

        if($id == self::tipoContaPessoal) {
            $account->addSelect('ap.nome');
            $account->addSelect('ap.cpf');
            $account->join('accounts_pessoal as ap', 'ap.idaccount','=','a.id');
        }

        if($id == self::tipoContaEmpresarial) {
            $account->addSelect('ae.nome_fantasia');
            $account->addSelect('ae.razao_social');
            $account->addSelect('ae.cnpj');
            $account->addSelect('u.*');
            $account->join('accounts_empresarial as ae', 'ae.idaccount','=','a.id');
            $account->join('users as u', 'u.id','=','ae.iduser')->dd();
        }




        $account->where('a.id', $id);




        $resultAccount = $account->get();

        return response()->json([
            'Resultado' => $resultAccount
        ]);
    }
}
