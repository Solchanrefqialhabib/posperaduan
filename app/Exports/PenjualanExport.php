<?php

namespace App\Exports;

use App\Models\Pembelian;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PenjualanExport implements FromCollection, WithHeadings
{
    protected $pembelians;

    public function __construct($pembelians)
    {
        $this->pembelians = $pembelians;
    }

    public function collection()
    {
        return $this->pembelians->map(function ($pembelian) {
            return [
                'kode_pembelian' => $pembelian->kode_pembelian,
                'total_harga' => $pembelian->total_harga,
                'Item' => $pembelian->detailPembelians->map(function ($detail) {
                    return $detail->nama . ' (' . $detail->quantity . ')';
                })->implode(', '),
                'tgl_transaksi' => $pembelian->tgl_transaksi,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Kode Pembelian',
            'Total Harga',
            'Item',
            'Tanggal Transaksi'
        ];
    }
}


