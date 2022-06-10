<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class College extends Model
{
    use HasFactory;
    public $timestamp = false;
    protected $table = 'College';

    public function programs(){
        return $this->belongsToMany(Program::class, 'college_program', 'college_id', 'program_id');
    }
}
