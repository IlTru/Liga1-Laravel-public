@include('header')

<div class="match-stats-content">
    <div class="match-stats-header">
        <div class="match-stats-info">
            <h1 class="title">{{str($meci->faza)->title()}} - Etapa: {{$meci->nrEtapa}}</h1>
            <div class="match-stats-title">
                <div class="club-logo"><img src="/Liga1/public/images/clubs/{{$meci->echipaGazda->numeEchipa}}.png" alt=""></div>
                <div class="score"><h1><a href="/Liga1/public/club-info/{{$meci->echipaGazda->numeEchipa}}/info">{{$meci->echipaGazda->numeEchipa}}</a> {{$meci->goluriEG}} - {{$meci->goluriEO}} <a href="/Liga1/public/club-info/{{$meci->echipaOaspete->numeEchipa}}/info">{{$meci->echipaOaspete->numeEchipa}}</a></h1></div>
                <div class="club-logo"><img src="/Liga1/public/images/clubs/{{$meci->echipaOaspete->numeEchipa}}.png" alt=""></div>
            </div>
            <h1 class="title">Data: {{date("d-m-Y", strtotime($meci->data))}} Ora: {{date("H:i", strtotime($meci->data))}}</h1>
        </div>
        <div class="match-stats-menu">
            <a href="/Liga1/public/meci/{{$meci->id}}/info"><button> Statistici generale </button></a>
            <a href="/Liga1/public/meci/{{$meci->id}}/loturi"><button> Loturi </button></a>
            <a href="/Liga1/public/meci/{{$meci->id}}/evenimente"><button> Evenimente </button></a>
        </div>
    </div>  