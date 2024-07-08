<?php

namespace App\Exports;

use App\Models\Pembelian;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PembelianExport implements FromCollection, WithHeadings
{
    protected $pembelians;

    public function __construct($pembelians)
    {
        $this->pembelians = $pembelians;
    }

    public function collection()
    {
        // Menambahkan nomor urut ke dalam koleksi
        $pembeliansWithNumber = $this->pembelians->map(function ($item, $index) {
            return [
                'No' => $index + 1,
                'Kode Pembelian' => $item->kode_pembelian,
                'Tanggal Transaksi' => $item->tgl_transaksi,
                'Total Harga' => $item->total_harga,
            ];
        });

        return new Collection($pembeliansWithNumber);
    }

    public function headings(): array
    {
        return [
            'No',
            'Kode Pembelian',
            'Tanggal Transaksi',
            'Total Harga',
        ];
    }
}
