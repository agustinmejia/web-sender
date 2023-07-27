<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'city_id', 'full_name', 'phone', 'address', 'email', 'birthday', 'observations', 'status'
    ];

    public function categories(){
        return $this->belongsToMany(Category::class, 'category_contact');
    }
}
