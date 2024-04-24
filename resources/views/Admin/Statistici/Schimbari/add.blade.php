@include('admin/header')

<h1> Adauga schimbare </h1>
@if ($errors->any()) <h1 style="background-color:red; width: 20%;">Ceva nu a mers bine.</h1> @endif
<form method="post" action="{{url('admin-schimbari-store')}}">
    @csrf
    <div class="formular">
        <input type="hidden" name="meciID" value="{{$meciID}}"/>
        <input type="hidden" name="echipaID" value="{{$echipaID}}"/>
        <div class="formular-row"> <label> Jucator schimbat: </label>
            <select name="jucatorSchimbatID" id="jucatorSchimbatID">
                @foreach ($jucatori as $jucator)
                <option value={{$jucator->id}}> {{$jucator->numeJucator}} </option>
                @endforeach
            </select>
            @if ($errors->has('jucatorSchimbatID')) {{ $errors->first('jucatorSchimbatID') }} @endif
        </div>
        <div class="formular-row"> <label> Jucator intrat: </label>
            <select name="jucatorIntratID" id="jucatorIntratID">
                @foreach ($jucatori as $jucator)
                <option value={{$jucator->id}}> {{$jucator->numeJucator}} </option>
                @endforeach
            </select>
        </div>
        <div class="formular-row"><label> Minut: </label> <input type="text" name="minut" value="{{ old('minut') }}"> @if ($errors->has('minut')) {{ $errors->first('minut') }} @endif </div>
    </div>
    <button type="submit" class="submit"> Adauga </button>
    <button type="button" class="cancel" onclick="window.history.back()">Anulați</button>
</form>

@include('admin/footer')