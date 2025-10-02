<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
     protected $table = 'note';
      public $timestamps = false;
    protected $fillable = [
        'Id_Cliente',
        'Titulo',
        'Note'
    ];

       public function user()
    {
        return $this->belongsTo(User::class, 'Id_Cliente');
    }
    
}
