@include('header')

<div class="matches-index-content">
    <div class="phase-select-section">
        <h1> Faza campionatului</h1>
        <a href="/Liga1/public/meciuri/sezon regulat"><button @if($faza == 'sezon regulat') style="background:rgba(153, 205, 50, 1)" @endif> Sezon Regulat </button></a>
        <a href="/Liga1/public/meciuri/play off"><button @if($faza == 'play off') style="background:rgba(153, 205, 50, 1)" @endif> Play Off </button></a>
        <a href="/Liga1/public/meciuri/play out"><button @if($faza == 'play out') style="background:rgba(153, 205, 50, 1)" @endif> Play Out </button></a>
    </div>
    <div class="stage-select-section">
        <h1> Etapa </h1>
        @if($faza == 'sezon regulat')
            @for($i = 1; $i <=30; $i++)
                <a href="/Liga1/public/meciuri/{{$faza}}/{{$i}}"><button @if(isset($meciuri[0]->nrEtapa) && $meciuri[0]->nrEtapa == $i) style="background:rgba(153, 205, 50, 1)" @endif> {{$i}} </button></a>
            @endfor
        @elseif($faza == 'play off')
            @for($i = 1; $i <=10; $i++)
                <a href="/Liga1/public/meciuri/{{$faza}}/{{$i}}"><button @if(isset($meciuri[0]->nrEtapa) && $meciuri[0]->nrEtapa == $i) style="background:rgba(153, 205, 50, 1)" @endif> {{$i}} </button></a>
            @endfor
        @elseif($faza == 'play out')
            @for($i = 1; $i <=9; $i++)
                <a href="/Liga1/public/meciuri/{{$faza}}/{{$i}}"><button @if(isset($meciuri[0]->nrEtapa) && $meciuri[0]->nrEtapa == $i) style="background:rgba(153, 205, 50, 1)" @endif> {{$i}} </button></a>
            @endfor
        @endif
    </div>
    <div class="matches-content">
        @if(isset($meciuri[0]))
            <h1> {{str($faza)->title()}} - etapa {{$meciuri[0]->nrEtapa}} </h1>
            <div class="table">
                <div class="table-header">
                    <div class="table-header-data" style="width: 13%"><h2>DATA</h2></div>
                    <div class="table-header-data" style="width: 60%"><h2>REZULTAT</h2></div>
                    <div class="table-header-data" style="width: 18%"><h2>STATISTICI</h2></div>
                </div>
                @foreach ($meciuri as $meci)
                    <div class="table-row">
                        <div class="table-row-data" style="width: 13%"><h3>{{date('d-m-y H:i', strtotime($meci->data));}}</h3></div>
                        <div class="table-row-data" style="width: 60%; font-size: 110%"><h3><div class="club-host"><a href="/Liga1/public/club-info/{{$cluburiDct[$meci->echipaGazdaID]}}/info"> {{$cluburiDct[$meci->echipaGazdaID]}} </a></div> <div class="score">@if($meci->disputat){{$meci->goluriEG}}@endif - @if($meci->disputat){{$meci->goluriEO}}@endif</div> <div class="club-guest"><a href="/Liga1/public/club-info/{{$cluburiDct[$meci->echipaOaspeteID]}}/info"> {{$cluburiDct[$meci->echipaOaspeteID]}} </a></div></h3></div>
                        <div class="table-row-data" style="width: 18%"><a href="/Liga1/public/meci/{{$meci->id}}/info"><button>Statistici</button></a></div>
                    </div>
                @endforeach
            </div>
        @else
            <h1>Nu exista încă informații.</h1>
        @endif
    </div>
</div>

@include('footer')