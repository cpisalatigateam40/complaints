<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RootCause extends Model
{
    use HasFactory;

    protected $table = "root_causes";
    protected $primaryKey = "id";
    protected $fillable = [
        'root_cause_name',
        'complaint_uuid'
    ];

    public function complaint()
    {
        return $this->belongsTo(Complaint::class, 'complaint_uuid', 'uuid');
    }
}
