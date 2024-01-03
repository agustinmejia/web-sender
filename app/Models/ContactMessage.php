<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactMessage extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'server_id', 'contact_id', 'message_id', 'status'
    ];

    public function server(){
        return $this->belongsTo(Server::class);
    }

    public function message(){
        return $this->belongsTo(Message::class);
    }

    public function contact(){
        return $this->belongsTo(Contact::class);
    }
}
