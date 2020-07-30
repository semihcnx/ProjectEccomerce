@extends('yonetim.layouts.master')
@section('title','Kullanıcılar')
@section('content')
<h1 class="page-header">Kullanici</h1>


                <form method="POST" action="{{ route('yonetim.kullanici.kaydet',$entry->id) }}">
                {{csrf_field()}}
                    <div class="pull-right">
                    <button type="submit" class="btn btn-primary">
                        {{@$entry->id> 0 ? "Güncelle" : "Kaydet"}}
                    </button>
                    </div>
                    <h2 class="sub-header">Kullanıcı  {{@$entry->id> 0 ? "Düzenle" : "Ekle"}}</h2>

                    @include('layouts.partials.error')
                    @include('layouts.partials.alert')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="adsoyad">Ad Soyad</label>
                                <input type="text" class="form-control" name="adsoyad" id="adsoyad" placeholder="Ad Soyad" value="{{ old('adsoyad',$entry->adsoyad)}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" name="email" id="email" placeholder="Email" value="{{old('email',$entry->email)}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password">Şifre</label>
                                <input type="password" class="form-control" name="password" id="password" placeholder="Şifre">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="adres">Adres</label>
                                <input type="text" class="form-control" id="adres" name="adres" placeholder="Adres" value="{{old('adres',$entry->detay->adres)}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="telefon">Telefon</label>
                                <input type="text" class="form-control" id="telefon" name="telefon" placeholder="Telefon"  value="{{old('telefon',$entry->detay->telefon)}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="ceptelefonu"> Cep Telefonu</label>
                                <input type="text" class="form-control" id="ceptelefonu" name="ceptelefonu" placeholder="Cep Telefonu"  value="{{old('ceptelefonu',$entry->detay->ceptelefonu)}}">
                            </div>
                        </div>
                    </div>
                    <div class="checkbox" >
                        <label>
                            <input type="hidden" value="0" name="aktif_mi">
                            <input type="checkbox" name="aktif_mi" value="1"  {{old('aktif_mi',$entry->aktif_mi) ? 'checked' : ''}}> Aktif Mi?
                        </label>
                    </div>
                    <div class="checkbox" >
                        <label>
                        <input type="hidden" value="0" name="yonetici_mi">
                            <input type="checkbox" name="yonetici_mi" value="1"  {{old('yonetici_mi',$entry->yonetici_mi) ? 'checked' : ''}}> Yönetici Mi?
                        </label>
                    </div>

                </form>

@endsection
