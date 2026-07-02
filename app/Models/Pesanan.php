<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pesanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'meja_id',
        'status',
        'total_harga',
    ];

    public function meja(): BelongsTo
    {
        return $this->belongsTo(Meja::class);
    }

    public function detailPesanans(): HasMany
    {
        return $this->hasMany(DetailPesanan::class);
    }

    public function produks(): BelongsToMany
    {
        return $this->belongsToMany(Produk::class, 'detail_pesanans')
                     ->withPivot('jumlah', 'subtotal');
    }
}
