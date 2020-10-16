<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = ['resource_id', 'sender_id', 'receiver_id'];

    public function messages()
    {
        return $this->hasMany('App\Models\Messsage')
            ->orderBy('created_at', 'DESC');
    }
}
