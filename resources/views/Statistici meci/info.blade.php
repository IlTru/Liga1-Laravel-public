@include('Statistici meci/header')
    <div class="match-stats-info-content">
        @if($statistici)
            <div class="table">
                <div class="table-row">
                    <div class="table-row-data"><img class="club-logo" src="/Liga1/public/images/clubs/{{$meci->echipaGazda->numeEchipa}}.png" alt=""></div>
                    <div class="table-row-data"><h1>Statistici</h1></div>
                    <div class="table-row-data"><img class="club-logo" src="/Liga1/public/images/clubs/{{$meci->echipaOaspete->numeEchipa}}.png" alt=""></div>
                </div>
                <div class="table-row">
                    <div class="table-row-data"><h1>{{$statistici->suturiEG}}</h1></div>
                    <div class="table-row-data"><h1>Suturi</h1></div>
                    <div class="table-row-data"><h1>{{$statistici->suturiEO}}</h1></div>
                </div>
                <div class="table-row">
                    <div class="table-row-data"><h1>{{$statistici->suturiPePoartaEG}}</h1></div>
                    <div class="table-row-data"><h1>Suturi pe poarta</h1></div>
                    <div class="table-row-data"><h1>{{$statistici->suturiPePoartaEO}}</h1></div>
                </div>
                <div class="table-row">
                    <div class="table-row-data"><h1>{{$statistici->posesieEG}}</h1></div>
                    <div class="table-row-data"><h1>Posesie</h1></div>
                    <div class="table-row-data"><h1>{{$statistici->posesieEO}}</h1></div>
                </div>
                <div class="table-row">
                    <div class="table-row-data"><h1>{{$statistici->cartonaseGalbeneEG}}</h1></div>
                    <div class="table-row-data"><h1>Cartonase galbene</h1></div>
                    <div class="table-row-data"><h1>{{$statistici->cartonaseGalbeneEO}}</h1></div>
                </div>
                <div class="table-row">
                    <div class="table-row-data"><h1>{{$statistici->cartonaseRosiiEG}}</h1></div>
                    <div class="table-row-data"><h1>Cartonase rosii</h1></div>
                    <div class="table-row-data"><h1>{{$statistici->cartonaseRosiiEO}}</h1></div>
                </div>
                <div class="table-row">
                    <div class="table-row-data"><h1>{{$statistici->totalPaseEG}}</h1></div>
                    <div class="table-row-data"><h1>Pase</h1></div>
                    <div class="table-row-data"><h1>{{$statistici->totalPaseEO}}</h1></div>
                </div>
                <div class="table-row">
                    <div class="table-row-data"><h1>{{$statistici->faulturiEG}}</h1></div>
                    <div class="table-row-data"><h1>Faulturi</h1></div>
                    <div class="table-row-data"><h1>{{$statistici->faulturiEO}}</h1></div>
                </div>
                <div class="table-row">
                    <div class="table-row-data"><h1>{{$statistici->deposedariEG}}</h1></div>
                    <div class="table-row-data"><h1>Deposedari</h1></div>
                    <div class="table-row-data"><h1>{{$statistici->deposedariEO}}</h1></div>
                </div>
                <div class="table-row">
                    <div class="table-row-data"><h1>{{$statistici->cornereEG}}</h1></div>
                    <div class="table-row-data"><h1>Cornere</h1></div>
                    <div class="table-row-data"><h1>{{$statistici->cornereEO}}</h1></div>
                </div>
            </div>
        @else
            <h1>Statisticile acestui meci nu s-au adăugat încă. Reîncercați mai târziu</h1>
        @endif
    </div>
@include('footer')