@include('club/header')
    <div class="club-matches-content">
        <div class="matches-section">
            @if(isset($meciuri[0]))
            <div class="table">
                @foreach ($meciuri as $meci)
                <div class="table-header">
                    <div class="table-header-data" style="width: 20%"><h2>Data</h2></div>
                    <div class="table-header-data" style="width: 80%"><h2>{{str($meci->faza)->title()}} - etapa {{$meci->nrEtapa}}</h2></div>
                </div>
                    <div class="table-row">
                        <div class="table-row-data" style="width: 20%"><h3>{{date('d M y H:i', strtotime($meci->data));}}</h3></div>
                        <div class="table-row-data" style="width: 35%"><h3><a href="/Liga1/public/club-info/{{$cluburiDct[$meci->echipaGazdaID]}}/info">{{$cluburiDct[$meci->echipaGazdaID]}}</a></h3></div>
                        <div class="table-row-data" style="width: 10%"><h3>@if($meci->disputat){{$meci->goluriEG}}@endif - @if($meci->disputat){{$meci->goluriEO}}@endif</h3></div>
                        <div class="table-row-data" style="width: 35%"><h3><a href="/Liga1/public/club-info/{{$cluburiDct[$meci->echipaOaspeteID]}}/info">{{$cluburiDct[$meci->echipaOaspeteID]}}</a></h3></div>
                    </div>
                @endforeach
            </div>
            @else
                <h1>Nu exista încă informații.</h1>
            @endif
        </div>
    </div>
</div>
@include('footer')