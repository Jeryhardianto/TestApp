@extends('layout.main')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Kategori</h1>
  </div> 
  <div class="card">
    <div class="card-header">
      Featured
    </div>
    @foreach ($getDetailKat as $gdk)
    <form action="{{ route('kategori.update', $gdk->id) }}" method="post">
        @csrf
        @method('put')
    <div class="card-body">
    <div class="mb-3 row">
        <label for="namasub" class="col-sm-2 col-form-label">Subkategori</label>
        <div class="col-sm-10">
            <input type="text" class="form-control @error('namasub') is-invalid @enderror" id="namasub" name="namasub" placeholder="Masukan Subkategori" value="{{ old('namasub',$gdk->namasubkategori) }}">
            @error('namasub') 
            <div class="invalid-feedback">
                {{ $message }}
                </div>
            @enderror
        </div>
        </div>
    <div class="mb-3 row">
        <label for="kategori" class="col-sm-2 col-form-label">Kategori</label>
        <div class="col-sm-10">
            <select class="form-select @error('kategori') is-invalid @enderror" name="kategori" id="kategori" aria-label="Default select example">
                <option value="0">-- Pilih Kategori --</option>
                <option value="1">Pemasukan</option>
                <option value="2">Pengeluaran</option>
                </select>
                @error('kategori')
                <div class="invalid-feedback">
                    {{ $message }}
                    </div>
                @enderror
                <input type="hidden" name="katx" id="katx" value="{{ $gdk->id_kategori }}">
        </div>
        </div>
        <a href="{{ route('kategori.index') }}" class="btn btn-danger">Kembali</a>
        <button type="submit" class="btn btn-primary">Simpan</button>
        
        
    </div>
    </form>
    @endforeach
  </div>
    

@endsection
