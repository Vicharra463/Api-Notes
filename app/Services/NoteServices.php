<?php

namespace App\services;

use App\Models\Note;
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

   public function listar()
   {
      $resp = Note::all();
      return $resp;
   }

   public function show($fecha, $id)
   {
      if (is_null($fecha) and is_null($id)) {
         return null;
      }
      return Note::select('Note', 'Titulo', 'Fecha')
         ->whereDate('Fecha', $fecha)
         ->Where('Id_Cliente', $id)
         ->get();
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


   public function eliminar($id)
   {
      if (is_null($id)) {
         return response()->json([
            'status' => 401,
            'message' => 'id no valido'
         ]);
      }
      $data = Note::destroy($id);

      return $data;
   }
}
