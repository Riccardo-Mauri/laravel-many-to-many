<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Technology extends Model
{
    use HasFactory;

    protected $fillable = ['name'];
    //relazione con i progetti
    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }
}
