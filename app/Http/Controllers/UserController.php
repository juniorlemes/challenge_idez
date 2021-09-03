<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;



class UserController extends Controller
{

    public function listAll()
    {
        $user = User::all();
        return response()->json([
            'usuarios' => $user
        ],200);
    }

    public function list($param){
        $user = DB::table('users');
        $user->where(strtolower("name"), "LIKE", strtolower($param)."%" );
        if(somenteNumeros($param)){
            $user->orWhere('cpf', somenteNumeros($param));
        }
        if($user->count() > 0) {
            return response()->json([
                'resposta' => $user->get()
            ],200);
        }

        return response()->json([
            'resposta' => 'Nenhum usuário encontrado!'
        ]);
    }

}
