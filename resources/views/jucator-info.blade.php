@include('header')

<div class="player-index-content">
    <div class="player-header">
        <div class="player-header-column" style="width: 18%">
            <img alt="{{$jucator->numeJucator}}" src="/Liga1/public/images/players/{{$jucator->numeJucator}}.png" onerror="this.onerror=null; this.src='/Liga1/public/images/players/face-icon.png'">
        </div>
        <div class="player-header-column" style="flex-direction: column; width: 26%">
            <h2>{{$jucator->numeJucator}} #{{$jucator->numar}}</h2>
            <h3>Echipă actuală: <a href="/Liga1/public/club-info/{{$jucator->numeEchipa}}/info">{{$jucator->numeEchipa}}</a></h3>
        </div>
        <div class="player-header-column" style="flex-direction: column; width: 20%">
            <h3>Vârstă: {{$jucator->varsta}}</h3>
            <h3>Poziție: {{$jucator->pozitie}}</h3>
            <h3>Înălțime: {{$jucator->inaltime}} cm</h3>
            <h3>Greutate: {{$jucator->greutate}} kg</h3>
            <h3>Naționalitate: {{$jucator->nationalitate}}</h3>
        </div>
        <div class="player-header-column" style="width: 20%">
            <div class="buttons-section">
                <div class="button-section">
                    <a href="/Liga1/public/jucator-info/{{$jucator->numeEchipa}}/{{$jucator->numeJucator}}/statistici-generale"><button> Statistici generale </button></a>
                </div>
                <div class="button-section">
                    <a href="/Liga1/public/jucator-info/{{$jucator->numeEchipa}}/{{$jucator->numeJucator}}/sezon-regulat"><button> Statistici sezon regulat </button></a>
                </div>
                <div class="button-section">
                    <a href="/Liga1/public/jucator-info/{{$jucator->numeEchipa}}/{{$jucator->numeJucator}}/play-off-out"><button> Statistici Play Off/Play Out </button></a>
                </div>
            </div>
        </div>
    </div>
    <div class="player-stats-content">
        @if($faza == 'statistici-generale' || $faza == 'sezon-regulat')
            <div class="player-minutes-played-content">
                <h1>Minute jucate - Sezon regulat</h1>
                @if($jucator->minuteJucateSezonRegulat)
                    @foreach($jucator->minuteJucateSezonRegulat as $nrEtapa => $minuteJucate)
                        <div class="stage-section">
                            <h4>Etapa: {{$nrEtapa}}</h4>
                            <div class="chart" style="height: {{45 - (90 - $minuteJucate)/2}}px; margin-top: {{(90 - $minuteJucate)/2}}px"></div>
                            <h4>Minute: {{$minuteJucate}}</h4>
                        </div>
                    @endforeach
                @else
                    <h3 style="margin: 0px 20px">Încă nu există etape jucate.</h3>
                @endif
            </div>
        @endif
        @if($faza == 'statistici-generale' || $faza == 'play-off-out')
            <div class="player-minutes-played-content">
                <h1>Minute jucate - Play Off/Out</h1>
                @if($jucator->minuteJucatePlayOffOut)
                    @foreach($jucator->minuteJucatePlayOffOut as $nrEtapa => $minuteJucate)
                            <div class="etapa-section">
                                <h4>Etapa: {{$nrEtapa}}</h4>
                                    <div class="grafic" style="height: {{45 - (90 - $minuteJucate)/2}}px; margin-top: {{(90 - $minuteJucate)/2}}px"></div>
                                <h4>Minute: {{$minuteJucate}}</h4>
                            </div>
                    @endforeach
                @else
                    <h2 style="text-align: center">Încă nu există etape jucate.</h2>
                @endif
            </div>
        @endif
        <div class="player-goals-section">
            <h1>Goluri totale: {{$jucator['goluri totale']}}</h1>
            <div class="player-goal-section">
                <h4>Goluri din careu: {{$jucator['goluri careu']}}</h4>
            </div>
            <div class="player-goal-section">
                <h4>Goluri din afara careului: {{$jucator['goluri distanta']}}</h4>
            </div>
            <div class="player-goal-section">
                <h4>Goluri din faza fixă: {{$jucator['goluri faza fixa']}}</h4>
            </div>
            <div class="player-goal-section">
                <h4>Goluri cu capul: {{$jucator['goluri cap']}}</h4>
            </div>
            <div class="player-goal-section">
                <h4>Goluri din penalty: {{$jucator['goluri penalty']}}</h4>
            </div>
        </div>
        <div class="player-assists-section">
            <h1>Assisturi totale: {{$jucator['assisturi totale']}}</h1>
            <div class="player-assist-section">
                <h4>Assisturi simple: {{$jucator['assisturi pasa']}}</h4>
            </div>
            <div class="player-assist-section">
                <h4>Assisturi din pasa lunga: {{$jucator['assisturi distanta']}}</h4>
            </div>
            <div class="player-assist-section">
                <h4>Assisturi din faza fixă: {{$jucator['assisturi faza fixa']}}</h4>
            </div>
            <div class="player-assist-section">
                <h4>Assisturi din corner: {{$jucator['assisturi corner']}}</h4>
            </div>
        </div>
        <div class="cards-section">
            <div class="card-section">
                <h4>Cartonase galbene: {{$jucator['cartonase galbene']}}</h4>
            </div>
            <div class="card-section">
                <h4>Cartonase rosii: {{$jucator['cartonase rosii']}}</h4>
            </div>
        </div>
    </div>
</div>

@include('footer')