<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Checkpoint extends Model
{
    protected $table = 'checkpoints';
    protected $primaryKey = 'id_checkpoint';
    protected $fillable = [
        'id_warga',
        'id_pos',
        'nama',
        'namaPos',
        'foto',
        'latitude_user',
        'longitude_user',
        'jarak_meter',
        'status_validasi',
    ];

    public function warga()
    {
        return $this->belongsTo(
            User::class,
            'id_warga',
            'id_warga'
        );
    }

    public function posjaga()
    {
        return $this->belongsTo(
            Posjaga::class,
            'id_pos',
            'id_pos'
        );
    }
}
