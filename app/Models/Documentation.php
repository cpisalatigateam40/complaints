<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documentation extends Model
{
    use HasFactory;

    protected $table = "documentations";
    protected $primaryKey = "id";
    protected $fillable = [
        'complaint_uuid',
        'filename',
        'path'
    ];

    public function complaint()
    {
        return $this->belongsTo(Complaint::class, 'complaint_uuid', 'uuid');
    }
}
