<?php

namespace App\Models;

use App\Models\Admin;
use App\Models\ProductStatus;
use App\Models\ProductApplication;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ApplicationStatusGrid extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function application()
    {
        return $this->belongsTo(ProductApplication::class, 'application_id');
    }

    public function status()
    {
        return $this->belongsTo(ProductStatus::class, 'status_id');
    }
}
