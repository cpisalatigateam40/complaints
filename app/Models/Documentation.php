<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documentation extends Model
{
    use HasFactory;

    protected $table = "root_causes";
    protected $primaryKey = "id";
    protected $fillable = [
        'documentation',
        'complaint_uuid'
    ];

    public function complaint()
    {
        return $this->belongsTo(Complaint::class, 'complaint_uuid', 'uuid');
    }
}
