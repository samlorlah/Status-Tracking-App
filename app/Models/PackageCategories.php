<?php

namespace App\Models;

use App\Models\ProductStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PackageCategories extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function  statuses() {
        return $this->hasMany(ProductStatus::class, 'package_category_id');
    }
}
