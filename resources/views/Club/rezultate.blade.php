@include('club/header')
    <div class="club-matches-content">
        <div class="matches-section">
            @if(isset($meciuri[0]))
                <div class="table">
                    @foreach ($meciuri as $meci)
                    <div class="table-header">
                        <div class="table-header-data" style="width: 13%"><h2>Data</h2></div>
                        <div class="table-header-data" style="width: 70%"><h2>{{str($meci->faza)->title()}} - etapa {{$meci->nrEtapa}}</h2></div>
                        <div class="table-header-data" style="width: 18%">  </div>
                    </div>
                        <div class="table-row">
                            <div class="table-row-data" style="width: 13%"><h3>{{date('d-m-y H:i', strtotime($meci->data));}}</h3></div>
                            <div class="table-row-data" style="width: 30%;"><h3><a href="/Liga1/public/club-info/{{$cluburiDct[$meci->echipaGazdaID]}}/info"> {{$cluburiDct[$meci->echipaGazdaID]}} </a></h3></div>
                            <div class="table-row-data" style="width: 10%;"><h3>@if($meci->disputat){{$meci->goluriEG}}@endif - @if($meci->disputat){{$meci->goluriEO}}@endif</h3></div>
                            <div class="table-row-data" style="width: 30%;"><h3><a href="/Liga1/public/club-info/{{$cluburiDct[$meci->echipaOaspeteID]}}/info"> {{$cluburiDct[$meci->echipaOaspeteID]}} </a></h3></div>
                            <div class="table-row-data" style="width: 18%"><a href="/Liga1/public/meci/{{$meci->id}}/info" style="width: 100%; height: 100%"><button>Statistici</button></a></div>
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