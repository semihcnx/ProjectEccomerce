@extends('yonetim.layouts.master')
@section('title','Kategoriler')
@section('content')
<h1 class="page-header">Kategori</h1>


                <form method="POST" action="{{ route('yonetim.kategori.kaydet',$entry->id) }}">
                {{csrf_field()}}
                    <div class="pull-right">
                    <button type="submit" class="btn btn-primary">
                        {{@$entry->id> 0 ? "Güncelle" : "Kaydet"}}
                    </button>
                    </div>
                    <h2 class="sub-header">Kategori  {{@$entry->id> 0 ? "Düzenle" : "Ekle"}}</h2>

                    @include('layouts.partials.error')
                    @include('layouts.partials.alert')
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="ust_id">Üst Kategori Adı</label>
                            <select id="ust_id" name="ust_id" class="form-control">
                                <option value="">Ana Kategori</option>
                                @foreach ($kategoriler as $kategori)
                                <option value="{{$kategori->id}}">{{$kategori->kategori_adi}}</option>
                                @endforeach
                            </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kategori_adi">Kategori Adı</label>
                                <input type="text" class="form-control" name="kategori_adi" id="kategori_adi" placeholder="Kategori Adı" value="{{ old('kategori_adi',$entry->kategori_adi)}}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="adres">Slug</label>
                                <input type="hidden" name="original_slug" value="{{old('slug',$entry->slug)}}">
                                <input type="text" class="form-control" id="slug" name="slug" placeholder="Slug" value="{{old('slug',$entry->slug)}}">
                            </div>
                        </div>
                    </div>




                </form>

@endsection
