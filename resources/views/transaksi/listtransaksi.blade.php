@extends('layout.main')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Cari Transaksi</h1>
  </div> 

  <div>

<form action="{{ route('cari') }}" method="GET">
    @csrf
 <div class="row align-items-start">
      <div class="col">
        <div class="mb-3 row">
            <label for="tglAwal" class="col-sm-2 col-form-label">Tangga Awal</label>
            <div class="col-sm-10">
                <input type="date" class="form-control" id="tglAwal" name="tglAwal" required>
            </div>
      </div>
      <div class="mb-3 row">
          <label for="tglAkhir" class="col-sm-2 col-form-label">Tangga Akhir</label>
          <div class="col-sm-10">
              <input type="date" class="form-control" id="tglAkhir" name="tglAkhir" required>
          </div>
    </div>
       
      </div>
      <div class="col">
      </div>
      <div class="float-right">
          <a class="btn btn-danger " href="{{ route('transaksi.index') }}">Kembali</a>
          <button class="btn btn-primary " type="submit">Cari</button>
      </div>
  </div>
</form>

  <div class="py-3">
    <table class="table" id="kategori" mr-5>
      <thead>
        <tr>
          <th scope="col">No</th>
          <th scope="col">Ketagori</th>
          <th scope="col">Jenis Transaksi</th>
          <th scope="col">Nominal</th>
          <th scope="col">Deskripsi</th>
        </tr>
      </thead>
      <tbody>
       
        {{-- @if ($transaksi == null) --}}
            @foreach ($transaksi as $tr )
            <tr>
            <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $tr->namasubkategori }}</td>
            <td>{{ $tr->namakategori }}</td>
            <td>{{ Rupiah($tr->nominal) }}</td>
            <td>{{ $tr->deskripsi }}</td>
            <td>
        
        </tr>
        @endforeach
      {{-- @endif  --}}
        {{-- <tr>
            <td colspan="5" align="center"> <strong>Data Transaksi Kosong</strong></td>
        </tr> --}}
      </tbody>
    </table>
  </div>

@endsection
