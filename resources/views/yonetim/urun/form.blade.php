@extends('yonetim.layouts.master')
@section('title','Ürünler')
@section('content')
<h1 class="page-header">Ürün Yönetimi</h1>


                <form method="POST" action="{{ route('yonetim.urun.kaydet',$entry->id) }}" enctype="multipart/form-data">
                {{csrf_field()}}
                    <div class="pull-right">
                    <button type="submit" class="btn btn-primary">
                        {{@$entry->id> 0 ? "Güncelle" : "Kaydet"}}
                    </button>
                    </div>
                    <h2 class="sub-header">Ürün  {{@$entry->id> 0 ? "Düzenle" : "Ekle"}}</h2>

                    @include('layouts.partials.error')
                    @include('layouts.partials.alert')


                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="urun_adi">Ürün Adı</label>
                                <input type="text" class="form-control" name="urun_adi" id="urun_adi" placeholder="Ürün Adı" value="{{ old('urun_adi',$entry->urun_adi)}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="adres">Slug</label>
                                <input type="hidden" name="original_slug" value="{{old('slug',$entry->slug)}}">
                                <input type="text" class="form-control" id="slug" name="slug" placeholder="Slug" value="{{old('slug',$entry->slug)}}">
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="aciklama">Açıklama</label>
                                <textarea class="form-control" name="aciklama" id="aciklama" placeholder="Açıklama" >
                                {{ old('aciklama',$entry->aciklama)}}
                                </textarea>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fiyati">Fiyatı</label>
                                <input type="text" class="form-control" name="fiyati" id="fiyati" placeholder="Fiyatı" value="{{ old('fiyati',$entry->fiyati)}}">
                            </div>
                        </div>
                    </div>

                    <div class="checkbox" >
                        <label>
                            <input type="hidden" value="0" name="goster_slider">
                            <input type="checkbox" name="goster_slider" value="1"  {{old('goster_slider',$entry->detay->goster_slider) ? 'checked' : ''}}>Slider'da Göster
                        </label>
                        <label>
                            <input type="hidden" value="0" name="goster_gunun_firsati">
                            <input type="checkbox" name="goster_gunun_firsati" value="1"  {{old('goster_gunun_firsati',$entry->detay->goster_gunun_firsati) ? 'checked' : ''}}>Günün Fırsatında Göster
                        </label>
                        <label>
                            <input type="hidden" value="0" name="goster_one_cikan">
                            <input type="checkbox" name="goster_one_cikan" value="1"  {{old('goster_one_cikan',$entry->detay->goster_one_cikan) ? 'checked' : ''}}>Öne Çıkan da Göster
                        </label>
                        <label>
                            <input type="hidden" value="0" name="goster_cok_satan">
                            <input type="checkbox" name="goster_cok_satan" value="1"  {{old('goster_cok_satan',$entry->detay->goster_cok_satan) ? 'checked' : ''}}>Çok Satanda Göster
                        </label>
                        <label>
                            <input type="hidden" value="0" name="goster_indirimli">
                            <input type="checkbox" name="goster_indirimli" value="1"  {{old('goster_indirimli',$entry->detay->goster_indirimli) ? 'checked' : ''}}>İndirimlide Göster
                        </label>

                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="kategoriler">Kategoriler</label>
                                <select class="form-control" name="kategoriler[]" id="kategoriler" multiple>
                                @foreach ($kategoriler as $kategori)
                                <option value="{{$kategori->id}}" {{collect(old('kategoriler',$urun_kategorileri))->contains($kategori->id) ? 'selected': ''}}
                                >{{$kategori->kategori_adi}}</option>
                                @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                   @if($entry->detay->urun_resmi!=null)

                       <img src="/uploads/urunler/{{$entry->detay->urun_resmi}}" alt="" style="height:100px; margin-right:20px; " class="thumbnail pull-left">

                    @endif
                    <div class="form-group">
                        <label for="urun_resmi">Ürün Resmi</label>
                        <input type="file" id="urun_resmi"  name="urun_resmi">
                    </div>


                </form>

@endsection


@section('head')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('footer')
<script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
    $(function(){
        $('#kategoriler').select2({
            placeholder: 'Lütfen Kategori Seçiniz'
        });

        var options = {
            uiColor: '#f4645f',
            language: 'tr',
            filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
            filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
            filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
            filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
        };

        CKEDITOR.replace('aciklama',options);
    });

</script>
@endsection
