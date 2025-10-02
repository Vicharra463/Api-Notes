<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use App\services\AuthServices;
use Illuminate\Container\Attributes\Auth;

class AutController extends Controller
{
    protected $AuthServices;

    public function __construct(AuthServices $AuthServices)
    {
        $this->AuthServices = $AuthServices; 
    }
    public function Login(Request $request){
         $data = $request->only(['Correo','password']);
        $auth = $this->AuthServices->Login($data);
        if(is_null($auth)){
            return response()->json([
                'status' => 401,
                'Message' => 'Credenciales incorrectas'
            ]);
        }
        return response()->json([
            'status' => 200,
            'Message' => 'login exitoso',
            'data' => $auth
        ]);
    }

        public function logout(Request $request)
    {
        $user = $request->user(); 
        $data = $this->AuthServices->logout($user);

        return response()->json($data);
    }

}
