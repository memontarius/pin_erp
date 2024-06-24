<?php

namespace App\Models;

use App\Enums\ProductStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $casts = [
        'status' => ProductStatus::class
    ];

    protected $fillable = [
        'article',
        'status',
        'name',
        'data'
    ];

    public function scopeAvailable(Builder $query) : void
    {
        $query->where('status', ProductStatus::Available);
    }
}
