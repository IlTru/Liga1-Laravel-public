@include('Statistici meci/header')
    <div class="match-stats-lineups-content">
        <div class="table">
            <div class="table-row">
                <div class="table-row-data"><img class="club-logo" src="/Liga1/public/images/clubs/{{$meci->echipaGazda->numeEchipa}}.png" alt=""></div>
                <div class="table-row-data"><h1>Titulari</h1></div>
                <div class="table-row-data"><img class="club-logo" src="/Liga1/public/images/clubs/{{$meci->echipaOaspete->numeEchipa}}.png" alt=""></div>
            </div>
            @for($i = 0; $i <11; $i++)
                <div class="table-row">
                    <div class="table-row-data">
                        @if (isset($loturi[$meci->echipaGazda->numeEchipa]['titulari'][$i])) <img class="player-img" src="/Liga1/public/images/players/{{$jucatori[$loturi[$meci->echipaGazda->numeEchipa]['titulari'][$i]]}}.png" onerror="this.onerror=null; this.src='/Liga1/public/images/players/face-icon.png'" alt="">
                        <a href="/Liga1/public/jucator-info/{{$meci->echipaGazda->numeEchipa}}/{{$jucatori[$loturi[$meci->echipaGazda->numeEchipa]['titulari'][$i]]}}/statistici-generale"><h1>{{$jucatori[$loturi[$meci->echipaGazda->numeEchipa]['titulari'][$i]]}}</h1></a> @endif
                    </div>
                    <div class="table-row-data"></div>
                    <div class="table-row-data">
                        @if (isset($loturi[$meci->echipaOaspete->numeEchipa]['titulari'][$i])) <img class="player-img" src="/Liga1/public/images/players/{{$jucatori[$loturi[$meci->echipaOaspete->numeEchipa]['titulari'][$i]]}}.png" onerror="this.onerror=null; this.src='/Liga1/public/images/players/face-icon.png'" alt="">
                        <a href="/Liga1/public/jucator-info/{{$meci->echipaOaspete->numeEchipa}}/{{$jucatori[$loturi[$meci->echipaOaspete->numeEchipa]['titulari'][$i]]}}/statistici-generale"><h1>{{$jucatori[$loturi[$meci->echipaOaspete->numeEchipa]['titulari'][$i]]}}</h1></a> @endif
                    </div>
                </div>
            @endfor

            <div class="table-row">
            </div>

            <div class="table-row">
                <div class="table-row-data"><img class="club-logo" src="/Liga1/public/images/clubs/{{$meci->echipaGazda->numeEchipa}}.png" alt=""></div>
                <div class="table-row-data"><h1>Rezerve</h1></div>
                <div class="table-row-data"><img class="club-logo" src="/Liga1/public/images/clubs/{{$meci->echipaOaspete->numeEchipa}}.png" alt=""></div>
            </div>
            @for($i = 0; $i <9; $i++)
                <div class="table-row">
                    <div class="table-row-data">
                        @if (isset($loturi[$meci->echipaGazda->numeEchipa]['rezerve'][$i])) <img class="player-img" src="/Liga1/public/images/players/{{$jucatori[$loturi[$meci->echipaGazda->numeEchipa]['rezerve'][$i]]}}.png" onerror="this.onerror=null; this.src='/Liga1/public/images/players/face-icon.png'" alt="">
                        <a href="/Liga1/public/jucator-info/{{$meci->echipaGazda->numeEchipa}}/{{$jucatori[$loturi[$meci->echipaGazda->numeEchipa]['rezerve'][$i]]}}/statistici-generale"><h1>{{$jucatori[$loturi[$meci->echipaGazda->numeEchipa]['rezerve'][$i]]}}</h1></a> @endif
                    </div>
                    <div class="table-row-data"></div>
                    <div class="table-row-data">
                        @if (isset($loturi[$meci->echipaOaspete->numeEchipa]['rezerve'][$i])) <img class="player-img" src="/Liga1/public/images/players/{{$jucatori[$loturi[$meci->echipaOaspete->numeEchipa]['rezerve'][$i]]}}.png" onerror="this.onerror=null; this.src='/Liga1/public/images/players/face-icon.png'" alt="">
                        <a href="/Liga1/public/jucator-info/{{$meci->echipaOaspete->numeEchipa}}/{{$jucatori[$loturi[$meci->echipaOaspete->numeEchipa]['rezerve'][$i]]}}/statistici-generale"><h1>{{$jucatori[$loturi[$meci->echipaOaspete->numeEchipa]['rezerve'][$i]]}}</h1></a> @endif
                    </div>
                </div>
            @endfor
        </div>
    </div>
</div>
@include('footer')