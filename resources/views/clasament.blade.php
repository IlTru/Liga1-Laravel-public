@include('header')

<div class="tables-index-content">
    <h1>Clasament - {{$faza}}</h1>
    @if(isset($clasament[0]))
        @if ($clasament[0]->faza == 'sezon regulat')
        <div class="table">
            <div class="table-header">
                <div class="table-header-data" style="width: 8%"><h2>POZIȚIE</h2></div>
                <div class="table-header-data" style="width: 30%"><h2>CLUB</h2></div>
                <div class="table-header-data" style="width: 11%"><h2>VICTORII</h2></div>
                <div class="table-header-data" style="width: 11%"><h2>EGALURI</h2></div>
                <div class="table-header-data" style="width: 11%"><h2>ÎNFRÂNGERI</h2></div>
                <div class="table-header-data" style="width: 11%"><h2>PUNCTE</h2></div>
            </div>
            @foreach ($clasament as $data)
                <div class="table-row">
                    <div class="table-row-data" style="width: 8%"><h3>{{$data->pozitie}}</h3></div>
                    <div class="table-row-data" style="width: 30%"><h3><a href="/Liga1/public/club-info/{{$cluburiDct[$data->echipaID]}}/info"> {{$cluburiDct[$data->echipaID]}} </a></h3></div>
                    <div class="table-row-data" style="width: 11%"><h3>{{$data->victorii}}</h3></div>
                    <div class="table-row-data" style="width: 11%"><h3>{{$data->egaluri}}</h3></div>
                    <div class="table-row-data" style="width: 11%"><h3>{{$data->infrangeri}}</h3></div>
                    <div class="table-row-data" style="width: 11%"><h3>{{$data->punctaj}}</h3></div>
                </div>
            @endforeach
        </div>
        @else
        @endif
    @else
        <h1>Nu există înca informații despre acest clasament</h1>
    @endif
</div>

@include('footer')