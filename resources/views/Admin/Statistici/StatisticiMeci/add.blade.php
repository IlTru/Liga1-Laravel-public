@include('admin/header')

<h3>Adauga statistici la meciul cu ID-ul {{$meciID}} </h3>

@if ($errors->any()) <h1 style="background-color:red; width: 20%;">Ceva nu a mers bine.</h1> @endif

<form method="post" action="{{url('admin-statistici-store')}}">
    @csrf
    <div class="formular">
        <input type="hidden" name="meciID" value="{{$meciID}}"/>
        <div class="formular-row"><label> Suturi {{ $echipaGazda }}: </label> <input type="text" name="suturiEG" value="{{ old('suturiEG') }}"> @if ($errors->has('suturiEG')) {{ $errors->first('suturiEG') }} @endif </div>
        <div class="formular-row"><label> Suturi {{ $echipaOaspete }}: </label> <input type="text" name="suturiEO" value="{{ old('suturiEO') }}"> @if ($errors->has('suturiEO')) {{ $errors->first('suturiEO') }} @endif </div>
        <div class="formular-row"><label> Suturi pe poarta {{ $echipaGazda }}: </label> <input type="text" name="suturiPePoartaEG" value="{{ old('suturiPePoartaEG') }}"> @if ($errors->has('suturiPePoartaEG')) {{ $errors->first('suturiPePoartaEG') }} @endif </div>
        <div class="formular-row"><label> Suturi pe poarta {{ $echipaOaspete }}: </label> <input type="text" name="suturiPePoartaEO" value="{{ old('suturiPePoartaEO') }}"> @if ($errors->has('suturiPePoartaEO')) {{ $errors->first('suturiPePoartaEO') }} @endif </div>
        <div class="formular-row"><label> Posesie {{ $echipaGazda }}: </label> <input type="text" name="posesieEG" value="{{ old('posesieEG') }}"> @if ($errors->has('posesieEG')) {{ $errors->first('posesieEG') }} @endif </div>
        <div class="formular-row"><label> Posesie {{ $echipaOaspete }}: </label> <input type="text" name="posesieEO" value="{{ old('posesieEO') }}"> @if ($errors->has('posesieEO')) {{ $errors->first('posesieEO') }} @endif </div>
        <div class="formular-row"><label> Cartonase galbene {{ $echipaGazda }}: </label> <input type="text" name="cartonaseGalbeneEG" value="{{ old('cartonaseGalbeneEG') }}"> @if ($errors->has('cartonaseGalbeneEG')) {{ $errors->first('cartonaseGalbeneEG') }} @endif </div>
        <div class="formular-row"><label> Cartonase galbene {{ $echipaOaspete }}: </label> <input type="text" name="cartonaseGalbeneEO" value="{{ old('cartonaseGalbeneEO') }}"> @if ($errors->has('cartonaseGalbeneEO')) {{ $errors->first('cartonaseGalbeneEO') }} @endif </div>
        <div class="formular-row"><label> Cartonase rosii {{ $echipaGazda }}: </label> <input type="text" name="cartonaseRosiiEG" value="{{ old('cartonaseRosiiEG') }}"> @if ($errors->has('cartonaseRosiiEG')) {{ $errors->first('cartonaseRosiiEG') }} @endif </div>
        <div class="formular-row"><label> Cartonase rosii {{ $echipaOaspete }}: </label> <input type="text" name="cartonaseRosiiEO" value="{{ old('cartonaseRosiiEO') }}"> @if ($errors->has('cartonaseRosiiEO')) {{ $errors->first('cartonaseRosiiEO') }} @endif </div>
        <div class="formular-row"><label> Total pase reusite {{ $echipaGazda }}: </label> <input type="text" name="totalPaseEG" value="{{ old('totalPaseEG') }}"> @if ($errors->has('totalPaseEG')) {{ $errors->first('totalPaseEG') }} @endif </div>
        <div class="formular-row"><label> Total pase reusite {{ $echipaOaspete }}: </label> <input type="text" name="totalPaseEO" value="{{ old('totalPaseEO') }}"> @if ($errors->has('totalPaseEO')) {{ $errors->first('totalPaseEO') }} @endif </div>
        <div class="formular-row"><label> Faulturi {{ $echipaGazda }}: </label> <input type="text" name="faulturiEG" value="{{ old('faulturiEG') }}"> @if ($errors->has('faulturiEG')) {{ $errors->first('faulturiEG') }} @endif </div>
        <div class="formular-row"><label> Faulturi {{ $echipaOaspete }}: </label> <input type="text" name="faulturiEO" value="{{ old('faulturiEO') }}"> @if ($errors->has('faulturiEO')) {{ $errors->first('faulturiEO') }} @endif </div>
        <div class="formular-row"><label> Deposedari {{ $echipaGazda }}: </label> <input type="text" name="deposedariEG" value="{{ old('deposedariEG') }}"> @if ($errors->has('deposedariEG')) {{ $errors->first('deposedariEG') }} @endif </div>
        <div class="formular-row"><label> Deposedari {{ $echipaOaspete }}: </label> <input type="text" name="deposedariEO" value="{{ old('deposedariEO') }}"> @if ($errors->has('deposedariEO')) {{ $errors->first('deposedariEO') }} @endif </div>
        <div class="formular-row"><label> Cornere {{ $echipaGazda }}: </label> <input type="text" name="cornereEG" value="{{ old('cornereEG') }}"> @if ($errors->has('cornereEG')) {{ $errors->first('cornereEG') }} @endif </div>
        <div class="formular-row"><label> Cornere {{ $echipaOaspete }}: </label> <input type="text" name="cornereEO" value="{{ old('cornereEO') }}"> @if ($errors->has('cornereEO')) {{ $errors->first('cornereEO') }} @endif </div>
    </div>
    <button type="submit" class="submit"> Adauga </button>
    <button type="button" class="cancel" onclick="window.history.back()">Anulați</button>
</form>

@include('admin/footer')