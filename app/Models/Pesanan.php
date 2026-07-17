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
        'tanggal_pesan',
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

    // Total jumlah item (dijumlah dari semua baris DetailPesanan)
    public function getTotalItemAttribute(): int
    {
        return $this->detailPesanans->sum('jumlah');
    }

    // Estimasi lama pengerjaan dalam menit: 5 menit dasar + 2 menit per item
    public function getEstimasiMenitAttribute(): int
    {
        return 5 + ($this->totalItem * 2);
    }

    // Jam perkiraan pesanan selesai (waktu pesanan dibuat + estimasi menit)
    public function getWaktuEstimasiSelesaiAttribute()
    {
        return $this->created_at->addMinutes($this->estimasiMenit);
    }
}
