<h1>{{config('app.name')}}</h1>
<p>Merhaba {{$kullanici->adsoyad}}, Kaydınız Başarılı Bir Şekilde Yapılmşıtır.</p>
<p>Kaydınızı aktifleştirmek için <a href="{{config('app.url')}}/kullanici/aktiflestir/{{$kullanici->aktivasyon_anahtari}}">tıklayınız</a>. Yada aşağıdaki bağlantıya gidiniz.</p>
<p>{{config('app.url')}}/kullanici/aktiflestir/{{$kullanici->aktivasyon_anahtari}}</p>
