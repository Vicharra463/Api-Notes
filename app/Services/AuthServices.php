<?php

namespace App\services;

use App\Models\User;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class AuthServices
{
    /**
     * Create a new class instance.
     */
    public function Login(array $credentials){
      $datos = User::Where('Correo', $credentials['Correo'])->first();
      if(!$datos || !Hash::check($credentials['password'], $datos->password)){
          return null;
      }
      $token = $datos->createToken('auth_token')->plainTextToken;
      return [
         'Nombre'   => $datos->Nombre,
         'Correo'   => $datos->Correo,
         'Foto'     => $datos->Foto,
         'Telefono' => $datos->Telefono,
          'Token'   => $token
       ];
    }

       public function logout($user)
    {
        $user->currentAccessToken()->delete();

        return [
            'message' => 'Sesión cerrada correctamente'
        ];
    }
}
