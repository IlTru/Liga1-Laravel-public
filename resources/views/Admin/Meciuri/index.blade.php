@include('admin/header')

<div class="meciuri-view-content">

    @if (isset($error)) <h2 style="background-color:red;">{{$error}}</h2> @endif
    @if (isset($succes)) <h2 style="background-color:green;">{{$succes}}</h2> @endif

    <form method="get" action="{{url('admin-meciuri-index')}}" style="margin: 20px">
        @csrf
        <div class="formular-row" style="float: left"><label> Faza: </label>
            <select name="faza" id="faza">
                <option value="sezon regulat"> SEZON REGULAT </option>
                <option value="play off"> PLAY OFF </option>
                <option value="play out"> PLAY OUT </option>
            </select>
        </div>
        <div class="formular-row" style="float: left"><label> Etapa: </label>
            <select name="nrEtapa" id="nrEtapa">
                @for ($i = 1; $i<=30; $i++)
                    <option value="{{$i}}"> {{$i}} </option>
                @endfor
            </select>
        </div>
        <button type="submit" style="margin: 3px"> Căutare </button>
    </form>

    <div class="table">
        <div class="table-header">
            <div class="table-header-data" style="width: 100px"><h1> FAZA </h1></div>
            <div class="table-header-data" style="width: 60px"><h1> ETAPA </h1></div>
            <div class="table-header-data" style="width: 80px"><h1> DISPUTAT </h1></div>
            <div class="table-header-data" style="width: 80px"><h1> DATA </h1></div>
            <div class="table-header-data" style="width: 240px"><h1> ECHIPA GAZDA </h1></div>
            <div class="table-header-data" style="width: 70px"><h1> GOLURI </h1></div>
            <div class="table-header-data" style="width: 240px"><h1> ECHIPA OASPETE </h1></div>
            <div class="table-header-data" style="width: 70px"><h1> GOLURI </h1></div>
            <div class="table-header-data" style="width: 110px"><h1> STATISTICI </h1></div>
            <div class="table-header-data" style="width: 110px"><h1> ADAUGA LOTURI </h1></div>
            <div class="table-header-data" style="width: 150px"><h1> ADAUGA GOLURI/ASSISTURI </h1></div>
            <div class="table-header-data" style="width: 130px"><h1> ADAUGA CARTONASE </h1></div>
            <div class="table-header-data" style="width: 130px"><h1> ADAUGA SCHIMBARI </h1></div>
        </div>
        @foreach ($meciuri as $meci)
        <div class="table-row">
            <div class="table-row-data" style="width: 100px"><h1>{{$meci->faza}}</h1></div>
            <div class="table-row-data" style="width: 60px"><h1>{{$meci->nrEtapa}}</h1></div>
            <div class="table-row-data" style="width: 80px"><h1>{{$meci->disputat}}</h1></div>
            <div class="table-row-data" style="width: 80px"><h1>{{$meci->data}}</h1></div>
            <div class="table-row-data" style="width: 240px"><h1><img class="small-club-logo" src="/Liga1/public/images/clubs/{{$echipe[$meci->echipaGazdaID]}}.png" alt=""> &nbsp; {{$echipe[$meci->echipaGazdaID]}}</h1></div>
            <div class="table-row-data" style="width: 70px"><h1>{{$meci->goluriEG}}</h1></div>
            <div class="table-row-data" style="width: 240px"><h1><img class="small-club-logo" src="/Liga1/public/images/clubs/{{$echipe[$meci->echipaOaspeteID]}}.png" alt=""> &nbsp; {{$echipe[$meci->echipaOaspeteID]}}</h1></div>
            <div class="table-row-data" style="width: 70px"><h1>{{$meci->goluriEO}}</h1></div>
            <div class="table-row-data" style="width: 51px"><h1><a href='{{url('admin-statistici-add/'.$meci->id)}}'> ADD </a></h1></div>
            <div class="table-row-data" style="width: 51px"><h1><a href='{{url('admin-statistici-index/'.$meci->id)}}'> INFO </a></div>
            <div class="table-row-data" style="width: 51px"><h1><a href='{{url('admin-loturi-add/'.$meci->id.'/'.$meci->echipaGazdaID)}}'><img class="small-club-logo" src="/Liga1/public/images/clubs/{{$echipe[$meci->echipaGazdaID]}}.png" alt=""></a></h1></div>
            <div class="table-row-data" style="width: 51px"><h1><a href='{{url('admin-loturi-add/'.$meci->id.'/'.$meci->echipaOaspeteID)}}'><img class="small-club-logo" src="/Liga1/public/images/clubs/{{$echipe[$meci->echipaOaspeteID]}}.png" alt=""></a></h1></div>
            <div class="table-row-data" style="width: 71px"><h1><a href='{{url('admin-goluri-assisturi-add/'.$meci->id.'/'.$meci->echipaGazdaID)}}'><img class="small-club-logo" src="/Liga1/public/images/clubs/{{$echipe[$meci->echipaGazdaID]}}.png" alt=""></a></h1></div>
            <div class="table-row-data" style="width: 71px"><h1><a href='{{url('admin-goluri-assisturi-add/'.$meci->id.'/'.$meci->echipaOaspeteID)}}'><img class="small-club-logo" src="/Liga1/public/images/clubs/{{$echipe[$meci->echipaOaspeteID]}}.png" alt=""></a></h1></div>
            <div class="table-row-data" style="width: 61px"><h1><a href='{{url('admin-cartonase-add/'.$meci->id.'/'.$meci->echipaGazdaID)}}'><img class="small-club-logo" src="/Liga1/public/images/clubs/{{$echipe[$meci->echipaGazdaID]}}.png" alt=""></a></h1></div>
            <div class="table-row-data" style="width: 61px"><h1><a href='{{url('admin-cartonase-add/'.$meci->id.'/'.$meci->echipaOaspeteID)}}'><img class="small-club-logo" src="/Liga1/public/images/clubs/{{$echipe[$meci->echipaOaspeteID]}}.png" alt=""></a></h1></div>
            <div class="table-row-data" style="width: 61px"><h1><a href='{{url('admin-schimbari-add/'.$meci->id.'/'.$meci->echipaGazdaID)}}'><img class="small-club-logo" src="/Liga1/public/images/clubs/{{$echipe[$meci->echipaGazdaID]}}.png" alt=""></a></h1></div>
            <div class="table-row-data" style="width: 61px"><h1><a href='{{url('admin-schimbari-add/'.$meci->id.'/'.$meci->echipaOaspeteID)}}'><img class="small-club-logo" src="/Liga1/public/images/clubs/{{$echipe[$meci->echipaOaspeteID]}}.png" alt=""></a></h1></div>
            <button type="button" class="edit-button" style="width: 80px;" onclick="window.location.href='{{url('admin-meciuri-edit/'.$meci->id)}}';"><h1 style="font-size: 13px">EDITARE</h1></button>
            <button type="button" class="delete-button" style="width: 80px" onclick="if(confirm('Sunteți sigur că doriți să ștergeți înregistrarea?')){ window.location.href = '{{url('admin-meciuri-delete/'.$meci->id)}}'; }"><h1 style="font-size: 13px">ȘTERGE</h1></button>
        </div>
        @endforeach
    </div>
</div>

@include('admin/footer')