<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class motor_register extends Model
{
    protected $guarded = ['id'];
    protected $table = 'motor_registers';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
