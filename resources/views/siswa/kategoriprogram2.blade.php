@extends('siswa.layouts.layout')
@section('title','Kategori Program')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="row">
            @foreach ($KategoriProgram as $item)

            <div class="col-md-6 my-2" style="cursor: pointer" onclick="setGlobal('{{$KategoriGlobal}}','{{$item->UUID}}')">
                <div class="card">
                    <img class="card-img-top" src="holder.js/100x180/" alt="">
                    <div class="card-body">
                        <h4 class="card-title">{{$item->KategoriProgram}}</h4>
                        <p class="card-text">{{$item->Keterangan}}</p>
                    </div>
                </div>
                <div class="row">
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<div class="row">

</div>

@endsection
@push('scripts')
<script>
    function setGlobal(uid,uid2){
        window.location.href = '/siswa/program/'+uid+'/'+uid2;
    }
</script>
<script src="{{asset('assets/js/siswa/programlist.js')}}"></script>
@endpush