<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TodoImage extends Model
{
    protected $fillable = ['todo_id', 'path'];

    public function todo()
    {
        return $this->belongsTo(Todo::class);
    }
}
