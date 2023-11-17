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
        'nama_paket',
        'vendor_id',
        'jtm',
        'jtr',
        'gardu',
        'progres',
        'latitude',
        'longitude',
        'dokumentasi',
        'keterangan',
    ];

    protected static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::uuid4();
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
}
