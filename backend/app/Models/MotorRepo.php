<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MotorRepo extends Model
{
    protected $guarded = ['id'];
    protected $table = 'motor_repos';
    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        return $this->image ? url('storage/' . $this->image) : null;
    }
}
