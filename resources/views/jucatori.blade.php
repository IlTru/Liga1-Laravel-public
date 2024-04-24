<?php //ddd($players); ?> @include('header')

<div class="players-view-content">
    <div class="players-filters-content">
        <div class="buttons-section">
                <button type="button" id="button-order-section"> SORTARE </button>
                <button type="button" id="button-search-section"> CĂUTARE </button>
                <button type="button" id="button-club-section"> ECHIPA </button>
                <button type="button" id="button-age-section"> VÂRSTĂ </button>
                <button type="button" id="button-height-section"> ÎNĂLȚIME </button>
                <button type="button" id="button-weight-section"> GREUTATE </button>
                <button type="button" id="button-position-section"> POZIȚIE </button>
                <button type="button" id="button-nationality-section"> NAȚIONALITATE </button>
                <button type="submit" form="main-form" formaction="1" style="width: 50%; float: left"> APLICĂ FILTRE </button>
                <a href="/Liga1/public/jucatori/1"><button  type="button" style="width: 50%"> RESETEAZĂ FILTRE </button></a>
        </div>
        <div class="players-filters-selectate">
            <form id="main-form" method="post">
            @csrf
            <div class="filters-order-attribute-section" id="filters-order-attribute-section">
                <h3> Sortați jucătorii după: </h3>
                <input type="radio" name="sortByAttribute" id="numeJucator" value="numeJucator" @if($filters['sortByAttribute'] == 'numeJucator') checked @endif/> Nume <br>
                <input type="radio" name="sortByAttribute" id="numeEchipa" value="numeEchipa" @if($filters['sortByAttribute'] == 'numeEchipa') checked @endif/> Echipă <br>
                <input type="radio" name="sortByAttribute" id="varsta" value="varsta" @if($filters['sortByAttribute'] == 'varsta') checked @endif/> Vârstă <br>
                <input type="radio" name="sortByAttribute" id="inaltime" value="inaltime" @if($filters['sortByAttribute'] == 'inaltime') checked @endif/> Înălțime <br>
                <input type="radio" name="sortByAttribute" id="greutate" value="greutate" @if($filters['sortByAttribute'] == 'greutate') checked @endif/> Greutate <br>
                <input type="radio" name="sortByAttribute" id="pozitie" value="pozitie" @if($filters['sortByAttribute'] == 'pozitie') checked @endif/> Poziție <br>
                <input type="radio" name="sortByAttribute" id="nationalitate" value="nationalitate" @if($filters['sortByAttribute'] == 'nationalitate') checked @endif/> Naționalitate <br>
                <input type="radio" name="sortByAttribute" id="goluri" value="goluri" @if($filters['sortByAttribute'] == 'goluri') checked @endif/> Goluri <br>
                <input type="radio" name="sortByAttribute" id="assisturi" value="assisturi" @if($filters['sortByAttribute'] == 'assisturi') checked @endif/> Assisturi <br>
                <input type="radio" name="sortByAttribute" id="cartonaseGalbene" value="cartonaseGalbene" @if($filters['sortByAttribute'] == 'cartonaseGalbene') checked @endif/> Cartonașe galbene <br>
                <input type="radio" name="sortByAttribute" id="cartonaseRosii" value="cartonaseRosii" @if($filters['sortByAttribute'] == 'cartonaseRosii') checked @endif/> Cartonașe roșii
            </div>
            <div class="filters-order-section" id="filters-order-section">
                <h3> Ordine: </h3>
                <input type="radio" name="order" id="asc" value="asc" @if($filters['order'] == 'asc') checked @endif/> Crescător <br>
                <input type="radio" name="order" id="desc" value="desc" @if($filters['order'] == 'desc') checked @endif/> Descrescător <br>
            </div>
            <div class="filters-search-section" id="filters-search-section">
                <h3 style="float:left"> Căutați jucătorii în funcție de nume: &nbsp;
                <input type="text" value='{{$filters['search']}}' name="search" maxlength="30"> </h3>
            </div>
            <div class="filters-club-section" id="filters-club-section">
                <fieldset>
                    <legend> Filtrați jucătorii în funcție de echipele selectate: </legend>
                    @foreach(array_keys($clubsDct) as $clubID)
                        <div class="fieldset-item"><input type="checkbox" name="clubsChecked[{{$clubID}}]" value=true @if(in_array($clubID, $filters['clubsChecked']) && !$filters['allClubs']) checked @endif> {{$clubsDct[$clubID]}} </div>
                    @endforeach
                </fieldset>
            </div>
            <div class="filters-age-section" id="filters-age-section">
                <h3> Filtrați jucătorii în funcție de vârsta lor: </h3><br>
                <label> Min: </label> <input type="text" name="ageMin" id="ageMin" value="{{$filters['ageMin']}}" maxlength="3">&nbsp;<button type="button" class="reset-button" id="resetAgeMin"> RESET </button><br><br>
                <label> Max: </label> <input type="text" name="ageMax" id="ageMax" value="{{$filters['ageMax']}}" maxlength="3">&nbsp;<button type="button" class="reset-button" id="resetAgeMax"> RESET </button>
            </div>
            <div class="filters-height-section" id="filters-height-section">
                <h3> Filtrați jucătorii în funcție de înălțîmea lor (CM): </h3><br>
                <label> Min: </label> <input type="text" name="heightMin" id="heightMin" value="{{$filters['heightMin']}}" maxlength="3">&nbsp;<button type="button" class="reset-button" id="resetHeightMin"> RESET </button><br><br>
                <label> Max: </label> <input type="text" name="heightMax" id="heightMax" value="{{$filters['heightMax']}}" maxlength="3">&nbsp;<button type="button" class="reset-button" id="resetHeightMax"> RESET </button>
            </div>
            <div class="filters-weight-section" id="filters-weight-section">
                <h3> Filtrați jucătorii în funcție de greutatea lor (KG): </h3><br>
                <label> Min: </label> <input type="text" name="weightMin" id="weightMin" value="{{$filters['weightMin']}}" maxlength="3">&nbsp;<button type="button" class="reset-button" id="resetWeightMin"> RESET </button><br><br>
                <label> Max: </label> <input type="text" name="weightMax" id="weightMax" value="{{$filters['weightMax']}}" maxlength="3">&nbsp;<button type="button" class="reset-button" id="resetWeightMax"> RESET </button>
            </div>
            <div class="filters-position-section" id="filters-position-section">
                <fieldset>
                    <legend> Filtrați jucătorii în funcție de pozițiile selectate: </legend>
                    <input type="checkbox" name="positionsChecked[atacant]" value=true @if(in_array('atacant', $filters['positionsChecked']) && !$filters['allPositions']) checked @endif> Atacant <br>
                    <input type="checkbox" name="positionsChecked[mijlocas]" value=true @if(in_array('mijlocas', $filters['positionsChecked']) && !$filters['allPositions']) checked @endif> Mijlocas <br>
                    <input type="checkbox" name="positionsChecked[fundas]" value=true @if(in_array('fundas', $filters['positionsChecked']) && !$filters['allPositions']) checked @endif> Fundas <br>
                    <input type="checkbox" name="positionsChecked[portar]" value=true @if(in_array('portar', $filters['positionsChecked']) && !$filters['allPositions']) checked @endif> Portar <br>
                </fieldset>
            </div>
            <div class="filters-nationality-section" id="filters-nationality-section">
                <fieldset>
                    <legend> Filtrați jucătorii în funcție de naționalitățile selectate: </legend>
                    @foreach($countries as $country)
                    <input type="checkbox" name="countriesChecked[{{$country->prescurtare}}]" value=true @if(in_array($country->prescurtare, $filters['countriesChecked']) && !$filters['allCountries']) checked @endif> {{$country->denumire}} <br>
                    @endforeach
                </fieldset>
            </div>
            </form>
        </div>
    </div>
    <div class="players-section">
        @if(isset($players[0]))
            <div class="table">
                <div class="table-header">
                    <div class="table-header-data" style="width: 15%"><h2>NUME</h2></div>
                    <div class="table-header-data" style="width: 8%"><h2>ECHIPĂ</h2></div>
                    <div class="table-header-data" style="width: 8%"><h2>NUMĂR</h2></div>
                    <div class="table-header-data" style="width: 8%"><h2>POZIȚIE</h2></div>
                    <div class="table-header-data" style="width: 7%"><h2>VÂRSTĂ</h2></div>
                    <div class="table-header-data" style="width: 11%"><h2>ÎNĂLȚIME</h2></div>
                    <div class="table-header-data" style="width: 11%"><h2>GREUTATE</h2></div>
                    <div class="table-header-data" style="width: 13%"><h2>NAȚIONALITATE</h2></div>
                    <div class="table-header-data" style="width: 5%"><div class="icon"><img src="/Liga1/public/images/other/goal-icon2.png" alt=""></div></div>
                    <div class="table-header-data" style="width: 5%"><div class="icon"><img src="/Liga1/public/images/other/assist-icon.png" alt=""></div></div>
                    <div class="table-header-data" style="width: 5%"><div class="icon"><img src="/Liga1/public/images/other/yellow-card-icon.png" alt=""></div></div>
                    <div class="table-header-data" style="width: 5%"><div class="icon"><img src="/Liga1/public/images/other/red-card-icon.png" alt=""></div></div>
                </div>
                @foreach($players as $player)
                    <div class="table-row">
                        <div class="table-row-data" style="width: 15%"><h3><a href="/Liga1/public/jucator-info/{{$clubsDct[$player['echipaID']]}}/{{$player['numeJucator']}}/statistici-generale"> {{$player['numeJucator']}} </a></h3></div>
                        <div class="table-row-data" style="width: 8%"><div class="icon-clickable"><a href="/Liga1/public/club-info/{{$clubsDct[$player['echipaID']]}}/info"><img src="/Liga1/public/images/clubs/{{$clubsDct[$player['echipaID']]}}.png" alt="{{$clubsDct[$player['echipaID']]}}"></a></div></div>
                        {{-- <div class="table-row-data" style="width: 160px"><h3><a href="/Liga1/public/club-info/{{$clubsDct[$player['echipaID']]}}/info"> {{$clubsDct[$player['echipaID']]}} </a></h3></div> --}}
                        <div class="table-row-data" style="width: 8%"><h3>{{$player['numar']}}</h3></div>
                        <div class="table-row-data" style="width: 8%"><h3>{{$player['pozitie']}}</h3></div>
                        <div class="table-row-data" style="width: 7%"><h3>{{$player['varsta']}}</h3></div>
                        <div class="table-row-data" style="width: 11%"><h3>{{$player['inaltime']}} CM</h3></div>
                        <div class="table-row-data" style="width: 11%"><h3>{{$player['greutate']}} KG</h3></div>
                        <div class="table-row-data" style="width: 13%"><div class="icon"><img src="/Liga1/public/images/tari/{{$player['nationalitate']}}.png" alt="{{$player['nationalitate']}}"></div></div>
                        <div class="table-row-data" style="width: 5%"><h3>{{$player['goluri']}}</h3></div>
                        <div class="table-row-data" style="width: 5%"><h3>{{$player['assisturi']}}</h3></div>
                        <div class="table-row-data" style="width: 5%"><h3>{{$player['cartonaseGalbene']}}</h3></div>
                        <div class="table-row-data" style="width: 5%"><h3>{{$player['cartonaseRosii']}}</h3></div>
                    </div>
                @endforeach
                </div>
        @else
        <h1 style="text-align: center">Nu există rezultate bazate pe criteriile alese. Verificați datele introduse sau pagina!</h1>
        @endif
    </div>
    <div class="page-nav">
        <?php $paginaUrmatoare = $page+1; $paginaPrecedenta = ($page <= 1) ? 1 : $page-1; ?>
        <button type="submit" form="main-form" formaction="{{$paginaPrecedenta}}" style="width: 30%; float: left"> Pagina precedentă </button>
        @if(isset($players[0])) <button type="submit" form="main-form" formaction="{{$paginaUrmatoare}}" style="width: 30%; float: right"> Pagina următoare </button> @endif
    </div>
