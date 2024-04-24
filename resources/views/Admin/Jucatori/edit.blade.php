@include('admin/header')

<a href="admin-jucatori-index"><-back</a>
<h1>Editati jucatorul:</h1>
@if ($errors->any()) <h1 style="background-color:red; width: 20%;">Ceva nu a mers bine.</h1> @endif

<?php //ddd($echipe[0]->numeEchipa); ?>

<form method="post" action="{{url('admin-jucatori-update')}}">
    @csrf
    <div class="formular">
        <input type="hidden" name="id" value="{{ $jucator->id }}"/>
        <div class="formular-row"><label> Nume jucator: </label> <input type="text" name="numeJucator" value="{{ $jucator->numeJucator }}"> @if ($errors->has('numeJucator')) {{ $errors->first('numeJucator') }} @endif </div>
        <div class="formular-row"><label> Nume echipa: </label>
            <select name="echipaID" id="echipaID">
                @foreach ($echipe as $echipa)
                @if ($jucator->echipaID == $echipa->id) <option value="{{ $echipa->id }}" selected>{{ $echipa->numeEchipa }}</option>
                @else <option value="{{ $echipa->id }}">{{ $echipa->numeEchipa }}</option>
                @endif
                @endforeach
            </select> </div>
        <div class="formular-row"><label> Numar: </label> <input type="text" name="numar" value="{{ $jucator->numar }}"> @if ($errors->has('numar')) {{ $errors->first('numar') }} @endif </div>
        <div class="formular-row"><label> Varsta: </label> <input type="text" name="varsta" value="{{ $jucator->varsta }}"> @if ($errors->has('varsta')) {{ $errors->first('varsta') }} @endif </div>
        <div class="formular-row"> <label>Pozitie: </label>
            <select name="pozitie" id="pozitie">
                @if ($jucator->pozitie == 'PORTAR') <option value="PORTAR" selected> PORTAR </option> @else <option value="PORTAR"> PORTAR </option> @endif
                @if ($jucator->pozitie == 'FUNDAS') <option value="FUNDAS" selected> FUNDAS </option> @else <option value="FUNDAS"> FUNDAS </option> @endif
                @if ($jucator->pozitie == 'MIJLOCAS') <option value="MIJLOCAS" selected> MIJLOCAS </option> @else <option value="MIJLOCAS"> MIJLOCAS </option> @endif
                @if ($jucator->pozitie == 'ATACANT') <option value="ATACANT" selected> ATACANT </option> @else <option value="ATACANT"> ATACANT </option> @endif
            </select> </div>
        <div class="formular-row"><label> Inaltime: </label> <input type="text" name="inaltime" value="{{ $jucator->inaltime }}"> @if ($errors->has('inaltime')) {{ $errors->first('inaltime') }} @endif </div>
        <div class="formular-row"><label> Greutate: </label> <input type="text" name="greutate" value="{{ $jucator->greutate }}"> @if ($errors->has('greutate')) {{ $errors->first('greutate') }} @endif </div>
        <div class="formular-row"><label> Nationalitate: </label>
            <select name="nationalitate" id="nationalitate">
                @foreach($tari as $tara)
                @if ($jucator->nationalitate == $tara->prescurtare) <option value="{{$tara->prescurtare}}" selected> {{$tara->denumire}} </option> @else <option value="{{$tara->prescurtare}}"> {{$tara->denumire}} </option> @endif
                @endforeach
            </select> </div>
        </div>
        <div class="formular-row"> <label>Echipa actuala: </label>
            <select name="echipaActuala" id="echipaActuala">
                <option value="1" @if ($jucator->echipaActuala == '1') selected @endif> DA </option>
                <option value="0" @if ($jucator->echipaActuala == '0') selected @endif> NU </option>
            </select> </div>
    </div>
    <button type="submit" class="submit">Editati</button>
    <button type="button" class="cancel" onclick="window.history.back()">Anulați</button>
</form>

@include('admin/footer')