<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Doctor extends Model
{
    //

    protected $fillable = ['name', 'email', 'specialty_id'];

    public function specialty() {
        return $this->belongsTo(Specialty::class);
    }
}
