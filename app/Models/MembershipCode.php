<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class MembershipCode extends Model
{
    protected $table = 'membership_codes';
    public $timestamps = true;
    protected $fillable = [
        'membership_id',
        'membership_code',
        'used'
    ];
}
