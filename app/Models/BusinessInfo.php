<?php

namespace App\Models;

use Database\Factories\BusinessInfoFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessInfo extends Model
{
    /** @use HasFactory<BusinessInfoFactory> */
    use HasFactory;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'company_name',
        'address',
        'phone',
        'email',
        'working_hours',
        'about',
        'facebook',
        'instagram',
        'whatsapp',
        'logo',
        'favicon',
    ];
}
