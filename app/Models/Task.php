<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Ramsey\Uuid\Uuid;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal',
        'nama_paket',
        'vendor_id',
        'target_jtm',
        'nilai_kontrak_jtm',
        'target_jtr',
        'nilai_kontrak_jtr',
        'target_gardu',
        'nilai_kontrak_gardu',
        'ongkos_angkut',
        'latitude',
        'longitude',
        'keterangan',
    ];

    protected static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::uuid4();
            $model->target_jtr = (float) str_replace(' km/s', '', $model->target_jtr);
            $model->nilai_kontrak_jtr = (int) str_replace(['Rp. ', '.'], '', $model->nilai_kontrak_jtr);
            $model->target_jtm = (float) str_replace(' km/s', '', $model->target_jtm);
            $model->nilai_kontrak_jtm = (int) str_replace(['Rp. ', '.'], '', $model->nilai_kontrak_jtm);
            $model->nilai_kontrak_gardu = (int) str_replace(['Rp. ', '.'], '', $model->nilai_kontrak_gardu);
            $model->ongkos_angkut = (int) str_replace(['Rp. ', '.'], '', $model->ongkos_angkut);
        });
    }

    public function documentations(): HasMany
    {
        return $this->hasMany(Documentation::class);
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function progress(): HasMany
    {
        return $this->hasMany(Progress::class);
    }
}
