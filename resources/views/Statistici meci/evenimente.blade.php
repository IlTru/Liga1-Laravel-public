@include('Statistici meci/header')
    <div class="meci-stats-events-content">
        <div class="table">
            @foreach ($evenimente as $eveniment)
                @if($eveniment['eveniment'] == 'gol')
                    <div class="table-row">
                        <div class="table-row-data" style="width: 10%; padding-top: 5px;">
                            @if($eveniment['echipaID'] == $meci->echipaGazda->id)
                                <img class="club-logo" src="/Liga1/public/images/clubs/{{$meci->echipaGazda->numeEchipa}}.png" alt="">
                            @else
                                <img class="club-logo" src="/Liga1/public/images/clubs/{{$meci->echipaOaspete->numeEchipa}}.png" alt="">
                            @endif
                        </div>
                        <div class="table-row-data" style="width: 10%">
                            <img class="event-logo" src="/Liga1/public/images/other/goal-icon.png" alt="">
                        </div>
                        <div class="table-row-data" style="width: 60%">
                            <a href="/Liga1/public/jucator-info/@if($eveniment['echipaID'] == $meci->echipaGazda->id){{$meci->echipaGazda->numeEchipa}} @else{{$meci->echipaOaspete->numeEchipa}} @endif/{{$jucatori[$eveniment['jucatorID']]}}/statistici-generale"><h2>{{$jucatori[$eveniment['jucatorID']]}}</h2></a>
                        </div>
                        <div class="table-row-data" style="width: 10%">
                            <h2>{{$eveniment['minut']}}'</h2>
                        </div>
                    </div>
                    <br>
                @elseif($eveniment['eveniment'] == 'cartonasGalben' || $eveniment['eveniment'] == 'cartonasRosu')
                    <div class="table-row">
                        <div class="table-row-data" style="width: 10%; padding-top: 5px;">
                            @if($eveniment['echipaID'] == $meci->echipaGazda->id)
                                <img class="club-logo" src="/Liga1/public/images/clubs/{{$meci->echipaGazda->numeEchipa}}.png" alt="">
                            @else
                                <img class="club-logo" src="/Liga1/public/images/clubs/{{$meci->echipaOaspete->numeEchipa}}.png" alt="">
                            @endif
                        </div>
                        <div class="table-row-data" style="width: 10%">
                            @if($eveniment['eveniment'] == 'cartonasGalben')
                                <img class="event-logo" src="/Liga1/public/images/other/yellow-card-icon.png" alt="">
                            @elseif($eveniment['eveniment'] == 'cartonasRosu')
                                <img class="event-logo" src="/Liga1/public/images/other/red-card-icon.png" alt="">
                            @endif
                        </div>
                        <div class="table-row-data" style="width: 60%">
                            <a href="/Liga1/public/jucator-info/@if($eveniment['echipaID'] == $meci->echipaGazda->id){{$meci->echipaGazda->numeEchipa}} @else{{$meci->echipaOaspete->numeEchipa}} @endif/{{$jucatori[$eveniment['jucatorID']]}}/statistici-generale"><h2>{{$jucatori[$eveniment['jucatorID']]}}</h2></a>
                        </div>
                        <div class="table-row-data" style="width: 10%">
                            <h2>{{$eveniment['minut']}}'</h2>
                        </div>
                    </div>
                    <br>
                @elseif($eveniment['eveniment'] == 'schimbare')
                    <div class="table-row">
                        <div class="table-row-data" style="width: 10%; padding-top: 5px;">
                            @if($eveniment['echipaID'] == $meci->echipaGazda->id)
                                <img class="club-logo" src="/Liga1/public/images/clubs/{{$meci->echipaGazda->numeEchipa}}.png" alt="">
                            @else
                                <img class="club-logo" src="/Liga1/public/images/clubs/{{$meci->echipaOaspete->numeEchipa}}.png" alt="">
                            @endif
                        </div>
                        <div class="table-row-data" style="width: 10%">
                            <img class="event-logo" src="/Liga1/public/images/other/substitute-icon.png" alt="">
                        </div>
                        <div class="table-row-data" style="width: 60%">
                            <h2 style="height:40%; margin: 5px 0px;">Intrat: <a href="/Liga1/public/jucator-info/@if($eveniment['echipaID'] == $meci->echipaGazda->id){{$meci->echipaGazda->numeEchipa}} @else{{$meci->echipaOaspete->numeEchipa}} @endif/{{$jucatori[$eveniment['jucatorIntratID']]}}/statistici-generale">{{$jucatori[$eveniment['jucatorIntratID']]}}</a></h2>
                            <h2 style="height:40%; margin: 5px 0px;">Schimbat: <a href="/Liga1/public/jucator-info/@if($eveniment['echipaID'] == $meci->echipaGazda->id){{$meci->echipaGazda->numeEchipa}} @else{{$meci->echipaOaspete->numeEchipa}} @endif/{{$jucatori[$eveniment['jucatorSchimbatID']]}}/statistici-generale">{{$jucatori[$eveniment['jucatorSchimbatID']]}}</a></h2>
                        </div>
                        <div class="table-row-data" style="width: 10%">
                            <h2>{{$eveniment['minut']}}'</h2>
                        </div>
                    </div>
                    <br>
                @endif
            @endforeach
        </div>
    </div>
</div>
@include('footer')