<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');  
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');  
    }

}
