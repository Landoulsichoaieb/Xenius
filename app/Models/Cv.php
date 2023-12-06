<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cv extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'firstname',
        'lastname',
        'email',
        'phone',
        'about',
        'experience',
        'skills'
    ];
    public $timestamps = false;
    protected $primaryKey = 'id';
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
