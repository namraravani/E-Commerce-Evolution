<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = [
        'image',
        'first_name',
        'last_name',
        'email',
        'mobileno',
        'address',
        'country',
        'state',
        'city',
        'pincode',
    ];
}
