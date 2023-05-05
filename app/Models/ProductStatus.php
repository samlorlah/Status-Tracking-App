<?php

namespace App\Models;

use App\Models\PackageCategories;
use App\Models\ApplicationStatusGrid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductStatus extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function programs() {
        return $this->belongsTo(PackageCategories::class, 'package_category_id');
    }

    public function status_grid()
    {
        return $this->hasMany(ApplicationStatusGrid::class, 'status_id');
    }
}
