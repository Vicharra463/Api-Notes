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

    public function store(NoteRequest $request )
    {
        try {
            $authUser = $request->user();
            $data = $request->only(['Titulo', 'Note']);
            $data['Id_Cliente'] = $authUser->id;
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

    public function index(Request $request)
    {
        try {
            $authUser = $request->user();
            $lista = $this->NoteServices->listar($authUser);
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
    public function showNotefromdate(Request $request){
        $userauth = $request->user();
        $res = $this->NoteServices->verporfecha($userauth, $request);
        return response()->json(
            [
                'Status' => 200,
                'nota' => "mostrada por fecha",
                'Data' => $res
            ]
        );
    }


    public function destroy(Request $request)
    {
         $userauth = $request->user();
         $id = $request->id_note;
        $data = $this->NoteServices->eliminar($id, $userauth);
        if (is_null($data)) {
            return response()->json([
                'Status' => 404,
                'Message' => 'Nota no encontrada'
            ]);
        }
        return response()->json($data);
    }

}
