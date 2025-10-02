<?php

namespace App\Http\Controllers;

use App\Http\Requests\NoteRequest;
use App\Models\Note;
use App\Http\Resources\NoteResource;
use App\services\NoteServices;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    protected $NoteServices;

    public function __construct(NoteServices $NoteServices)
    {
        $this->NoteServices = $NoteServices;
    }

    public function store(NoteRequest $request)
    {
        try {
            $data = $request->only(['Id_Cliente', 'Titulo', 'Note']);
            $notecreate = $this->NoteServices->createdNota($data);
            return (new NoteResource($notecreate))->additional([
                'status' => 201,
                'message' => 'Nota creada correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 400,
                'response' => 'note  register error' . $e->getMessage(),
            ]);
        }
    }

    public function index()
    {
        try {
            $lista = $this->NoteServices->listar();
            return (NoteResource::collection($lista))->additional([
                'status' => 201,
                'message' => 'Lista Mostrada Correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 400,
                'response' => 'error obtent note' . $e->getMessage(),
            ]);
        }
    }

public function update(Request $request, $id)
{
    $authUser = $request->user();
    $data = $request->only(['Titulo','Note']);
    $data['id'] = $id;

    $res = $this->NoteServices->update($authUser, $data);
    return response()->json($res, $res['status']);
}


    public function show($fecha, $id)
    {
        $data = $this->NoteServices->show($fecha, $id);

        if ($data->isEmpty()) {
            return response()->json([
                'status'  => 404,
                'message' => 'Nota no encontrada'
            ]);
        }

        return response()->json([
            'status'  => 200,
            'message' => 'Notas mostradas correctamente',
            'Data' => $data
        ]);
    }

    public function destroy($id)
    {
        $data = $this->NoteServices->eliminar($id);
        if (is_null($data)) {
            return response()->json([
                'Status' => 404,
                'Message' => 'Nota no encontrada'
            ]);
        }
        return response()->json([
            'status' => 201,
            'message' => 'Nota eliminada'
        ]);
    }
}
