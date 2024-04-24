@include('admin/header')

<div class="meci-statistici-view-content">
    @if($meciStatistici != null)
        <div class="table">
            <div class="table-header">
                <div class="table-header-data" style="width: 200px"><h1>Statistici meci</h1></div>
                <div class="table-header-data" style="width: 200px"><h1>{{$echipaGazda->numeEchipa}}</h1></div>
                <div class="table-header-data" style="width: 200px"><h1>{{$echipaOaspete->numeEchipa}}</h1></div>
                <button type="button" class="delete-button" style="width: 200px" onclick="if(confirm('Sunteți sigur că doriți să ștergeți înregistrarea?')){ window.location.href = '{{url('admin-statistici-delete/'.$meciStatistici->id)}}'; }"><h1>ȘTERGE</h1></button>
            </div>
            <div class="table-row">
                <div class="table-row-data" style="width: 200px"><h1>Suturi</h1></div>
                <div class="table-row-data" style="width: 200px"><h1>{{$meciStatistici->suturiEG}}</h1></div>
                <div class="table-row-data" style="width: 200px"><h1>{{$meciStatistici->suturiEO}}</h1></div>
            </div>
            <div class="table-row">
                <div class="table-row-data" style="width: 200px"><h1>Suturi pe poarta</h1></div>
                <div class="table-row-data" style="width: 200px"><h1>{{$meciStatistici->suturiPePoartaEG}}</h1></div>
                <div class="table-row-data" style="width: 200px"><h1>{{$meciStatistici->suturiPePoartaEO}}</h1></div>
            </div>
            <div class="table-row">
                <div class="table-row-data" style="width: 200px"><h1>Posesie</div>
                <div class="table-row-data" style="width: 200px"><h1>{{$meciStatistici->posesieEG}} </div>
                <div class="table-row-data" style="width: 200px"><h1>{{$meciStatistici->posesieEO}} </div>
            </div>
            <div class="table-row">
                <div class="table-row-data" style="width: 200px"><h1>Cartonase galbene</div>
                <div class="table-row-data" style="width: 200px"><h1>{{$meciStatistici->cartonaseGalbeneEG}} </div>
                <div class="table-row-data" style="width: 200px"><h1>{{$meciStatistici->cartonaseGalbeneEO}} </div>
            </div>
            <div class="table-row">
                <div class="table-row-data" style="width: 200px"><h1>Cartonase rosii</div>
                <div class="table-row-data" style="width: 200px"><h1>{{$meciStatistici->cartonaseRosiiEG}} </div>
                <div class="table-row-data" style="width: 200px"><h1>{{$meciStatistici->cartonaseRosiiEO}} </div>
            </div>
            <div class="table-row">
                <div class="table-row-data" style="width: 200px"><h1>Total pase</div>
                <div class="table-row-data" style="width: 200px"><h1>{{$meciStatistici->totalPaseEG}} </div>
                <div class="table-row-data" style="width: 200px"><h1>{{$meciStatistici->totalPaseEO}} </div>
            </div>
            <div class="table-row">
                <div class="table-row-data" style="width: 200px"><h1>Faulturi</div>
                <div class="table-row-data" style="width: 200px"><h1>{{$meciStatistici->faulturiEG}} </div>
                <div class="table-row-data" style="width: 200px"><h1>{{$meciStatistici->faulturiEO}} </div>
            </div>
            <div class="table-row">
                <div class="table-row-data" style="width: 200px"><h1>Deposedari</div>
                <div class="table-row-data" style="width: 200px"><h1>{{$meciStatistici->deposedariEG}} </div>
                <div class="table-row-data" style="width: 200px"><h1>{{$meciStatistici->deposedariEO}} </div>
            </div>
            <div class="table-row">
                <div class="table-row-data" style="width: 200px"><h1>Cornere</div>
                <div class="table-row-data" style="width: 200px"><h1>{{$meciStatistici->cornereEG}} </div>
                <div class="table-row-data" style="width: 200px"><h1>{{$meciStatistici->cornereEO}} </div>
            </div>
        </div>
    @else
        <h3>Nu au fost adaugate inca.</h3> @endif

    <h3>Goluri si assisturi:</h3>
    
    @if(count($goluriAssisturi))
    <div class="table">
        <div class="table-header">
            <div class="table-header-data" style="width: 200px"><h1>Gol sau Assist</h1></div>
            <div class="table-header-data" style="width: 200px"><h1>Echipa</h1></div>
            <div class="table-header-data" style="width: 200px"><h1>Jucator</h1></div>
            <div class="table-header-data" style="width: 200px"><h1>Minut</h1></div>
            <div class="table-header-data" style="width: 200px"><h1>Tip</h1></div>
        </div>
        @foreach($goluriAssisturi as $ga)
                <div class="table-row">
                    <div class="table-row-data" style="width: 200px"><h1>@if($ga->golSauAssist) Gol @else Assist @endif </h1></div>
                    <div class="table-row-data" style="width: 200px"><h1> @if($ga->echipaID == $echipaGazda->id) {{$echipaGazda->numeEchipa}} @else {{$echipaOaspete->numeEchipa}} @endif </h1></div>
                    <div class="table-row-data" style="width: 200px"><h1> {{$jucatori[$ga->jucatorID]}} </h1></div>
                    <div class="table-row-data" style="width: 200px"><h1> {{$ga->minut}} </h1></div>
                    <div class="table-row-data" style="width: 200px"><h1> {{$ga->tip}} </h1></div>
                    <button type="button" class="delete-button" style="width: 200px" onclick="if(confirm('Sunteți sigur că doriți să ștergeți înregistrarea?')){ window.location.href = '{{url('admin-goluri-assisturi-delete/'.$ga->id)}}'; }"><h1>ȘTERGE</h1></button>
        </div>
        @endforeach
    </div>
    @else <h3>Nu au fost adaugate inca.</h3> @endif

    <h3>Cartonase:</h3>
    @if(count($cartonase))
    <div class="table">
        <div class="table-header">
            <div class="table-header-data" style="width: 200px"><h1>Culoare</h1></div>
            <div class="table-header-data" style="width: 200px"><h1>Echipa</h1></div>
            <div class="table-header-data" style="width: 200px"><h1>Jucator</h1></div>
            <div class="table-header-data" style="width: 200px"><h1>Minut</h1></div>
        </div>
        @foreach($cartonase as $cartonas)
            <div class="table-row">
                <div class="table-row-data" style="width: 200px"><h1> @if($cartonas->culoareCartonas) Rosu @else Galben @endif </h1></div>
                <div class="table-row-data" style="width: 200px"><h1> @if($cartonas->echipaID == $echipaGazda->id) {{$echipaGazda->numeEchipa}} @else {{$echipaOaspete->numeEchipa}} @endif </h1></div>
                <div class="table-row-data" style="width: 200px"><h1> {{$jucatori[$cartonas->jucatorID]}} </h1></div>
                <div class="table-row-data" style="width: 200px"><h1> {{$cartonas->minut}} </h1></div>
                <button type="button" class="delete-button" style="width: 200px" onclick="if(confirm('Sunteți sigur că doriți să ștergeți înregistrarea?')){ window.location.href = '{{url('admin-cartonase-delete/'.$cartonas->id)}}'; }"><h1>ȘTERGE</h1></button>
            </div>
        @endforeach
    </div>
    @else <h3>Nu au fost adaugate inca.</h3> @endif

    <h3>Schimbari:</h3>
    @if(count($schimbari))
    <div class="table">
        <div class="table-header">
            <div class="table-header-data" style="width: 200px"><h1>Jucator schimbat</h1></div>
            <div class="table-header-data" style="width: 200px"><h1>Jucator intrat</h1></div>
            <div class="table-header-data" style="width: 200px"><h1>Minut</h1></div>
        </div>
        @foreach($schimbari as $schimbare)
            <div class="table-row">
                <div class="table-row-data" style="width: 200px"><h1>{{$jucatori[$schimbare->jucatorSchimbatID]}}</h1></div>
                <div class="table-row-data" style="width: 200px"><h1>{{$jucatori[$schimbare->jucatorIntratID]}}</h1></div>
                <div class="table-row-data" style="width: 200px"><h1>{{$schimbare->minut}}</h1></div>
                <button type="button" class="delete-button" style="width: 200px" onclick="if(confirm('Sunteți sigur că doriți să ștergeți înregistrarea?')){ window.location.href = '{{url('admin-schimbari-delete/'.$schimbare->id)}}'; }"><h1>ȘTERGE</h1></button>
            </div>
        @endforeach
    </div>
    @else <h3>Nu au fost adaugate inca.</h3> @endif

    <h3>Loturi:</h3>
    @if(count($loturi))
    <div class="table">
        <div class="table-header">
            <div class="table-header-data" style="width: 200px"><h1>Echipa</h1></div>
            <div class="table-header-data" style="width: 200px"><h1>Jucator</h1></div>
            <div class="table-header-data" style="width: 200px"><h1>Situatie</h1></div>
            <button type="button" class="delete-button" style="width: 200px" onclick="if(confirm('Sunteți sigur că doriți să ștergeți înregistrările?')){ window.location.href = '{{url('admin-loturi-delete/'.$meciID)}}'; }"><h1>ȘTERGE</h1></button>
        </div>
        @foreach($loturi as $lot)
            <div class="table-row">
                <div class="table-row-data" style="width: 200px"><h1> @if($lot->echipaID == $echipaGazda->id) {{$echipaGazda->numeEchipa}} @else {{$echipaOaspete->numeEchipa}} @endif </h1></div>
                <div class="table-row-data" style="width: 200px"><h1> {{$jucatori[$lot->jucatorID]}} </h1></div>
                <div class="table-row-data" style="width: 200px"><h1> {{$lot->situatie}} </h1></div>
            </div>
        @endforeach
    </div>
    @else <h3>Nu au fost adaugate inca.</h3> @endif

</div>

@include('admin/footer')