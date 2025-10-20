<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory, HasUuid;

    protected $table = "complaints";
    protected $primaryKey = "id";
    protected $fillable = [
        'date',
        'product_arrival_date',
        'product_uuid',
        'production_code',
        'best_before',
        'complaint_amount',
        'nonconformity_type',
        'ncr',
        'complaint_documentation',
        'customer',
        'plant_uuid',
        'delivery',
        'status'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_uuid', 'uuid');
    }

    public function plant()
    {
        return $this->belongsTo(Plant::class, 'plant_uuid', 'uuid');
    }

    public function root_causes()
    {
        return $this->hasMany(RootCause::class, 'complaint_uuid', 'uuid');
    }

    public function corrective_actions()
    {
        return $this->hasMany(CorrectiveAction::class, 'complaint_uuid', 'uuid');
    }
}
