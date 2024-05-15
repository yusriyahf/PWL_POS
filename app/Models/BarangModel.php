<?php

namespace App\Models;

use App\Models\KategoriModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;

class BarangModel extends Model
{
    use HasFactory;

    protected $table = 'm_barang';
    protected $primaryKey = 'barang_id';

    // protected $guarded = ['barang_id'];

    protected $fillable = ['barang_kode', 'kategori_id', 'barang_nama', 'harga_jual', 'harga_beli', 'image'];

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ($image) => url('/gambar/barang/' . $image),
        );
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriModel::class, 'kategori_id', 'kategori_id');
    }
}
