@extends('layout.main')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Tambah Transaksi</h1>
  </div> 
  <div class="card">
    <div class="card-header">
        Tambah Transaksi
    </div>
    <form action="{{ route('transaksi.store') }}" method="post">
        @csrf
    <div class="card-body">
        <div class="mb-3 row">
            <label for="jenistransaksi" class="col-sm-2 col-form-label">Jenis Transaksi</label>
            <div class="col-sm-10">
                <select class="form-select @error('jenistrans') is-invalid @enderror" value="{{ old('jenistrans') }}" name="jenistrans" id="jenistrans" aria-label="Default select example">
                    <option value="0">-- Pilih Jenis Transaksi --</option>
                    <option value="1" idtrs="1">Pemasukan</option>
                    <option value="2" idtrs="2">Pengeluaran</option>
                    </select>
                    @error('jenistrans')
                    <div class="invalid-feedback">
                        {{ $message }}
                        </div>
                    @enderror
            </div>
        </div>
        <div class="mb-3 row">
            <label for="kategori" class="col-sm-2 col-form-label">Kategori</label>
            <div class="col-sm-10">
                <select class="form-select @error('kategori') is-invalid @enderror" value="{{ old('kategori') }}" name="kategori" aria-label="Default select example" id="kategori">
                    <option value="0">-- Pilih Kategori --</option>
                    <option value="1">Pemasukan</option>
                    </select>
                    @error('kategori')
                    <div class="invalid-feedback">
                        {{ $message }}
                        </div>
                    @enderror
            </div>
        </div>
    <div class="mb-3 row">
        <label for="nominal" class="col-sm-2 col-form-label">Nominal</label>
        <div class="col-sm-10">
            <input type="text" class="form-control @error('nominal') is-invalid @enderror" id="nominal" name="nominal" placeholder="Masukan Nominal">
            <input type="hidden" name="nominalx" id="nominalx">
            @error('nominal')
            <div class="invalid-feedback">
                {{ $message }}
                </div>
            @enderror
        </div>
        </div>
    <div class="mb-3 row">
        <label for="deskripsi" class="col-sm-2 col-form-label">Deskripsi</label>
        <div class="col-sm-10">
            <input type="text" class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" placeholder="Masukan Subkategori">
            @error('deskripsi')
            <div class="invalid-feedback">
                {{ $message }}
                </div>
            @enderror
        </div>
        </div>

        <a href="{{ route('transaksi.index') }}" class="btn btn-danger">Kembali</a>
        <button type="submit" class="btn btn-primary">Simpan</button>
        
        
    </div>
    </form>
  </div>
  <script>
    $(document).ready(function(){
        $('#jenistrans').change(function(){
            var idtr = $(this).find("option:selected").attr("idtrs");
        
            $.ajax({
                type: "POST",
                url: "{{ route('getIdKategori') }}",
                data: {
                    _token : "{{ csrf_token() }}",
                    idtr : idtr
                },
                dataType: "JSON",
                beforeSend: function(e) {
                    if (e && e.overrideMimeType) {
                        e.overrideMimeType("application/json;charset=UTF-8");
                    }
                },
                success: function(response) {
                    // console.log(response.data);
                    $("#kategori").prop('disabled', false);
                    $("#kategori").children().remove();
                    $("#kategori").append("<option value='0' selected='selected' disabled>-- Pilih Kategori --</option>");

                    $.each(response.data, function(key, val){
                        $("#kategori").append("<option value="+val.id+">"+val.namasubkategori+"</option>");
                    });
                }
            });
        });
    });
</script>

@endsection
