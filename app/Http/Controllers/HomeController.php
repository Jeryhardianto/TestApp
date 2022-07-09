<?php

namespace App\Http\Controllers;

use App\Models\Saldo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $pemasukan   = DB::select("SELECT SUM(nominal) as nominal FROM transaksis WHERE id_kategori=1");
        $pengeluaran = DB::select("SELECT SUM(nominal) as nominal FROM transaksis WHERE id_kategori=2");
        // dd($pengeluaran);

        return view('index', [
                'title' => 'Welcome',
                'saldo' => Saldo::get(),
                'pengeluaran' => $pengeluaran,
                'pemasukan' => $pemasukan
        ]
        );
    }
}
