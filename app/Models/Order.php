<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public const STATUS_KREIRANA = 'KREIRANA';
    public const STATUS_PRIHVACENA = 'PRIHVACENA';
    public const STATUS_ODBIJENA = 'ODBIJENA';
    public const STATUS_U_PRIPREMI = 'U_PRIPREMI';
    public const STATUS_U_DOSTAVI = 'U_DOSTAVI';
    public const STATUS_DOSTAVLJENA = 'DOSTAVLJENA';
    public const STATUS_OTKAZANA = 'OTKAZANA';

    protected $fillable = [
        'user_id',
        'phone',
        'address',
        'note',
        'status',
        'total',
    ];

    protected $casts = [
        'total' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function statusLogs()
    {
        return $this->hasMany(OrderStatusLog::class);
    }
}

