<?php

namespace App\Services;

use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserService
{
    public function createUser(array $data)
    {
        try {
            return User::create([
                'Nombre'   => $data['Nombre'],
                'Correo'   => $data['Correo'],
                'Telefono' => $data['Telefono'],
                'Foto'     => $data['Foto'],
                'password' => Hash::make($data['password']),
            ]);
        } catch (\Exception $e) {
            return Null;
        }
    }
    public function listUser()
    {
        $res = User::all();

        if ($res->isEmpty()) {
            return null;
        }

        return $res;
    }

    public function buscar($id)
    {
        $res = User::find($id);
        if (is_null($res)) {
            $data = [
                'status' => '204',
                'response' => 'no data found'
            ];
            return $data;
        } else {
            $data = [
                'status' => '201',
                'response' => $res
            ];
            return $data;
        }
    }

    public function actualizar($authUser,array $data)
    {
        $user = User::find($data['id']);
        //valida la contaseña con Hash y la compara con la que se pide
        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response()->json([
                'status' => 401,
                'message' => 'Invalid credentials'
            ], 401);
        }

          if ($authUser->id !== $user->id) {
        return [
            'status' => 403,
            'message' => 'Forbidden: Cannot update another user'
        ];
    }

        unset($data['password']);
        $user->update($data);
        $user->refresh();
        return response()->json([
            'status' => 200,
            'response' => 'User update Succesful',
            'Data' => $user
        ]);
    }
}
