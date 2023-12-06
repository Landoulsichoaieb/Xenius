<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apply extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'offer_id',
        'status'
    ];
    public $timestamps = false;
    protected $primaryKey = 'id';
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}