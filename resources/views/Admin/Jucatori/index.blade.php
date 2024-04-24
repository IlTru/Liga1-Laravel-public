@include('admin/header')

@if (isset($error)) <h1 style="background-color:red;">{{$error}}</h1> @endif
@if (isset($succes)) <h1 style="background-color:green;">{{$succes}}</h1> @endif

<div class="jucatori-view-content">
    <div class="jucatori-filtre-content">
        <div class="buttons-section">
                <button type="button" id="button-ordine"> SORTARE </button>
                <button type="button" id="button-cautare"> CĂUTARE </button>
                <button type="button" id="button-club"> ECHIPA </button>
                <button type="button" id="button-varsta"> VÂRSTĂ </button>
                <button type="button" id="button-inaltime"> ÎNĂLȚIME </button>
                <button type="button" id="button-greutate"> GREUTATE </button>
                <button type="button" id="button-pozitie"> POZIȚIE </button>
                <button type="button" id="button-nationalitate"> NAȚIONALITATE </button>
                <button type="submit" form="main-form" formaction="1" style="width: 50%; float: left"> APLICĂ FILTRE </button>
                <a href="/Liga1/public/admin-jucatori-index/1"><button  type="button" style="width: 50%"> RESETEAZĂ FILTRE </button></a>
        </div>
        <div class="filtre-selectate">
            <form id="main-form" method="post">
                @csrf
                <div class="filtru-atributul-de-sortare-section" id="filtru-atributul-de-sortare-section">
                    <h3> Sortați jucătorii după: </h3>
                    <input type="radio" name="atributulDeSortare" id="numeJucator" value="numeJucator" @if($filtre['atributulDeSortare'] == 'numeJucator') checked @endif/> Nume <br>
                    <input type="radio" name="atributulDeSortare" id="numeEchipa" value="numeEchipa" @if($filtre['atributulDeSortare'] == 'numeEchipa') checked @endif/> Echipă <br>
                    <input type="radio" name="atributulDeSortare" id="varsta" value="varsta" @if($filtre['atributulDeSortare'] == 'varsta') checked @endif/> Vârstă <br>
                    <input type="radio" name="atributulDeSortare" id="inaltime" value="inaltime" @if($filtre['atributulDeSortare'] == 'inaltime') checked @endif/> Înălțime <br>
                    <input type="radio" name="atributulDeSortare" id="greutate" value="greutate" @if($filtre['atributulDeSortare'] == 'greutate') checked @endif/> Greutate <br>
                    <input type="radio" name="atributulDeSortare" id="pozitie" value="pozitie" @if($filtre['atributulDeSortare'] == 'pozitie') checked @endif/> Poziție <br>
                    <input type="radio" name="atributulDeSortare" id="nationalitate" value="nationalitate" @if($filtre['atributulDeSortare'] == 'nationalitate') checked @endif/> Naționalitate <br>
                    <input type="radio" name="atributulDeSortare" id="goluri" value="goluri" @if($filtre['atributulDeSortare'] == 'goluri') checked @endif/> Goluri <br>
                    <input type="radio" name="atributulDeSortare" id="assisturi" value="assisturi" @if($filtre['atributulDeSortare'] == 'assisturi') checked @endif/> Assisturi <br>
                    <input type="radio" name="atributulDeSortare" id="cartonaseGalbene" value="cartonaseGalbene" @if($filtre['atributulDeSortare'] == 'cartonaseGalbene') checked @endif/> Cartonașe galbene <br>
                    <input type="radio" name="atributulDeSortare" id="cartonaseRosii" value="cartonaseRosii" @if($filtre['atributulDeSortare'] == 'cartonaseRosii') checked @endif/> Cartonașe roșii
                </div>
                <div class="filtru-ordine-section" id="filtru-ordine-section">
                    <h3> Ordine: </h3>
                    <input type="radio" name="ordine" id="asc" value="asc" @if($filtre['ordine'] == 'asc') checked @endif/> Crescător <br>
                    <input type="radio" name="ordine" id="desc" value="desc" @if($filtre['ordine'] == 'desc') checked @endif/> Descrescător <br>
                </div>
                <div class="filtru-cautare-section" id="filtru-cautare-section">
                    <h3 style="float:left"> Căutați jucătorii în funcție de nume: &nbsp;</h3>
                    <input type="text" value='{{$filtre['cautare']}}' name="cautare" maxlength="30">
                </div>
                <div class="filtru-club-section" id="filtru-club-section">
                    <fieldset>
                        <legend> Filtrați jucătorii în funcție de echipele selectate: </legend>
                        @foreach(array_keys($echipeDct) as $echipaID)
                            <div class="fieldset-item"><input type="checkbox" name="cluburiSelectate[{{$echipaID}}]" value=true @if(in_array($echipaID, $filtre['cluburiSelectate']) && !$filtre['toateCluburile']) checked @endif> {{$echipeDct[$echipaID]}} </div>
                        @endforeach
                    </fieldset>
                </div>
                <div class="filtru-varsta-section" id="filtru-varsta-section">
                    <h3> Filtrați jucătorii în funcție de vârsta lor: </h3><br>
                    <label> Min: </label> <input type="text" name="varstaMin" id="varstaMin" value="{{$filtre['varstaMin']}}" maxlength="3">&nbsp;<button type="button" class="reset-button" id="resetVarstaMin"> RESET </button><br><br>
                    <label> Max: </label> <input type="text" name="varstaMax" id="varstaMax" value="{{$filtre['varstaMax']}}" maxlength="3">&nbsp;<button type="button" class="reset-button" id="resetVarstaMax"> RESET </button>
                </div>
                <div class="filtru-inaltime-section" id="filtru-inaltime-section">
                    <h3> Filtrați jucătorii în funcție de înălțîmea lor (CM): </h3><br>
                    <label> Min: </label> <input type="text" name="inaltimeMin" id="inaltimeMin" value="{{$filtre['inaltimeMin']}}" maxlength="3">&nbsp;<button type="button" class="reset-button" id="resetInaltimeMin"> RESET </button><br><br>
                    <label> Max: </label> <input type="text" name="inaltimeMax" id="inaltimeMax" value="{{$filtre['inaltimeMax']}}" maxlength="3">&nbsp;<button type="button" class="reset-button" id="resetInaltimeMax"> RESET </button>
                </div>
                <div class="filtru-greutate-section" id="filtru-greutate-section">
                    <h3> Filtrați jucătorii în funcție de greutatea lor (KG): </h3><br>
                    <label> Min: </label> <input type="text" name="greutateMin" id="greutateMin" value="{{$filtre['greutateMin']}}" maxlength="3">&nbsp;<button type="button" class="reset-button" id="resetGreutateMin"> RESET </button><br><br>
                    <label> Max: </label> <input type="text" name="greutateMax" id="greutateMax" value="{{$filtre['greutateMax']}}" maxlength="3">&nbsp;<button type="button" class="reset-button" id="resetGreutateMax"> RESET </button>
                </div>
                <div class="filtru-pozitie-section" id="filtru-pozitie-section">
                    <fieldset>
                        <legend> Filtrați jucătorii în funcție de pozițiile selectate: </legend>
                        <input type="checkbox" name="pozitiiSelectate[atacant]" value=true @if(in_array('atacant', $filtre['pozitiiSelectate']) && !$filtre['toatePozitiile']) checked @endif> Atacant <br>
                        <input type="checkbox" name="pozitiiSelectate[mijlocas]" value=true @if(in_array('mijlocas', $filtre['pozitiiSelectate']) && !$filtre['toatePozitiile']) checked @endif> Mijlocas <br>
                        <input type="checkbox" name="pozitiiSelectate[fundas]" value=true @if(in_array('fundas', $filtre['pozitiiSelectate']) && !$filtre['toatePozitiile']) checked @endif> Fundas <br>
                        <input type="checkbox" name="pozitiiSelectate[portar]" value=true @if(in_array('portar', $filtre['pozitiiSelectate']) && !$filtre['toatePozitiile']) checked @endif> Portar <br>
                    </fieldset>
                </div>
                <div class="filtru-nationalitate-section" id="filtru-nationalitate-section">
                    <fieldset>
                        <legend> Filtrați jucătorii în funcție de naționalitățile selectate: </legend>
                        @foreach($tari as $tara)
                        <input type="checkbox" name="tariSelectate[{{$tara->prescurtare}}]" value=true @if(in_array($tara->prescurtare, $filtre['tariSelectate']) && !$filtre['toateTarile']) checked @endif> {{$tara->denumire}} <br>
                        @endforeach
                    </fieldset>
                </div>
            </form>
        </div>
    </div>
    <div class="jucatori-section">
        @if(isset($jucatori[0]))
        <div class="table-header">
            <div class="table-header-data" style="width: 11%"> Nume </div>
            <div class="table-header-data" style="width: 15%"> Echipă </div>
            <div class="table-header-data" style="width: 5%"> Număr </div>
            <div class="table-header-data" style="width: 5%"> Poziție </div>
            <div class="table-header-data" style="width: 4.5%"> Vârstă </div>
            <div class="table-header-data" style="width: 5.5%"> Înălțime </div>
            <div class="table-header-data" style="width: 5.5%"> Greutate </div>
            <div class="table-header-data" style="width: 10%"> Naționalitate </div>
            <div class="table-header-data" style="width: 3%"><div class="icon"><img src="/Liga1/public/images/other/goal-icon2.png" alt=""></div></div>
            <div class="table-header-data" style="width: 3%"><div class="icon"><img src="/Liga1/public/images/other/assist-icon.png" alt=""></div></div>
            <div class="table-header-data" style="width: 3%"><div class="icon"><img src="/Liga1/public/images/other/yellow-card-icon.png" alt=""></div></div>
            <div class="table-header-data" style="width: 3%"><div class="icon"><img src="/Liga1/public/images/other/red-card-icon.png" alt=""></div></div>
        </div>
        @foreach($jucatori as $jucator)
            <div class="table-row">
                <div class="table-row-data" style="width: 11%"><a href="/Liga1/public/jucator-info/{{$echipeDct[$jucator['echipaID']]}}/{{$jucator['numeJucator']}}/statistici-generale"> {{$jucator['numeJucator']}} </a></div>
                <div class="table-row-data" style="width: 15%"><a href="/Liga1/public/club-info/{{$echipeDct[$jucator['echipaID']]}}/info"> {{$echipeDct[$jucator['echipaID']]}} </a></div>
                <div class="table-row-data" style="width: 5%"> {{$jucator['numar']}} </div>
                <div class="table-row-data" style="width: 5%"> {{$jucator['pozitie']}} </div>
                <div class="table-row-data" style="width: 4.5%"> {{$jucator['varsta']}} </div>
                <div class="table-row-data" style="width: 5.5%"> {{$jucator['inaltime']}} CM</div>
                <div class="table-row-data" style="width: 5.5%"> {{$jucator['greutate']}} KG</div>
                <div class="table-row-data" style="width: 10%"> {{$jucator['nationalitate']}} </div>
                <div class="table-row-data" style="width: 3%"> {{$jucator['goluri']}} </div>
                <div class="table-row-data" style="width: 3%"> {{$jucator['assisturi']}} </div>
                <div class="table-row-data" style="width: 3%"> {{$jucator['cartonaseGalbene']}} </div>
                <div class="table-row-data" style="width: 3%"> {{$jucator['cartonaseRosii']}} </div>
                <div class="table-row-data" style="width: 5%; padding: 0px; height: 36px;"><button type="button" class="edit-button" style="width: 70px;" onclick="window.location.href='{{url('admin-jucatori-edit/'.$jucator['id'])}}';"><h1 style="font-size: 13px">EDITARE</h1></button></div>
                <div class="table-row-data" style="width: 5%; padding: 0px; height: 36px;"><button type="button" class="delete-button" style="width: 70px" onclick="if(confirm('Sunteți sigur că doriți să ștergeți înregistrarea?')){ window.location.href = '{{url('admin-jucatori-delete/'.$jucator['id'])}}'; }"><h1 style="font-size: 13px">ȘTERGE</h1></button></div>
            </div>
        @endforeach
        @else
        <h1 style="text-align: center">Nu există rezultate bazate pe criteriile alese. Verificați datele introduse sau pagina!</h1>
        @endif
    </div>
    <div class="page-nav">
        <?php $nextPage = $page+1; $prevPage = ($page <= 1) ? 1 : $page-1; ?>
        <button type="submit" form="main-form" formaction="{{$prevPage}}" style="width: 30%; float: left"> Pagina precedentă </button>
        <button type="submit" form="main-form" formaction="{{$nextPage}}" style="width: 30%; float: right"> Pagina următoare </button>
    </div>
