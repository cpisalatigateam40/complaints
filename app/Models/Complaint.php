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
        'product_name',
        'production_code',
        'best_before',
        'complaint_amount',
        'unit',
        'nonconformity_type',
        'ncr',
        'customer',
        'plant_uuid',
        'delivery',
        'status'
    ];

    protected $casts = [
        'date' => 'date',
        'product_arrival_date' => 'date',
        'best_before' => 'date',
    ];

    public function plant()
    {
        return $this->belongsTo(Plant::class, 'plant_uuid', 'uuid');
    }

    public function root_causes()
    {
        return $this->hasMany(RootCause::class, 'complaint_uuid', 'uuid');
    }

    public function corrective_action()
    {
        return $this->hasOne(CorrectiveAction::class, 'complaint_uuid', 'uuid');
    }
}
