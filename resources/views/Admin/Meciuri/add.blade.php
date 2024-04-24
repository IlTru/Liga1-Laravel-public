@include('admin/header')

<a href="admin"><-back</a>
<h1>Adaugati un meci nou:</h1>

@if ($errors->any()) <h1 style="background-color:red; width: 20%;">Ceva nu a mers bine.</h1> @endif

<form method="post" action="{{url('admin-meciuri-store')}}">
    @csrf
    <div class="formular">
        <div class="formular-row"><label> Faza: </label>
            <select name="faza" id="faza">
                <option value="sezon regulat"> SEZON REGULAT </option>
                <option value="play off"> PLAY OFF </option>
                <option value="play out"> PLAY OUT </option>
            </select>
        </div>
        <div class="formular-row"><label> Numar etapa: </label>
            <select name="nrEtapa" id="nrEtapa">
                @for ($i = 1; $i<=30; $i++)
                    <option value="{{$i}}"> {{$i}} </option>
                @endfor
            </select>
        </div>
        <div class="formular-row"><label> Disputat: </label>
            <select name="disputat" id="disputat">
                <option value="da"> DA </option>
                <option value="nu" selected> NU </option>
            </select>
        </div>
        <div class="formular-row"><label> Data: </label> <input type="datetime-local" name="data" value="2023-03-01T20:00" min="2022-01-01" max="2023-12-31"> @if ($errors->has('data')) {{ $errors->first('data') }} @endif </div>
        <div class="formular-row"><label> Echipa gazda: </label>
            <select name="echipaGazdaID" id="echipaGazdaID">
                @foreach ($echipe as $echipa)
                <option value="{{$echipa['id']}}">{{$echipa['numeEchipa']}}</option>
                @endforeach
            </select>
            @if ($errors->has('echipaGazdaID')) {{ $errors->first('echipaGazdaID') }} @endif
        </div>
        <div class="formular-row"> <label> Goluri echipa gazda: </label>
            <select name="goluriEG" id="goluriEG">
                @for ($i = 0; $i <=16; $i++)
                <option value="{{$i}}"> {{$i}} </option>
                @endfor
            </select>
        </div>
        <div class="formular-row"><label> Echipa oaspete: </label>
            <select name="echipaOaspeteID" id="echipaOaspeteID">
                @foreach ($echipe as $echipa)
                <option value="{{$echipa['id']}}">{{$echipa['numeEchipa']}}</option>
                @endforeach
            </select>
        </div>
        <div class="formular-row"> <label> Goluri echipa gazda: </label>
            <select name="goluriEO" id="goluriEO">
                @for ($i = 0; $i <=16; $i++)
                    <option value="{{$i}}"> {{$i}} </option>
                @endfor
            </select>
        </div>
        </div>
    <button type="submit" class="submit"> Adauga </button>
    <button type="button" class="cancel" onclick="window.history.back()">Anulați</button>
</form>

@include('admin/footer')