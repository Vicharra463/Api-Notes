<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Json;

class UserController extends Controller
{
    protected $UserService;
    public function __construct(UserService $UserService)
    {
        $this->UserService = $UserService;
    }

    public function index()
    {
        $users = $this->UserService->listUser();
        if (!$users) {
            return response()->json([
                'status' => 204,
                'message' => 'No se pudo listar'
            ]);
        }
        return  UserResource::collection($users)->additional([
            'status' => 201,
            'message' => 'Lista Mostrada Correctamente'
        ]);;
    }

    public function store(UserRequest $request)
    {
        $data = $request->only(['Nombre', 'Correo', 'Telefono', 'Foto', 'password']);
        $user = $this->UserService->createUser($data);
        if (!$user) {
            return response()->json([
                'status' => 204,
                'message' => 'No se pudo Crear el usuario'
            ]);
        }
        return (new UserResource($user))
            ->additional([
                'status' => 201,
                'message' => 'Usuario creado correctamente'
            ]);
    }

    public function show($id) {
        return $this->UserService->buscar($id);
    }

    public function update(Request $request,$id) {
        //valida el token
        $authUser = $request->user();
        $data = $request->only(['Nombre', 'Correo', 'Telefono', 'Foto', 'password']);
        $data['id'] = $id; 
        return $this->UserService->actualizar($authUser, $data);
    }

    public function destroy($id) {

    }
}
