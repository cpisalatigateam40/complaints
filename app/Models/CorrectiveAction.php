<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CorrectiveAction extends Model
{
    use HasFactory;

    protected $table = "corrective_actions";
    protected $primaryKey = "id";
    protected $fillable = [
        'short_term_ca',
        'long_term_ca',
        'causative_factor',
        'complaint_uuid'
    ];

    public function complaint()
    {
        return $this->belongsTo(Complaint::class, 'complaint_uuid', 'uuid');
    }
}