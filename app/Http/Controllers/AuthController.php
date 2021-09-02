<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
/**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $regras = [
            'name' => 'required|string',
            'email' => 'required|unique:users|string|email',
            'cpf' => 'required|unique:users',
            'telefone' => 'required',
            'password' => 'required|min:6',
            'confirmPassword' => 'required|same:password'
        ];
       $mensagens = [
            'name.required' => 'Informe o "Nome campleto"!',
            'email.required' => 'Informe o e-mail!',
            'email.unique' => 'O e-mail informado já está cadastrado!',
            'email.email' => 'O e-mail informado é inválido!',
            'cpf.required' => 'Informe o CPF!',
            'cpf.unique' => 'O CPF informado já está cadastrado!',
            'password.required' => 'Informe a senha de acesso!',
            'password.min' => 'A senha deve ter no mínimo 6 caracteres!',
            'confirmPassword.required' => 'É necessário confirmar a senha!',
            'confirmPassword.same' => 'A senhas informadas não são iguais!'
       ];
       
        $request->validate($regras, $mensagens);     

        $user = new User();
        $user->name     = $request->name;
        $user->email    = $request->email;
        $user->cpf      = somenteNumeros($request->cpf);
        $user->telefone = $request->telefone;
        $user->password = bcrypt($request->password);
        $result = $user->save();

        if($result) {
            return response()->json([
                'success' => "Usuário cadastrado com sucesso!"
            ],201);
        } 
            return response()->json([
                'erro' => "Ocorreu um erro ao cadastrar o usuário."
            ]);        
    }

    public function login(Request $request) {

        $regras = [
            'email'    => 'required|string|email',
            'password' => 'required|string'
        ];
       $mensagens = [
            'email.required'    => 'Informe o e-mail!',
            'password.required' => 'Informe a senha de acesso!'
       ];
       
        $request->validate($regras, $mensagens);     

        $credenciais = [
            'email'    => $request->email,
            'password' => $request->password
        ];
    
        if(!Auth::attempt($credenciais)){
            return response()->json([
                'erro' => 'Acesso negado!'
            ],401);
        }

        $token = $request->user()->createToken('Auth Token')->accessToken;

        return response()->json([
            'user' => $request->user(),
            'token' => $token
        ],200);
    }

    public function logout(Request $request) {
        $user = $request->user()->token()->revoke();

        return response()->json([
            'success' => 'Usuário desconectado com sucesso!'
        ]);
    }
}
