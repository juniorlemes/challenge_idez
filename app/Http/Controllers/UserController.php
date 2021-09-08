<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;



class UserController extends Controller
{

    /**
     * Lista todos os usuários
     */
    public function listAll()
    {
        $user = User::all();
        return response()->json([
            'usuarios' => $user
        ],200);
    }

    /**
     * Lista um usuário passando o nome
     * ou número do documento
     */
    public function list($param){
        $user = DB::table('users');
        $user->where("name", "LIKE", strtolower($param)."%" );
        if(somenteNumeros($param)){
            $user->orWhere('cpf', somenteNumeros($param));
        }
        if($user->count() > 0) {
            return response()->json([
                'resposta' => $user->get()
            ],200);
        }

        return response()->json([
            'resposta' => 'Nenhum usuÃ¡rio encontrado!'
        ]);
    }

}
