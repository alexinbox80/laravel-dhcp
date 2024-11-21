<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DhcpConfig extends Model
{
    use HasFactory;

    //protected $table = 'CAB_IP';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'CAB',
        'F',
        'I',
        'O',
        'COMP',
        'IP',
        'MAC',
        'INFO',
        'OLD_IP',
        'FLAG'
    ];
}
