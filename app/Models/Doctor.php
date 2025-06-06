<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'specialty_id', 'user_id'];

    public function specialty() {
        return $this->belongsTo(Specialty::class);
    }
}

