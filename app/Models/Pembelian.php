<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Pembelian extends Model implements FromCollection, WithHeadings
{
    use HasFactory;
    protected $guarded = ['id'];

    public function detailPembelians()
    {
        return $this->hasMany(DetailPembelian::class, 'pembelian_id');
    }

    public function collection()
    {
        return $this->with('detailPembelians')->get()->map(function ($pembelian) {
            $items = $pembelian->detailPembelians->map(function ($detail) {
                return $detail->nama_item . ' (' . $detail->jumlah . ')';
            })->implode(', ');

            return [
                'id' => $pembelian->id,
                'cabang_id' => $pembelian->cabang_id,
                'tgl_transaksi' => $pembelian->tgl_transaksi,
                'total' => $pembelian->total,
                'items' => $items,
            ];
        });
    }

    public function headings(): array
    {
        return ['ID', 'Cabang ID', 'Tanggal Transaksi', 'Total', 'Items'];
    }
}
