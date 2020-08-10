@extends('yonetim.layouts.master')
@section('title','Anasayfa')
@section('content')

<h1 class="page-header">Kontrol Paneli</h1>

<section class="row text-center placeholders">
    <div class="col-6 col-sm-3">
        <div class="panel panel-primary">
            <div class="panel-heading">Bekleyen Sipariş</div>
            <div class="panel-body">
                <h4>{{$istatistikler['bekleyen_siparis']}}</h4>

                <p>adet</p>
            </div>
        </div>
    </div>
    <div class="col-6 col-sm-3">
        <div class="panel panel-primary">
            <div class="panel-heading">Tamamlanan Sipariş</div>
            <div class="panel-body">
                <h4>{{$istatistikler['tamamlanan_siparis']}}</h4>
                <p>adet</p>
            </div>
        </div>
    </div>
    <div class="col-6 col-sm-3">
        <div class="panel panel-primary">
            <div class="panel-heading">Ürün</div>
            <div class="panel-body">
                <h4>{{$istatistikler['toplam_urun']}}</h4>
                <p>adet</p>
            </div>
        </div>
    </div>
    <div class="col-6 col-sm-3">
        <div class="panel panel-primary">
            <div class="panel-heading">Kullanıcı</div>
            <div class="panel-body">
                <h4>{{$istatistikler['toplam_kullanici']}}</h4>
                <p>kişi</p>
            </div>
        </div>
    </div>
</section>

<section class="row">
    <div class="col-sm-6">
        <div class="panel panel-primary">
            <div class="panel-heading">Çok Satan Ürünler</div>
            <div class="panel-body">
            <canvas id="chartCokSatan" ></canvas>
            </div>
        </div>
    </div>


    <div class="col-sm-6">
    <div class="panel panel-primary">
            <div class="panel-heading">Aylara Göre Satışlar</div>
            <div class="panel-body">
            <canvas id="chartAylaraGore" ></canvas>
            </div>
    </div>
    </div>

</section>
@endsection

@section('footer')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.min.js"></script>
<script>
    @php
    $labels= "";
    $data = "";
    foreach ($cok_satan_urunler as $rapor)
    {
        $labels .= "\"$rapor->urun_adi\",";
        $data .= "$rapor->adet,";
    }

    @endphp

var ctx = document.getElementById('chartCokSatan');
var chartCokSatan = new Chart(ctx, {
    type: 'horizontalBar',
    data: {
        labels: [{!! $labels !!}],
        datasets: [{
            label: 'Çok Satan Ürünler',
            data: [{!! $data !!}],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        legend: {
            position: 'bottom'
        },
        scales: {
            xAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});


 @php
    $labels= "";
    $data = "";
    foreach ($aylara_gore_satislar as $rapor)
    {
        $labels .= "\"$rapor->ay\",";
        $data .= "$rapor->adet,";
    }

    @endphp

var ctx2 = document.getElementById('chartAylaraGore');
var chartAylaraGore = new Chart(ctx2, {
    type: 'line',
    data: {
        labels: [{!! $labels !!}],
        datasets: [{
            label: 'Aylara Göre Ürünler',
            data: [{!! $data !!}],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        legend: {
            position: 'bottom'
        },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true,
                    stepSize:1
                }
            }]
        }
    }
});





</script>
@endsection