</div>

@include('footer')

<script type="text/javascript">

    var submitButtons = document.querySelectorAll('button[type="submit"]');
    submitButtons.forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            var formAction = button.getAttribute('formaction');
            document.getElementById('main-form').setAttribute('action', formAction);
            document.getElementById('main-form').submit();
			});
		});

    function hideAll(){
        document.getElementById("filters-order-attribute-section").style.display = "none";
        document.getElementById("filters-order-section").style.display = "none";
        document.getElementById("filters-search-section").style.display = "none";
        document.getElementById("filters-club-section").style.display = "none";
        document.getElementById("filters-age-section").style.display = "none";
        document.getElementById("filters-height-section").style.display = "none";
        document.getElementById("filters-weight-section").style.display = "none";
        document.getElementById("filters-position-section").style.display = "none";
        document.getElementById("filters-nationality-section").style.display = "none";
    }
    document.getElementById("button-order-section").onclick = function(){
        hideAll();
        document.getElementById("filters-order-attribute-section").style.display = "block";
        document.getElementById("filters-order-section").style.display = "block";
    }
    document.getElementById("button-search-section").onclick = function(){
        hideAll();
        document.getElementById("filters-search-section").style.display = "block";
    }
    document.getElementById("button-club-section").onclick = function(){
        hideAll();
        document.getElementById("filters-club-section").style.display = "block";
    }
    document.getElementById("button-age-section").onclick = function(){
        hideAll();
        document.getElementById("filters-age-section").style.display = "block";
    }
    document.getElementById("button-height-section").onclick = function(){
        hideAll();
        document.getElementById("filters-height-section").style.display = "block";
    }
    document.getElementById("button-weight-section").onclick = function(){
        hideAll();
        document.getElementById("filters-weight-section").style.display = "block";
    }
    document.getElementById("button-position-section").onclick = function(){
        hideAll();
        document.getElementById("filters-position-section").style.display = "block";
    }
    document.getElementById("button-nationality-section").onclick = function(){
        hideAll();
        document.getElementById("filters-nationality-section").style.display = "block";
    }
    document.getElementById("resetAgeMin").onclick = function() {
        document.getElementById('ageMin').value = 1;
    }
    document.getElementById("resetAgeMax").onclick = function() {
        document.getElementById('ageMax').value = 100;
    }
    document.getElementById("resetHeightMin").onclick = function() {
        document.getElementById('heightMin').value = 1;
    }
    document.getElementById("resetHeightMax").onclick = function() {
        document.getElementById('heightMax').value = 210;
    }
    document.getElementById("resetWeightMin").onclick = function() {
        document.getElementById('weightMin').value = 1;
    }
    document.getElementById("resetWeightMax").onclick = function() {
        document.getElementById('weightMax').value = 110;
    }
</script>