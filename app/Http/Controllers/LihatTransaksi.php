<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LihatTransaksi extends Controller
{
    public function index(){
        $transaksi = DB::table('transaksis')
        ->join('kategoris', 'transaksis.id_kategori', 'kategoris.id')
        ->join('subkategoris', 'transaksis.id_subkategori', 'subkategoris.id')
        ->select('transaksis.nominal','transaksis.id','transaksis.id_kategori', 'transaksis.deskripsi', 'kategoris.namakategori','subkategoris.namasubkategori')
        ->get();
        // dd($transaksi);
        return view('transaksi.listtransaksi',[
            'title' => 'Cari Transaksi',
            'transaksi' =>  $transaksi
        ]);
     }

     public function cari(Request $request){
        $tglAwal = $request->tglAwal;
        $tglAkhir = $request->tglAkhir;

        // dd($tglAwal,$tglAkhir);
        $transaksi = DB::table('transaksis')
                    ->join('kategoris', 'transaksis.id_kategori', 'kategoris.id')
                    ->join('subkategoris', 'transaksis.id_subkategori', 'subkategoris.id')
                    ->select('transaksis.nominal','transaksis.id','transaksis.id_kategori', 'transaksis.deskripsi', 'kategoris.namakategori','subkategoris.namasubkategori')
                    ->whereBetween('transaksis.created_at', [$tglAwal . ' 00:00:00', $tglAkhir . ' 23:59:00'])
                    ->get();
        // dd($transaksi);
        return view('transaksi.listtransaksi',[
                'title' => 'Cari Transaksi',
                'transaksi' =>   $transaksi
        ]);
     }
}
