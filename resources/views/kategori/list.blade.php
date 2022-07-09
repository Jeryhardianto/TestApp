@extends('layout.main')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Kategori</h1>
  </div> 
  <div class="py-4">
      <a class="btn btn-primary" href="{{ route('kategori.create') }}">Tambah Kategori</a>
  </div>

  <table class="table" id="kategori" mr-5>
    <thead>
      <tr>
        <th scope="col">No</th>
        <th scope="col">Nama Subkategori</th>
        <th scope="col">Nama Kategori</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
     
        @foreach ($listKat as $lk )
      <tr>
        <th scope="row">{{ $loop->iteration }}</th>
            <td>{{ $lk->namasubkategori }}</td>
        <td>{{ $lk->kategori->namakategori }}</td>
        <td>
            <a class="btn btn-warning" href="{{ route('kategori.edit', $lk->id) }}">Update</a> 
            ||
        
             <form action="{{ route('kategori.destroy', $lk->id) }}" method="post" class="d-inline">
                @method('delete')
                @csrf
                <button class="btn btn-danger"
                    onclick="return confirm('You sure delete this data ?')">Delete</button>
            </form>
        </td>
    </tr>
    @endforeach
     
    </tbody>
  </table>

@endsection
