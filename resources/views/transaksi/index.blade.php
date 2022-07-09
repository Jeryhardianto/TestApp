@extends('layout.main')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Transaksi</h1>
  </div> 
  <div class="py-4">
      <a class="btn btn-primary" href="{{ route('transaksi.create') }}">Tambah Transaksi</a>
      <a class="btn btn-success" href="{{ route('lihattransaksi') }}">Cari Transaksi</a>
  </div>


  <div class="card">
    <h5 class="card-header">Saldo Saat Ini : </h5>
    <div class="card-body">
      @foreach ($saldo as $sd)
      <h2 class="card-title">{{ Rupiah($sd->saldo) }}</h2>
      @endforeach
    </div>
  </div>

  <div class="py-3">
    <table class="table" id="kategori" mr-5>
      <thead>
        <tr>
          <th scope="col">No</th>
          <th scope="col">Ketagori</th>
          <th scope="col">Jenis Transaksi</th>
          <th scope="col">Nominal</th>
          <th scope="col">Deskripsi</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
       
          @foreach ($transaksi as $tr )
        <tr>
          <th scope="row">{{ $loop->iteration }}</th>
              <td>{{ $tr->namasubkategori }}</td>
          <td>{{ $tr->namakategori }}</td>
          <td>{{ Rupiah($tr->nominal) }}</td>
          <td>{{ $tr->deskripsi }}</td>
          <td>
              <a class="btn btn-warning" href="{{ route('transaksi.edit', $tr->id) }}">Update</a> 
              ||
          
               <form action="{{ route('transaksi.destroy', $tr->id) }}" method="post" class="d-inline">
                  @method('delete')
                  @csrf
                  <input type="hidden" name="idtrs" id="idtrs" value="{{ $tr->id_kategori }}">
                  <input type="hidden" name="nominal"  value="{{ $tr->nominal }}">
                  <button class="btn btn-danger"
                      onclick="return confirm('You sure delete this data ?')">Delete</button>
              </form>
          </td>
      </tr>
      @endforeach
       
      </tbody>
    </table>
  </div>

@endsection
