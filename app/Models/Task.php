<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Ramsey\Uuid\Uuid;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_paket',
        'vendor',
        'jtm',
        'jtr',
        'gardu',
        'progres',
        'pengawas_k3',
        'koordinat',
        'dokumentasi',
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
}
