<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NoteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'Id_Cliente' => $this->Id_Cliente,
            'Titulo' => $this->Titulo,
            'Fecha' => \Carbon\Carbon::parse($this->Fecha)->format('Y-m-d'),
            'Hora'=> \Carbon\Carbon::parse($this->Fecha)->format('H:i'),
            'Note' => $this->Note
        ];
    }
}
