@include('header')

<div class="main-page-content">
    <div class="clubs-section">
        @foreach ($cluburi as $club)
            <a href="/Liga1/public/club-info/{{$club->numeEchipa}}/info"><button> {{$club->numeEchipa}} </button></a>
        @endforeach
    </div>

    <div class="matches-section">
        @if ($meciuri[0]->faza == 'sezon regulat')
        <h1>Sezon Regulat - etapa {{$meciuri[0]->nrEtapa}}</h1>
        <div class="table">
            <div class="table-header">
                <div class="table-header-data" style="width: 11%"><h2>DATA</h2></div>
                <div class="table-header-data" style="width: 71%"><h2>REZULTAT</h2></div>
                <div class="table-header-data" style="width: 16%"><h2>STATISTICI</h2></div>
            </div>
            @foreach ($meciuri as $meci)
                <div class="table-row">
                    <div class="table-row-data" style="width: 10%"><h3>{{date('d M H:i', strtotime($meci->data));}}</h3></div>
                    <div class="table-row-data" style="width: 30%"><h3><a href="/Liga1/public/club-info/{{$cluburiDct[$meci->echipaGazdaID]}}/info">{{$cluburiDct[$meci->echipaGazdaID]}}</a></h3> &nbsp; <img class="small-club-logo" src="/Liga1/public/images/clubs/{{$cluburiDct[$meci->echipaGazdaID]}}.png" alt=""></div>
                    <div class="table-row-data" style="width: 10%">@if($meci->disputat){{$meci->goluriEG}}@endif - @if($meci->disputat){{$meci->goluriEO}}@endif</div>
                    <div class="table-row-data" style="width: 30%"><img class="small-club-logo" src="/Liga1/public/images/clubs/{{$cluburiDct[$meci->echipaOaspeteID]}}.png" alt=""> &nbsp; <h3><a href="club-info/{{$cluburiDct[$meci->echipaOaspeteID]}}"> {{$cluburiDct[$meci->echipaOaspeteID]}}</h3></div>
                    <div class="table-row-data" style="width: 16%"><a href="/Liga1/public/meci/{{$meci->id}}/info" style="width: 100%; height: 100%"><button>Statistici</button></a></div>
                </div>
            @endforeach
        </div>
        @else
        @endif
    </div>

    <div class="tables-section">
        <h1>Clasament - sezon regulat</h1>
        @if ($clasament[0]->faza == 'sezon regulat')
        <div class="table-header">
            <div class="table-header-data" style="width: 10%"> POZ </div>
            <div class="table-header-data" style="width: 40%"> CLUB </div>
            <div class="table-header-data" style="width: 10%"> V </div>
            <div class="table-header-data" style="width: 10%"> E </div>
            <div class="table-header-data" style="width: 10%"> I </div>
            <div class="table-header-data" style="width: 10%"> PCT </div>
        </div>
        @foreach ($clasament as $data)
            <div class="table-row">
                <div class="table-row-data" style="width: 10%"> {{$data->pozitie}} </div>
                <div class="table-row-data" style="width: 40%"><a href="/Liga1/public/club-info/{{$cluburiDct[$data->echipaID]}}/info"> {{$cluburiDct[$data->echipaID]}} </a></div>
                <div class="table-row-data" style="width: 10%"> {{$data->victorii}} </div>
                <div class="table-row-data" style="width: 10%"> {{$data->egaluri}} </div>
                <div class="table-row-data" style="width: 10%"> {{$data->infrangeri}} </div>
                <div class="table-row-data" style="width: 10%"> {{$data->punctaj}} </div>
            </div>
        @endforeach
        @else
        @endif
    </div>
</div>

@include('footer')