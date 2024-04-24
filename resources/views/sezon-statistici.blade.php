@include('header')

<div class="season-stats-view-content">
    <div class="phase-select-section">
        <h1> Faza campionatului</h1>
        <a href="/Liga1/public/statistici/generale"><button @if($faza == 'generale') style="background:rgba(153, 205, 50, 1)" @endif> Statistici generale </button></a>
        <a href="/Liga1/public/statistici/sezon-regulat"><button @if($faza == 'sezon-regulat') style="background:rgba(153, 205, 50, 1)" @endif> Statistici Sezon Regulat </button></a>
        <a href="/Liga1/public/statistici/play-off-out"><button @if($faza == 'play-off-out') style="background:rgba(153, 205, 50, 1)" @endif> Statistici Play-Off/Play-Out </button></a>
    </div>
    <div class="stats-content">
        <h1>Statistici echipe</h1>
        <div class="table">
            <div class="table-header">
                <h2>Cele mai bune atacuri</h2>
                <h2>(goluri înscrise)</h2>
            </div>
            @if($statisticiEchipe['goluriInscriseDesc'])
                <?php $i = 1; ?>
                @foreach($statisticiEchipe['goluriInscriseDesc'] as $echipa)
                    <div class="table-row">
                        <div class="table-row-data" style="width: 8%"><h3>{{$i}}</h3></div>
                        <div class="table-row-data" style="width: 72%"><h3><a href="/Liga1/public/club-info/{{$echipa['numeEchipa']}}/info"> {{$echipa['numeEchipa']}}</a></h3> &nbsp; &nbsp; <img class="small-club-logo" src="/Liga1/public/images/clubs/{{$echipa['numeEchipa']}}.png" alt=""></div>
                        <div class="table-row-data" style="width: 8%"><h3>{{$echipa['nrGoluriInscrise']}}</h3></div>
                    </div>
                    <?php $i++; ?>
                @endforeach
            @endif
        </div>
        <div class="table">
            <div class="table-header">
                <h2>Cele mai slabe atacuri</h2>
                <h2>(goluri înscrise)</h2>
            </div>
            @if($statisticiEchipe['goluriInscriseAsc'])
                <?php $i = 1; ?>
                @foreach($statisticiEchipe['goluriInscriseAsc'] as $echipa)
                    <div class="table-row">
                        <div class="table-row-data" style="width: 8%"><h3>{{$i}}</h3></div>
                        <div class="table-row-data" style="width: 72%"><h3><a href="/Liga1/public/club-info/{{$echipa['numeEchipa']}}/info"> {{$echipa['numeEchipa']}} </a></h3> &nbsp; &nbsp; <img class="small-club-logo" src="/Liga1/public/images/clubs/{{$echipa['numeEchipa']}}.png" alt=""></div>
                        <div class="table-row-data" style="width: 8%"><h3>{{$echipa['nrGoluriInscrise']}}</h3></div>
                    </div>
                    <?php $i++; ?>
                @endforeach
            @endif
        </div>
    </div>
    <div class="stats-content">
        <div class="table">
            <div class="table-header">
                <h2>Cele mai bune apărări</h2>
                <h2>(goluri primite)</h2>
            </div>
            @if($statisticiEchipe['goluriPrimiteAsc'])
                <?php $i = 1; ?>
                @foreach($statisticiEchipe['goluriPrimiteAsc'] as $echipa)
                    <div class="table-row">
                        <div class="table-row-data" style="width: 8%"><h3>{{$i}}</h3></div>
                        <div class="table-row-data" style="width: 72%"><h3><a href="/Liga1/public/club-info/{{$echipa['numeEchipa']}}/info">{{$echipa['numeEchipa']}}</a></h3> &nbsp; &nbsp; <img class="small-club-logo" src="/Liga1/public/images/clubs/{{$echipa['numeEchipa']}}.png" alt=""></div>
                        <div class="table-row-data" style="width: 8%"><h3>{{$echipa['nrGoluriPrimite']}}</h3></div>
                    </div>
                    <?php $i++; ?>
                @endforeach
            @endif
        </div>
        <div class="table">
            <div class="table-header">
                <h2>Cele mai slabe apărări</h2>
                <h2>(goluri primite)</h2>
            </div>
            @if($statisticiEchipe['goluriPrimiteDesc'])
                <?php $i = 1; ?>
                @foreach($statisticiEchipe['goluriPrimiteDesc'] as $echipa)
                    <div class="table-row">
                        <div class="table-row-data" style="width: 8%"><h3>{{$i}}</h3></div>
                        <div class="table-row-data" style="width: 72%"><h3><a href="/Liga1/public/club-info/{{$echipa['numeEchipa']}}/info">{{$echipa['numeEchipa']}}</a></h3> &nbsp; &nbsp; <img class="small-club-logo" src="/Liga1/public/images/clubs/{{$echipa['numeEchipa']}}.png" alt=""></div>
                        <div class="table-row-data" style="width: 8%"><h3>{{$echipa['nrGoluriPrimite']}}</h3></div>
                    </div>
                    <?php $i++; ?>
                @endforeach
            @endif
        </div>
    </div>
    <div class="stats-content">
        <div class="table">
            <div class="table-header">
                <h2>Cele mai mari medii (goluri)</h2>
                <h2>Număr goluri înscrise/număr goluri primite</h2>
            </div>
            @if($statisticiEchipe['medieGoluriDesc'])
                <?php $i = 1; ?>
                @foreach($statisticiEchipe['medieGoluriDesc'] as $echipa)
                    <div class="table-row">
                        <div class="table-row-data" style="width: 8%"><h3>{{$i}}</h3></div>
                        <div class="table-row-data" style="width: 72%"><h3><a href="/Liga1/public/club-info/{{$echipa['numeEchipa']}}/info">{{$echipa['numeEchipa']}}</a></h3> &nbsp; &nbsp; <img class="small-club-logo" src="/Liga1/public/images/clubs/{{$echipa['numeEchipa']}}.png" alt=""></div>
                        <div class="table-row-data" style="width: 8%"><h3>{{$echipa['medieGoluri']}}</h3></div>
                    </div>
                    <?php $i++; ?>
                @endforeach
            @endif
        </div>
        <div class="table">
            <div class="table-header">
                <h2>Cele mai mici medii (goluri)</h2>
                <h2>Număr goluri înscrise/număr goluri primite</h2>
            </div>
            @if($statisticiEchipe['medieGoluriAsc'])
                <?php $i = 1; ?>
                @foreach($statisticiEchipe['medieGoluriAsc'] as $echipa)
                    <div class="table-row">
                        <div class="table-row-data" style="width: 8%"><h3>{{$i}}</h3></div>
                        <div class="table-row-data" style="width: 72%"><h3><a href="/Liga1/public/club-info/{{$echipa['numeEchipa']}}/info">{{$echipa['numeEchipa']}}</a></h3> &nbsp; &nbsp; <img class="small-club-logo" src="/Liga1/public/images/clubs/{{$echipa['numeEchipa']}}.png" alt=""></div>
                        <div class="table-row-data" style="width: 8%"><h3>{{$echipa['medieGoluri']}}</h3></div>
                    </div>
                    <?php $i++; ?>
                @endforeach
            @endif
        </div>
    </div>
    <div class="stats-content">
        <h1>Statistici jucatori</h1>
        <div class="table">
            <div class="table-header">
                <h2>Top marcatori</h2>
            </div>
            @if($statisticiJucatori['marcatori'])
                <?php $i = 1; ?>
                @foreach($statisticiJucatori['marcatori'] as $jucator)
                    <div class="table-row">
                        <div class="table-row-data" style="width: 8%"><h3>{{$i}}</h3></div>
                        <div class="table-row-data" style="width: 72%"><h3><a href="/Liga1/public/jucator-info/{{$jucator['numeEchipa']}}/{{$jucator['numeJucator']}}/statistici-generale">{{$jucator['numeJucator']}}</a></h3> &nbsp; &nbsp; <img class="small-club-logo" src="/Liga1/public/images/clubs/{{$jucator['numeEchipa']}}.png" alt=""></div>
                        <div class="table-row-data" style="width: 8%"><h3>{{$jucator['nrGoluri']}}</h3></div>
                    </div>
                    <?php $i++; ?>
                @endforeach
            @endif
        </div>
        <div class="table">
            <div class="table-header">
                <h2>Top assists</h2>
            </div>
            @if($statisticiJucatori['assistman'])
                <?php $i = 1; ?>
                @foreach($statisticiJucatori['assistman'] as $jucator)
                    <div class="table-row">
                        <div class="table-row-data" style="width: 8%"><h3>{{$i}}</h3></div>
                        <div class="table-row-data" style="width: 72%"><h3><a href="/Liga1/public/jucator-info/{{$jucator['numeEchipa']}}/{{$jucator['numeJucator']}}/statistici-generale">{{$jucator['numeJucator']}}</a></h3> &nbsp; &nbsp; <img class="small-club-logo" src="/Liga1/public/images/clubs/{{$jucator['numeEchipa']}}.png" alt=""></div>
                        <div class="table-row-data" style="width: 8%"><h3>{{$jucator['nrAssisturi']}}</h3></div>
                    </div>
                    <?php $i++; ?>
                @endforeach
            @endif
        </div>
    </div>
</div>

@include('footer')