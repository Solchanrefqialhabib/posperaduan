<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{

    public function index()
    {
        $user = auth()->user();
        if ($user->role->role === 'administrator' || $user->role->role === 'kepala restoran') {
            $cabang = Cabang::all();
        } else {
            $cabang = Cabang::where('id', auth()->user()->cabang_id)->get();
        }

        return view('produk.index', [
            'cabangs'   => $cabang
        ]);
    }

    public function getData()
    {
        $user = auth()->user();
        if ($user->role->role === 'administrator' || $user->role->role === 'kepala restoran') {
            $produk = Produk::with('cabang')->orderBy('id', 'DESC')->get();
        } else {
            $produk = Produk::with('cabang')->where('cabang_id', auth()->user()->cabang_id)->orderBy('id', 'DESC')->get();
        }

        return response()->json([
            'success'   => true,
            'data'      => $produk
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('produk.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'gambar'       => 'required|mimes:jpeg,jpg,png',
            'kode_produk'  => 'required',
            'nama_produk'  => 'required',
            'hpp'          => 'required',
            'harga_jual'   => 'required',
            'stok'         => 'required',
            'kategori_id'  => 'required',
            'cabang_id'    => 'required'
        ], [
            'gambar.required'        => 'Tambahkan Gambar !',
            'gambar.mimes'           => 'Gunakan Gambar Yang Memiliki Format jpeg, png, jpg !',
            'kode_produk.required'   => 'Form Kode produk Wajib Di Isi !',
            'nama_produk.required'   => 'Form Nama produk Wajib Di Isi !',
            'hpp'                    => 'Form HPP Wajib Di Isi !',
            'harga_jual'             => 'Tambahkan Harga Jual !',
            'stok'                   => 'Form Stok Wajib Di Isi !',
            'kategori_id'            => 'Pilih Kategori !',
            'cabang_id'              => 'Pilih Cabang !'
        ]);

        if ($request->hasFile('gambar')) {
            $path       = 'gambar/';
            $file       = $request->file('gambar');
            $fileName   = $file->getClientOriginalName();
            $gambar     = $file->storeAs($path, $fileName, 'public');
        } else {
            $gambar = null;
        }

        $kode_produk = '00 - ' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        $request->merge([
            'kode_produk'   => $kode_produk,
            'gambar'         => $gambar,
            'user_id'        => auth()->user()->id
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $produk = Produk::create([
            'kode_produk'      => $request->kode_produk,
            'nama_produk'      => $request->nama_produk,
            'hpp'             => $request->hpp,
            'stok'             => $request->stok,
            'harga_jual'             => $request->harga_jual,
            'gambar'            => $path . $fileName,
            'kategori_id'      => $request->kategori_id,
            'user_id'           => $request->user_id,
            'cabang_id'         => $request->cabang_id
        ]);

        return response()->json([
            'success'   => true,
            'message'   => 'Data Berhasil Ditambahkan !',
            'data'      => $produk
        ]);
    }

    public function show(Produk $produk)
    {
        return response()->json([
            'success'   => true,
            'message'   => 'Edit Data',
            'data'      => $produk
        ]);
    }

    public function edit(Produk $produk)
    {
        return response()->json([
            'success'   => true,
            'message'   => 'Edit Data',
            'data'      => $produk
        ]);
    }

    public function update(Request $request, Produk $produk)
    {
        $validator = Validator::make($request->all(), [
            'gambar'        => 'required|mimes:jpeg,jpg,png',
            'kode_produk'  => 'required',
            'nama_produk'  => 'required',
            'kategori_id'  => 'required',
            'hpp'  => 'required',
            'harga_jual'         => 'required',
            'stok'  => 'required',
            'cabang_id'     => 'required'
        ], [
            'gambar.required'        => 'Tambahkan Gambar !',
            'gambar.mimes'           => 'Gunakan Gambar Yang Memiliki Format jpeg, png, jpg !',
            'kode_produk.required'  => 'Form Nama produk Wajib Di Isi !',
            'nama_produk.required'  => 'Form Nama produk Wajib Di Isi !',
            'kategori_id.required'  => 'Form Nama produk Wajib Di Isi !',
            'hpp.required'  => 'Form Nama produk Wajib Di Isi !',
            'harga_jual.required'  => 'Form Nama produk Wajib Di Isi !',
            'stok.required'  => 'Form Nama produk Wajib Di Isi !',
            'cabang_id'              => 'Pilih Cabang !'
        ]);

        if ($request->hasFile('gambar')) {
            if ($produk->gambar) {
                unlink('.' . Storage::url($produk->gambar));
            }
            $path      = 'gambar/';
            $file      = $request->file('gambar');
            $fileName  = $file->getClientOriginalName();
            $gambar    = $file->storeAs($path, $fileName, 'public');
            $path      .= $fileName;
        } else {
            $validator = Validator::make($request->all(), [
                'gambar'        => 'required',
                'kode_produk'  => 'required',
                'nama_produk'  => 'required',
                'kategori_id'  => 'required',
                'hpp'  => 'required',
                'harga_jual'         => 'required',
                'stok'  => 'required',
                'cabang_id'     => 'required'
            ], [
                'gambar.required'        => 'Tambahkan Gambar !',
                'kode_produk.required'  => 'Form Nama produk Wajib Di Isi !',
                'nama_produk.required'  => 'Form Nama produk Wajib Di Isi !',
                'kategori_id.required'  => 'Form Nama produk Wajib Di Isi !',
                'hpp.required'  => 'Form Nama produk Wajib Di Isi !',
                'harga_jual.required'  => 'Form Nama produk Wajib Di Isi !',
                'stok.required'  => 'Form Nama produk Wajib Di Isi !',
                'cabang_id'              => 'Pilih Cabang !'
            ]);

            $path = $produk->gambar;
        }

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $produk->update([
            'gambar'        => $path,
            'kode_produk'  => $request->kode_produk,
            'nama_produk'  => $request->nama_produk,
            'kategori_id'  => $request->kategori_id,
            'hpp'  => $request->hpp,
            'harga_jual'         => $request->harga_jual,
            'stok'  => $request->stok,
            'user_id'       => auth()->user()->id,
            'cabang_id'     => $request->cabang_id
        ]);

        return response()->json([
            'success'   => true,
            'message'   => 'Data Berhasil Terupdate',
            'data'      => $produk
        ]);
    }
}
