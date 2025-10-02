<?php

namespace App\services;

use App\Models\Note;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Arr;

class NoteServices
{
   /**
    * Create a new class instance.
    */

   public function createdNota(array $data)
   {


      $res = Note::create([
         'Id_Cliente' => $data['Id_Cliente'],
         'Titulo' => $data['Titulo'],
         'Note' => $data['Note']
      ]);

      return $res;
   }

   public function listar($authUser)
   {
      $resp = Note::where('Id_Cliente', $authUser->id)->get();
      return $resp;
   }

   public function update($authUser, array $data)
   {
      $note = Note::find($data['id']);
      if (!$note) return ['status' => 404, 'message' => 'Note not found'];
      //busca el id del cliente con el find luego 
      //se compara el del auth con este
      if ($note->Id_Cliente !== $authUser->id) {
         return ['status' => 403, 'message' => 'Forbidden: Cannot update note of another user'];
      }
      unset($data['id']);
      $note->update($data);
      return ['status' => 200, 'message' => 'Note updated', 'note' => $note];
   }

public function verporfecha($userauth, $request)
{
    $query = Note::where('Id_Cliente', $userauth->id);

    if ($request->has(['from', 'to'])) {
        $query->whereBetween('Fecha', [$request->from, $request->to]);
    }

    if ($request->has('date')) {
        $query->whereDate('Fecha', $request->date);
    }

    return $query->get();
}

   public function eliminar($id,$userauth)
   {
      if (is_null($id)) {
         return response()->json([
            'status' => 401,
            'message' => 'id no valido'
         ]);
      }
      $verificar = Note::find($id);
          if(!$verificar){ 
        return null;
    }
      if($verificar->Id_Cliente !== $userauth->id){
          return ['status' => 403, 'message' => 'Forbidden: Cannot update note of another user'];
      }
       Note::destroy($id);


      return [
            'status' => 201,
            'message' => 'Nota eliminada'
        ];
   }
}