</div>

@include('admin/footer')

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
        document.getElementById("filtru-atributul-de-sortare-section").style.display = "none";
        document.getElementById("filtru-ordine-section").style.display = "none";
        document.getElementById("filtru-cautare-section").style.display = "none";
        document.getElementById("filtru-club-section").style.display = "none";
        document.getElementById("filtru-varsta-section").style.display = "none";
        document.getElementById("filtru-inaltime-section").style.display = "none";
        document.getElementById("filtru-greutate-section").style.display = "none";
        document.getElementById("filtru-pozitie-section").style.display = "none";
        document.getElementById("filtru-nationalitate-section").style.display = "none";
    }
    document.getElementById("button-ordine").onclick = function(){
        hideAll();
        document.getElementById("filtru-atributul-de-sortare-section").style.display = "block";
        document.getElementById("filtru-ordine-section").style.display = "block";
    }
    document.getElementById("button-cautare").onclick = function(){
        hideAll();
        document.getElementById("filtru-cautare-section").style.display = "block";
    }
    document.getElementById("button-club").onclick = function(){
        hideAll();
        document.getElementById("filtru-club-section").style.display = "block";
    }
    document.getElementById("button-varsta").onclick = function(){
        hideAll();
        document.getElementById("filtru-varsta-section").style.display = "block";
    }
    document.getElementById("button-inaltime").onclick = function(){
        hideAll();
        document.getElementById("filtru-inaltime-section").style.display = "block";
    }
    document.getElementById("button-greutate").onclick = function(){
        hideAll();
        document.getElementById("filtru-greutate-section").style.display = "block";
    }
    document.getElementById("button-pozitie").onclick = function(){
        hideAll();
        document.getElementById("filtru-pozitie-section").style.display = "block";
    }
    document.getElementById("button-nationalitate").onclick = function(){
        hideAll();
        document.getElementById("filtru-nationalitate-section").style.display = "block";
    }
    document.getElementById("resetVarstaMin").onclick = function() {
        document.getElementById('varstaMin').value = 1;
    }
    document.getElementById("resetVarstaMax").onclick = function() {
        document.getElementById('varstaMax').value = 100;
    }
    document.getElementById("resetInaltimeMin").onclick = function() {
        document.getElementById('inaltimeMin').value = 1;
    }
    document.getElementById("resetInaltimeMax").onclick = function() {
        document.getElementById('inaltimeMax').value = 210;
    }
    document.getElementById("resetGreutateMin").onclick = function() {
        document.getElementById('greutateMin').value = 1;
    }
    document.getElementById("resetGreutateMax").onclick = function() {
        document.getElementById('greutateMax').value = 110;
    }
