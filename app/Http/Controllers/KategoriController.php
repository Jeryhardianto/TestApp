<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Subkategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('kategori.list',[
            'title' => 'List Kategori',
            'listKat' => Subkategori::get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('kategori.tambah',[
            'title' => 'Tambah Kategori'
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
            'namasub' => 'required',
            'kategori' => 'required|not_in:0',
        ]);
        try {

            Subkategori::create([
                "namasubkategori" => $data['namasub'],
                "id_kategori" => $data['kategori']
            ]);
            return redirect()->route('kategori.index')->with('success', 'SubKategori has been added');
        } catch (Exception $e) {
            // dd($e->getMessage());
            return redirect()->route('kategori.create')->with('error', $e->getMessage());
          
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
        return view('kategori.edit',[
            'title' => 'Edit Kategori',
            'getDetailKat' => Subkategori::where('id', $id)->get()
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
            'namasub' => 'required',
            'kategori' => 'required|not_in:0',
        ]);
        try {

            Subkategori::where('id', $id)->update( [
                    "namasubkategori" => $data['namasub'],
                    "id_kategori" => $data['kategori']
                ] );
            return redirect()->route('kategori.index')->with('success', 'SubKategori has been updated');
        } catch (Exception $e) {
            // dd($e->getMessage());
            return redirect()->route('kategori.create')->with('error', $e->getMessage());
          
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Subkategori::destroy($id);
        return redirect()->route('kategori.index')->with('success', 'SubKategori has been deleted');
    }

    public function getIdKategori(Request $request){
        $data = Subkategori::all()
        ->where('id_kategori', $request->input('idtr'));

        return response()->json(array('data' => $data), 200);
    }
}
