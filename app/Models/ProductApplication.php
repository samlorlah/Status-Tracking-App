<?php

namespace App\Models;

use App\Models\User;
use App\Models\ApplicationStatusGrid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductApplication extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function  user() {
        return $this->belongsTo(User::class);
    }

    public function status_grid()
    {
        return $this->hasMany(ApplicationStatusGrid::class, 'application_id');
    }
}
