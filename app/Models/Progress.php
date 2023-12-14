<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Ramsey\Uuid\Uuid;

class Progress extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'jtm',
        'jtr',
        'gardu',
    ];

    protected static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::uuid4();
            $model->jtr = (float) str_replace(' km/s', '', $model->jtr);
            $model->jtm = (float) str_replace(' km/s', '', $model->jtm);
        });
    }

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }
}
