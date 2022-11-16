<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\TransectionFilter;

class Transection extends Model
{
    use TransectionFilter, HasFactory;
    protected $fillable = [
        'id','paidAmount','currency','parentEmail','statusCode','paymentDate','parentIdentification'
    ];


    public function user()
    {
        return $this->belongsTo('App\Models\User','parentEmail');
    }
}
