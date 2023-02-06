<?php

namespace App\Models\Sensor\Fingerprint;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FingerprintEntry extends Model
{
    use HasFactory;
    protected $table = 'fingerprint_entries';
    protected  $primaryKey = 'id_fingerprint_entry';

    protected $fillable = [
        'id_fingerprint_user'
    ];

    public function fingerprintUser()
    {
        return $this->belongsTo(FingerprintUser::class, 'id_fingerprint_user');
    }

    
}
