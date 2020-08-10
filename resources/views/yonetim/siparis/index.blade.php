@extends('yonetim.layouts.master')
@section('title','Sipariş')
@section('content')

<h1 class="page-header">Sipariş Yönetimi</h1>
<h3 class="sub-header">  Siparişlerin Listesi</h3>
    <div class="well">


    <form method="post" action="{{route('yonetim.siparis')}}" class="form-inline">
        {{csrf_field()}}
        <div class="form-group">
            <label for="aranan">Ara</label>
            <input type="text" class="form-control form-control-sm" name="aranan" id="aranan" placeholder="Siparis Ara..." value="{{old('aranan')}}" >
            <button type="submit" class="btn btn-primary">Ara</button>
            <a href="{{route('yonetim.siparis')}}" class="btn btn-primary">Temizle</a>
        </div>

    </form>
    </div>
@include('layouts.partials.alert')
<div class="table-responsive">
    <table class="table table-hover table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>Siparis Kodu</th>
                <th>Kullanıcı</th>
                <th>Tutar</th>
                <th>Durum</th>
                <th>Sipariş Tarihi</th>
                <th>İşlemler</th>
            </tr>
        </thead>
        <tbody>
        @if (count($listele)== 0 )
            <tr>
                <td colspan="6" class="text-center">Kayıt Bulunamadı.</td>
            </tr>
            @endif
            @foreach($listele as $entry)
            <tr>
                <td>SP-{{$entry->id}}</td>
                <td>{{$entry->sepet->kullanici->adsoyad}}</td>
                <td>{{$entry->siparis_tutari * ((100+ config('cart.tax')) /100)  }}</td>
                <td>{{$entry->durum}}</td>
                <td>{{$entry->olusturma_tarihi}}</td>
                <td style="width: 100px">
                    <a href="{{ route('yonetim.siparis.duzenle',$entry->id)}}" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Düzenle">
                        <span class="fa fa-pencil"></span>
                    </a>
                    <a href="{{route('yonetim.siparis.sil',$entry->id)}}" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Sil" onclick="return confirm('Emin Misin?')">
                        <span class="fa fa-trash"></span>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{$listele->links()}}
</div>




@endsection


