@extends('layout.main')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Home</h1>
  </div>  


    <div class="row align-items-start">
      <div class="col">
          
        <div class="card">
          <h5 class="card-header">Saldo Saat Ini : </h5>
          <div class="card-body">
          
            <h2 class="card-title">
                @foreach ($saldo as $sd )
                    {{ Rupiah($sd->saldo) }}  
                @endforeach
            </h2>
            
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card">
          <h5 class="card-header">Total Pengeluaran : </h5>
          <div class="card-body">
          @foreach ($pengeluaran as $pg)
                  <h2 class="card-title">{{ Rupiah($pg->nominal) }}</h2>
          @endforeach
        </div>
        </div>
      </div>
      <div class="col">
            
      <div class="card">
        <h5 class="card-header">Total Pemasukan :</h5>
        <div class="card-body">
          @foreach ($pemasukan as $pk)
                <h2 class="card-title">{{ Rupiah($pk->nominal) }}</h2>
        @endforeach
          
        </div>
      </div>
      </div>
     

 
  
  </div>
@endsection
