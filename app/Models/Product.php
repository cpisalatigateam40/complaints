<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes, HasUuid;

    protected $table = "products";
    protected $primaryKey = "id";
    protected $fillable = [
        'uuid',
        'brand',
        'product_name',
        'nett_weight',
        'plant_uuid',
        'shelf_life'
    ];

    public function plant()
    {
        return $this->belongsTo(Plant::class, 'plant_uuid', 'uuid');
    }
}