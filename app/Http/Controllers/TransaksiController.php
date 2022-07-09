<?php

namespace App\Http\Controllers;

use App\Models\Saldo;
use Exception;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         // saldo 
         $saldo = DB::table('saldos')
                 ->select('saldo')
                 ->get();
   
        // Transaksi Bulan ini
        $hari_ini     = date("Y-m-d");
        $tgl_pertama  = date('Y-m-01', strtotime($hari_ini));
        $tgl_terakhir = date('Y-m-t', strtotime($hari_ini));


         $transaksi = DB::table('transaksis')
                    ->join('kategoris', 'transaksis.id_kategori', 'kategoris.id')
                    ->join('subkategoris', 'transaksis.id_subkategori', 'subkategoris.id')
                    ->select('transaksis.nominal','transaksis.id','transaksis.id_kategori', 'transaksis.deskripsi', 'kategoris.namakategori','subkategoris.namasubkategori')
                    ->whereBetween('transaksis.created_at', [$tgl_pertama . ' 00:00:00', $tgl_terakhir . ' 23:59:00'])
                    ->get();
  
       
        return view('transaksi.index',[
            'title' => 'Transaksi',
            'transaksi' => $transaksi,
            'saldo' => $saldo
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {  
        return view('transaksi.tambah',[
            'title' => 'Tambah Transaksi'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        $data = $request->validate([
            'jenistrans' => 'required|not_in:0',
            'kategori' => 'required|not_in:0',
            'nominal' => 'required',
            'deskripsi' => 'required',
        ]);
        
         
        try {
            DB::beginTransaction();
            if($data['jenistrans'] == 1){
                // Ketika ada pemasukan
                $saldo = DB::table('saldos')
                        ->select('saldo')
                        ->get();
                foreach ($saldo as $sd){
                    $totsaldo = $sd->saldo + $request->nominalx;
                }
                
                Saldo::where('id', 1)->update( [
                    "saldo" => $totsaldo
                ] );

                Transaksi::create([
                    "id_kategori" => $data['jenistrans'],
                    "id_subkategori" => $data['kategori'],
                    "nominal" => $request->nominalx,
                    "deskripsi" => $data['deskripsi']
                ]);
            }else{
                // Ketika ada pengeluaran
                $saldo = DB::table('saldos')
                        ->select('saldo')
                        ->get();
                foreach ($saldo as $sd){
                    $totsaldo = $sd->saldo - $request->nominalx;
                }
                
                Saldo::where('id', 1)->update( [
                    "saldo" => $totsaldo
                ] );

                Transaksi::create([
                    "id_kategori" => $data['jenistrans'],
                    "id_subkategori" => $data['kategori'],
                    "nominal" => $request->nominalx,
                    "deskripsi" => $data['deskripsi']
                ]);

            }

            DB::commit();
            return redirect()->route('transaksi.index')->with('success', 'Transaksi has been added');
        } catch (Exception $e) {
            // dd($e->getMessage());
            DB::rollBack();
            return redirect()->route('transaksi.create')->with('error', $e->getMessage());
          
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('transaksi.edit',[
            'title' => 'Edit Transaksi',
            'DetTransaksi' => Transaksi::where('id', $id)->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'jenistrans' => 'required|not_in:0',
            'kategori' => 'required|not_in:0',
            'nominal' => 'required',
            'deskripsi' => 'required',
        ]);
        
         
        try {
            DB::beginTransaction();
            // Ketika ada pemasukan
            // Pengeluaran 
        if($data['jenistrans'] == $request->jenistransx){
            // Pengeluaran == Pengeluaran
            if($request->nominalx == $request->nominalasli){
                Transaksi::where('id', $id)->update( [
                    "id_kategori" => $data['jenistrans'],
                    "id_subkategori" => $data['kategori'],
                    // "nominal" => $request->nominalx,
                    "deskripsi" => $data['deskripsi']
                ]);
            }elseif($request->nominalx < $request->nominalasli){

                // Tambah saldo 
                // $tot = $request->nominalasli -  $request->nominalx;

                $saldo = DB::table('saldos')
                    ->select('saldo')
                    ->get();
                foreach ($saldo as $sd){
                    $totsaldo = $sd->saldo - $request->nominalx;
                }
                // dd($totsaldo);
                Saldo::where('id', 1)->update([
                    "saldo" => $totsaldo
                ]);

                Transaksi::where('id', $id)->update( [
                    "id_kategori" => $data['jenistrans'],
                    "id_subkategori" => $data['kategori'],
                    "nominal" => $request->nominalx,
                    "deskripsi" => $data['deskripsi']
                ]);

            }elseif($request->nominalx > $request->nominalasli){
            // Tambah saldo 
            $saldo = DB::table('saldos')
             ->select('saldo')
                        ->get();
            foreach ($saldo as $sd){
            $totsaldo = $sd->saldo + $request->nominalx - $request->nominalasli;
            }
            //  dd($totsaldo);
            Saldo::where('id', 1)->update([
            "saldo" => $totsaldo
            ]);

                Transaksi::where('id', $id)->update( [
                    "id_kategori" => $data['jenistrans'],
                    "id_subkategori" => $data['kategori'],
                    "nominal" => $request->nominalx,
                    "deskripsi" => $data['deskripsi']
                ]);

            }

        }else{
            // Transaksi  = Pengeluaran > Pemasukan
            if($request->nominalx == $request->nominalasli){
                Transaksi::where('id', $id)->update( [
                    "id_kategori" => $data['jenistrans'],
                    "id_subkategori" => $data['kategori'],
                    "nominal" => $request->nominalx,
                    "deskripsi" => $data['deskripsi']
                ]);
                 // Tambah saldo 
                $saldo = DB::table('saldos')
                    ->select('saldo')
                    ->get();

                foreach ($saldo as $sd){
                        $totsaldo = $sd->saldo - $request->nominalasli;
                }
                // dd($totsaldo);
                Saldo::where('id', 1)->update([
                        "saldo" => $totsaldo
                ]);


            }elseif($request->nominalx < $request->nominalasli){
                // Kurangi saldo 
                $saldo = DB::table('saldos')
                    ->select('saldo')
                    ->get();
                foreach ($saldo as $sd){
                    $totsaldo = $sd->saldo - $request->nominalasli;
                }
                // dd($totsaldo);
                Saldo::where('id', 1)->update([
                    "saldo" => $totsaldo
                ]);

                // Tambah saldo
                $saldo = DB::table('saldos')
                    ->select('saldo')
                    ->get();
                foreach ($saldo as $sd){
                    $totsaldo = $sd->saldo + $request->nominalx;
                }
                // dd($totsaldo);
                Saldo::where('id', 1)->update([
                    "saldo" => $totsaldo
                ]);

                Transaksi::where('id', $id)->update( [
                    "id_kategori" => $data['jenistrans'],
                    "id_subkategori" => $data['kategori'],
                    "nominal" => $request->nominalx,
                    "deskripsi" => $data['deskripsi']
                ]);

            }elseif($request->nominalx > $request->nominalasli){
             // Tambah saldo 
            $saldo = DB::table('saldos')
                 ->select('saldo')
                 ->get();
             foreach ($saldo as $sd){
                 $totsaldo = $sd->saldo  - $request->nominalx;
                //  $totsaldo = $sd->saldo + $request->nominalx - $request->nominalasli;
             }
            //  dd($totsaldo);
             Saldo::where('id', 1)->update([
                 "saldo" => $totsaldo
             ]);

             Transaksi::where('id', $id)->update( [
                 "id_kategori" => $data['jenistrans'],
                 "id_subkategori" => $data['kategori'],
                 "nominal" => $request->nominalx,
                 "deskripsi" => $data['deskripsi']
             ]);
            }   
        }

              
                
            DB::commit();
            return redirect()->route('transaksi.index')->with('success', 'Transaksi has been updated');
        } catch (Exception $e) {
            // dd($e->getMessage());
            DB::rollBack();
            return redirect()->route('transaksi.create')->with('error', $e->getMessage());
          
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        try {   
            DB::beginTransaction();
            // dd($request->all());
            if($request->idtrs == 1){
               //saldo sekarang - item pemasukan  
               // Kurang saldo 
                $saldo = DB::table('saldos')
                                ->select('saldo')
                                ->get();
                // var_dump($saldo);
                foreach ($saldo as $sd){
                    $totsaldo = $sd->saldo - $request->nominal;
                }
                
                Saldo::where('id', 1)->update([
                    "saldo" => $totsaldo
                ]);

                Transaksi::destroy($id);

            }else{
                $saldo = DB::table('saldos')
                ->select('saldo')
                ->get();
                // var_dump($saldo);
                foreach ($saldo as $sd){
                    $totsaldo = $sd->saldo + $request->nominal;
                }

                Saldo::where('id', 1)->update([
                    "saldo" => $totsaldo
                ]);

                Transaksi::destroy($id);
            }
            
            
            DB::commit();
            return redirect()->route('transaksi.index')->with('success', 'Transaksi has been updated');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('transaksi.create')->with('error', $e->getMessage());
        
        }
    }
}
