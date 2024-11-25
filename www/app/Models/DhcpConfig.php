<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DhcpConfig extends Model
{
    use HasFactory;

    public $timestamps = false;

    //protected $table = 'CAB_IP';

    //make on db side
    //const CREATED_AT = 'DT_REG';
    //const UPDATED_AT = 'DT_UPD';

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
        'FLAG',
        'DT_REG',
        'DT_UPD'
    ];
}
