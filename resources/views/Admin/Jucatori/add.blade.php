@include('admin/header')

<h1>Adaugati noul jucator:</h1>

@if ($errors->any()) <h1 style="background-color:red; width: 20%;">Ceva nu a mers bine.</h1> @endif

<form method="post" action="{{url('admin-jucatori-store')}}">
    @csrf
    <div class="formular">
        <div class="formular-row"><label> Nume jucator: </label> <input type="text" name="numeJucator" value="{{ old('numeJucator') }}"> @if ($errors->has('numeJucator')) {{ $errors->first('numeJucator') }} @endif </div>
        <div class="formular-row"><label> Nume echipa: </label>
            <select name="echipaID" id="echipaID">
                @foreach ($echipe as $echipa)
                <option value="{{$echipa['id']}}">{{$echipa['numeEchipa']}}</option>
                @endforeach
            </select> </div>
        <div class="formular-row"><label> Numar: </label> <input type="text" name="numar" value="{{ old('numar') }}"> @if ($errors->has('numar')) {{ $errors->first('numar') }} @endif </div>
        <div class="formular-row"><label> Varsta: </label> <input type="text" name="varsta" value="{{ old('varsta') }}"> @if ($errors->has('varsta')) {{ $errors->first('varsta') }} @endif </div>
        <div class="formular-row"><label> Pozitie: </label>
            <select name="pozitie" id="pozitie">
                <option value="PORTAR"> PORTAR </option>
                <option value="FUNDAS"> FUNDAS </option>
                <option value="MIJLOCAS"> MIJLOCAS </option>
                <option value="ATACANT"> ATACANT </option>
            </select> </div>
        <div class="formular-row"><label> Inaltime: </label> <input type="text" name="inaltime" value="{{ old('inaltime') }}"> @if ($errors->has('inaltime')) {{ $errors->first('inaltime') }} @endif </div>
        <div class="formular-row"><label> Greutate: </label> <input type="text" name="greutate" value="{{ old('greutate') }}"> @if ($errors->has('greutate')) {{ $errors->first('greutate') }} @endif </div>
        <div class="formular-row"><label> Nationalitate: </label>
            <select name="nationalitate" id="nationalitate">
                @foreach ($tari as $tara)
                @if($tara->denumire == 'ROMANIA') <option value="{{$tara->prescurtare}}" selected> {{$tara->denumire}} </option>
                @else <option value="{{$tara->prescurtare}}"> {{$tara->denumire}} </option> @endif
                @endforeach
            </select> </div>
        <div class="formular-row"> <label>Echipa actuala: </label>
            <select name="echipaActuala" id="echipaActuala">
                <option value="1" selected> DA </option>
                <option value="0"> NU </option>
            </select> </div>
        </div>
    <button type="submit" class="submit"> Adaugă </button>
    <button type="button" class="cancel" onclick="window.history.back()">Anulați</button>
</form>

@include('admin/footer')