</script>

{{-- <div class="filter-button" id="filter-button" style="width: 150px; float:left"><button> FILTRE </button></div>

<div class="filter-button" style="float:left; margin-right:50px"><button onclick="window.location.href='admin-jucatori-index';"> Reseteaza toate filtrele </button></div>

<div class="filter-button">
    <form method="post" action="{{url('admin-jucatori-index-filter')}}">
        @csrf
        <input type="hidden" name="filter" value="<?php //echo htmlspecialchars(json_encode($filter)); ?>">
        <input type="text" placeholder="Caută un jucător.." name="search">
        <button type="submit">CAUTARE</button>
    </form>
</div>

<div class="filter-form" id="filter-form" style="display:none">
    <form method="post" action="{{url('admin-jucatori-index-filter')}}">
        @csrf
        <input type="hidden" name="filter" value="<?php //echo htmlspecialchars(json_encode($filter)); ?>">
        <div class="formular-column"><div class="column-title"><h3> Echipe </h3></div>
        <fieldset>
            <div class="fieldset-item"><input type="checkbox" name="TOATE_ECHIPELE" value=true @if(isset($filter['TOATE_ECHIPELE'])) checked @endif> Toate </div><br>
            @foreach(array_keys($echipe) as $echipaID)
            <div class="fieldset-item"><input type="checkbox" name="{{$echipaID}}" value=true @if(isset($filter[$echipaID])) checked @endif> {{$echipe[$echipaID]}} </div>
            <br>
            @endforeach
        </fieldset>
        </div>

        <div class="formular-column"><div class="column-title"><h3> Varsta </h3></div>
            <label> Min: </label> <input type="text" name="varstaMin" id="varstaMin" value="{{ $filter['varstaMin'] }}">&nbsp;<button type="button" class="reset-button" id="reset-varstaMin">RESET</button><br><br>
            <label> Max: </label> <input type="text" name="varstaMax" id="varstaMax" value="{{ $filter['varstaMax'] }}">&nbsp;<button type="button" class="reset-button" id="reset-varstaMax">RESET</button>
        <br><br>
        <div class="column-title"><h3> Inaltime </h3></div>
            <label> Min: </label> <input type="text" name="inaltimeMin" id="inaltimeMin" value="{{ $filter['inaltimeMin'] }}">&nbsp;<button type="button" class="reset-button" id="reset-inaltimeMin">RESET</button><br><br>
            <label> Max: </label> <input type="text" name="inaltimeMax" id="inaltimeMax" value="{{ $filter['inaltimeMax'] }}">&nbsp;<button type="button" class="reset-button" id="reset-inaltimeMax">RESET</button>
        <br><br>
        <div class="column-title"><h3> Greutate </h3></div>
            <label> Min: </label> <input type="text" name="greutateMin" id="greutateMin" value="{{ $filter['greutateMin'] }}">&nbsp;<button type="button" class="reset-button" id="reset-greutateMin">RESET</button><br><br>
            <label> Max: </label> <input type="text" name="greutateMax" id="greutateMax" value="{{ $filter['greutateMax'] }}">&nbsp;<button type="button" class="reset-button" id="reset-greutateMax">RESET</button>
        </div>
        
        <div class="formular-column"><div class="column-title"><h3> Pozitie </h3></div>
            <fieldset>
                <legend> Pozitie: </legend>
                <input type="checkbox" name="TOATE_POZITIILE" value=true @if(isset($filter['TOATE_POZITIILE'])) checked @endif> Toate <br>
                <input type="checkbox" name="ATACANT" value=true @if(isset($filter['ATACANT'])) checked @endif> Atacant <br>
                <input type="checkbox" name="MIJLOCAS" value=true @if(isset($filter['MIJLOCAS'])) checked @endif> Mijlocas <br>
                <input type="checkbox" name="FUNDAS" value=true @if(isset($filter['FUNDAS'])) checked @endif> Fundas <br>
                <input type="checkbox" name="PORTAR" value=true @if(isset($filter['PORTAR'])) checked @endif> Portar <br>
            </fieldset>
        </div>

        <div class="formular-column"><div class="column-title"><h3> Nationalitate </h3></div>
            <fieldset  style="overflow:scroll; height: 350px">
                <legend> Nationalitate: </legend>
                <div class="fieldset-item"><input type="checkbox" name="TOATE_TARILE" value=true @if(isset($filter['TOATE_TARILE'])) checked @endif> Toate </div><br>
                @foreach($tari as $tara)
                <div class="fieldset-item"><input type="checkbox" name="{{$tara->prescurtare}}" value=true @if(isset($filter[$tara->prescurtare])) checked @endif> {{$tara->denumire}} </div><br>
                @endforeach
            </fieldset>
        </div>

        <div class="filter-button" style="width: 150px"><button type="submit"> FILTREAZA </button></div>
    </form>
</div>

<script type="text/javascript">
    document.getElementById("filter-button").onclick = function() {
        if(document.getElementById("filter-form").style.display != "none") document.getElementById("filter-form").style.display = "none";
        else document.getElementById("filter-form").style.display = "inline";
    }
    document.getElementById("reset-varstaMin").onclick = function() {
        document.getElementById('varstaMin').value = 1;   
    }
    document.getElementById("reset-varstaMax").onclick = function() {
        document.getElementById('varstaMax').value = 99; 
    }
    document.getElementById("reset-inaltimeMin").onclick = function() {
        document.getElementById('inaltimeMin').value = 1; 
    }
    document.getElementById("reset-inaltimeMax").onclick = function() {
        document.getElementById('inaltimeMax').value = 210; 
    }
    document.getElementById("reset-greutateMin").onclick = function() {
        document.getElementById('greutateMin').value = 1; 
    }
    document.getElementById("reset-greutateMax").onclick = function() {
        document.getElementById('greutateMax').value = 110; 
    }
</script>

@if(count($jucatori))
<div class="table">
    <div class="table-header">
        <form method="post" action="{{url('admin-jucatori-index-filter')}}"> @csrf<input type="hidden" name="filter" value="<?php echo htmlspecialchars(json_encode($filter)); ?>"><input type="hidden" name="coloana" value="id">@if($filter['coloana'] == 'id' && $filter['ord'] == 'ASC') <input type="hidden" name="ord" value="DESC"> @else <input type="hidden" name="ord" value="ASC"> @endif<button type="submit" style="width: 4%"> ID </button></form>
        <form method="post" action="{{url('admin-jucatori-index-filter')}}"> @csrf<input type="hidden" name="filter" value="<?php echo htmlspecialchars(json_encode($filter)); ?>"><input type="hidden" name="coloana" value="numeJucator">@if($filter['coloana'] == 'numeJucator' && $filter['ord'] == 'ASC') <input type="hidden" name="ord" value="DESC"> @else <input type="hidden" name="ord" value="ASC"> @endif<button type="submit" style="width: 11%"> NUME JUCATOR </button></form>
        <form method="post" action="{{url('admin-jucatori-index-filter')}}"> @csrf<input type="hidden" name="filter" value="<?php echo htmlspecialchars(json_encode($filter)); ?>"><input type="hidden" name="coloana" value="echipaID">@if($filter['coloana'] == 'echipaID' && $filter['ord'] == 'ASC') <input type="hidden" name="ord" value="DESC"> @else <input type="hidden" name="ord" value="ASC"> @endif<button type="submit" style="width: 7%"> ID ECHIPA </button></form>
        <form method="post" action="{{url('admin-jucatori-index-filter')}}"> @csrf<input type="hidden" name="filter" value="<?php echo htmlspecialchars(json_encode($filter)); ?>"><input type="hidden" name="coloana" value="numeEchipa">@if($filter['coloana'] == 'numeEchipa' && $filter['ord'] == 'ASC') <input type="hidden" name="ord" value="DESC"> @else <input type="hidden" name="ord" value="ASC"> @endif<button type="submit" style="width: 11%"> NUME ECHIPA </button></form>
        <form method="post" action="{{url('admin-jucatori-index-filter')}}"> @csrf<input type="hidden" name="filter" value="<?php echo htmlspecialchars(json_encode($filter)); ?>"><input type="hidden" name="coloana" value="numar">@if($filter['coloana'] == 'numar' && $filter['ord'] == 'ASC') <input type="hidden" name="ord" value="DESC"> @else <input type="hidden" name="ord" value="ASC"> @endif<button type="submit" style="width: 7%"> NUMAR </button></form>
        <form method="post" action="{{url('admin-jucatori-index-filter')}}"> @csrf<input type="hidden" name="filter" value="<?php echo htmlspecialchars(json_encode($filter)); ?>"><input type="hidden" name="coloana" value="varsta">@if($filter['coloana'] == 'varsta' && $filter['ord'] == 'ASC') <input type="hidden" name="ord" value="DESC"> @else <input type="hidden" name="ord" value="ASC"> @endif<button type="submit" style="width: 7%"> VARSTA </button></form>
        <form method="post" action="{{url('admin-jucatori-index-filter')}}"> @csrf<input type="hidden" name="filter" value="<?php echo htmlspecialchars(json_encode($filter)); ?>"><input type="hidden" name="coloana" value="pozitie">@if($filter['coloana'] == 'pozitie' && $filter['ord'] == 'ASC') <input type="hidden" name="ord" value="DESC"> @else <input type="hidden" name="ord" value="ASC"> @endif<button type="submit" style="width: 9%"> POZITIE </button></form>
        <form method="post" action="{{url('admin-jucatori-index-filter')}}"> @csrf<input type="hidden" name="filter" value="<?php echo htmlspecialchars(json_encode($filter)); ?>"><input type="hidden" name="coloana" value="inaltime">@if($filter['coloana'] == 'inaltime' && $filter['ord'] == 'ASC') <input type="hidden" name="ord" value="DESC"> @else <input type="hidden" name="ord" value="ASC"> @endif<button type="submit" style="width: 9%"> INALTIME </button></form>
        <form method="post" action="{{url('admin-jucatori-index-filter')}}"> @csrf<input type="hidden" name="filter" value="<?php echo htmlspecialchars(json_encode($filter)); ?>"><input type="hidden" name="coloana" value="greutate">@if($filter['coloana'] == 'greutate' && $filter['ord'] == 'ASC') <input type="hidden" name="ord" value="DESC"> @else <input type="hidden" name="ord" value="ASC"> @endif<button type="submit" style="width: 11%"> GREUTATE </button></form>
        <form method="post" action="{{url('admin-jucatori-index-filter')}}"> @csrf<input type="hidden" name="filter" value="<?php echo htmlspecialchars(json_encode($filter)); ?>"><input type="hidden" name="coloana" value="nationalitate">@if($filter['coloana'] == 'nationalitate' && $filter['ord'] == 'ASC') <input type="hidden" name="ord" value="DESC"> @else <input type="hidden" name="ord" value="ASC"> @endif<button type="submit" style="width: 11%"> NATIONALITATE </button></form>
        <div class="table-header-column" style="width: 10%; padding-top: 18px"> ACTION </div>
    </div>
    @foreach ($jucatori as $jucator)
    <div class="table-row">
        <div class="table-row-data" style="width: 3%">{{$jucator->id}}</div>
        <div class="table-row-data" style="width: 10%">{{$jucator->numeJucator}}</div>
        <div class="table-row-data" style="width: 6%">{{$jucator->echipaID}}</div>
        <div class="table-row-data" style="width: 10%">{{$echipe[$jucator->echipaID]}}</div>
        <div class="table-row-data" style="width: 6%">{{$jucator->numar}}</div>
        <div class="table-row-data" style="width: 6%">{{$jucator->varsta}}</div>
        <div class="table-row-data" style="width: 8%">{{$jucator->pozitie}}</div>
        <div class="table-row-data" style="width: 8%">{{$jucator->inaltime}}</div>
        <div class="table-row-data" style="width: 10%">{{$jucator->greutate}}</div>
        <div class="table-row-data" style="width: 10%">{{$jucator->nationalitate}}</div>
        <div class="table-row-data" style="width: 4.5%"><a href= '{{url('admin-jucatori-edit/'.$jucator->id)}}'> Edit </a></div>
        <div class="table-row-data" style="width: 4.5%"><a onclick="return confirm('Are you sure you want to delete it?')" href= '{{url('admin-jucatori-delete/'.$jucator->id)}}'> Delete </a></div>
    </div>
    @endforeach
</div>
@else <h1>Nu exista jucatori ce respecta criteriile selectate.</h1>
@endif --}}