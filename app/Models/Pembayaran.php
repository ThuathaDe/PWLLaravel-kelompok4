<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pembayaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'pesanan_id',
        'metode',
        'jumlah',
        'uang_dibayar',
        'uang_kembalian',
        'tanggal_bayar',
        'status_pembayaran',
    ];

    protected $casts = [
        'tanggal_bayar' => 'datetime',
    ];

    public function pesanan(): BelongsTo
    {
        return $this->belongsTo(Pesanan::class);
    }
}

