@include('admin/header')

<form method="post" action="{{url('admin-goluri-assisturi-store')}}">
    @csrf
    <div class="formular">
        <input type="hidden" name="meciID" value="{{$meciID}}"/>
        <input type="hidden" name="echipaID" value="{{$echipaID}}"/>
        <div class="formular-row"> <label> Adauga </label>
            <select name="golSauAssist" id="golSauAssist">
                <option value=1> GOL </option>
                <option value=0> ASSIST </option>
            </select>
        </div>
        <div class="formular-row"> <label> Jucator: </label>
            <select name="jucatorID" id="jucatorID">
                @foreach ($jucatori as $jucator)
                <option value={{$jucator->id}}> {{$jucator->numeJucator}} </option>
                @endforeach
            </select>
        </div>
        <div class="formular-row"><label> Minut: </label> <input type="text" name="minut" value="{{ old('minut') }}"> @if ($errors->has('minut')) {{ $errors->first('minut') }} @endif </div>
        <div class="formular-row"> <label> Tip (Gol): </label>
            <select name="tipGol" id="tipGol">
                <option value=""></option>
                <option value="careu"> GOL DIN CAREU </option>
                <option value="distanta"> GOL DIN AFARA CAREULUI </option>
                <option value="faza fixa"> GOL DIN FAZA FIXA </option>
                <option value="cap"> GOL CU CAPUL </option>
                <option value="penalty"> GOL DIN PENALTY</option>
            </select>
        </div>
        <div class="formular-row"> <label> Tip (Assist): </label>
            <select name="tipAssist" id="tipAssist">
                <option value=""></option>
                <option value="pasa"> PASA SIMPLA </option>
                <option value="distanta"> PASA LUNGA </option>
                <option value="faza fixa"> PASA DIN FAZA FIXA </option>
                <option value="corner"> PASA DIN CORNER </option>
            </select>
        </div>
    </div>
    <button type="submit" class="submit"> Adauga </button>
    <button type="button" class="cancel" onclick="window.history.back()">Anulați</button>
</form>

@include('admin/footer')