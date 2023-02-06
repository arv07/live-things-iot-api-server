<?php

namespace App\Models\Sensor\Fingerprint;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FingerprintUser extends Model
{
    use HasFactory;

    protected $table = 'fingerprint_users';
    protected  $primaryKey = 'id_fingerprint_user';

    protected $fillable = [
        'name',
        'fingerprint_code',
        'state',
    ];

    public function fingerprintEntries()
    {
        return $this->hasMany(FingerprintEntry::class, 'id_fingerprint_user', 'id_fingerprint_user');
    }
}
