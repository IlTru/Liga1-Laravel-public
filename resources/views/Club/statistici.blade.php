@include('club/header')
    <div class="club-stats-content">
        <div class="phase-select-section">
            <a href="/Liga1/public/club-info/{{$club->numeEchipa}}/statistici/generale"><button @if($faza == 'generale') style="background:rgba(153, 205, 50, 1)" @endif> Statistici Generale </button></a>
            <a href="/Liga1/public/club-info/{{$club->numeEchipa}}/statistici/sezon-regulat"><button @if($faza == 'sezon-regulat') style="background:rgba(153, 205, 50, 1)" @endif> Statistici Sezon Regulat </button></a>
            <a href="/Liga1/public/club-info/{{$club->numeEchipa}}/statistici/play-off-out"><button @if($faza == 'play-off-out') style="background:rgba(153, 205, 50, 1)" @endif> Statistici Play Off/Out </button></a>
        </div>

        <h1>Goluri totale: {{$club['goluriTotale']}} - Goluri/meci: {{$club['goluriPeMeci']}} <br> Medie goluri totale (toate echipele): {{$statistici['medieGoluri']}}</h1>
        
        <div class="club-goals-section">
            <div class="club-goal-section">
                <h3>Goluri din careu: {{$club['goluriCareu']}}</h3>
            </div>
            <div class="club-goal-section">
                <h3>Goluri din afara careului: {{$club['goluriDistanta']}}</h3>
            </div>
            <div class="club-goal-section">
                <h3>Goluri din faza fixă: {{$club['goluriFazaFixa']}}</h3>
            </div>
            <div class="club-goal-section">
                <h3>Goluri cu capul: {{$club['goluriCap']}}</h3>
            </div>
            <div class="club-goal-section">
                <h3>Goluri din penalty: {{$club['goluriPenalty']}}</h3>
            </div>
        </div>

        <div class="club-goals-chart-section">
            <canvas id="goluriChart" data-data="[{{$club['goluriCareu']}}, {{$club['goluriDistanta']}}, {{$club['goluriFazaFixa']}}, {{$club['goluriCap']}}, {{$club['goluriPenalty']}}]"></canvas>
        </div>

        <h1> Cartonase </h1>
        <div class="stats-section">
            <div class="card-section">
                <h3>Total cartonase galbene: {{$club['cartonaseGalbene']}} - Cartonase galbene/meci: {{$club['cartonaseGalbenePeMeci']}}</h3>
            </div>
            <div class="card-section">
                <h3>Total cartonase rosii: {{$club['cartonaseRosii']}} - Cartonase rosii/meci: {{$club['cartonaseRosiiPeMeci']}}</h3>
            </div>
        </div>
        <h1> Alte statistici </h1>

        <div class="stats-section">
            <div class="other-stats-section">
                <h2>Medie suturi/meci: {{$club['suturiPeMeci']}}</h2>
            </div>
            <div class="other-stats-section">
                <h2>Procentaj realizări: {{$club['medieRealizari']}} </h2>
            </div>
            <div class="other-stats-section">
                <h2>Procentaj concretizari: {{$club['suturiPeMeci']}}</h2>
            </div>
            <div class="other-stats-section">
                <h2>Medie posesie/meci: {{$club['posesieMediePeMeci']}}</h2>
            </div>
            <div class="other-stats-section">
                <h2>Medie pase/meci: {{$club['mediePasePeMeci']}}</h2>
            </div>
            <div class="other-stats-section">
                <h2>Medie faulturi/meci: {{$club['medieFaulturiPeMeci']}}</h2>
            </div>
            <div class="other-stats-section" style="width: 47%">
                <h2>Medie deposedari/meci: {{$club['medieDeposedariPeMeci']}}</h2>
            </div>
            <div class="other-stats-section" style="width: 47%">
                <h2>Medie cornere/meci: {{$club['medieCornerePeMeci']}}</h2>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.2.1/dist/chart.umd.min.js"></script>
<script src="/Liga1/public/js/goluriChart.js"></script>

@include('footer')