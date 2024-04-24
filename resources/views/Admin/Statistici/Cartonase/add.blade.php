@include('admin/header')

<form method="post" action="{{url('admin-cartonase-store')}}">
    @csrf
    <div class="formular">
        <input type="hidden" name="meciID" value="{{$meciID}}"/>
        <input type="hidden" name="echipaID" value="{{$echipaID}}"/>
        <div class="formular-row"> <label> Culoare cartonas: </label>
            <select name="culoareCartonas" id="culoareCartonas">
                <option value=1> ROSU </option>
                <option value=0 selected> GALBEN </option>
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
    </div>
    <button type="submit" class="submit"> Adauga </button>
    <button type="button" class="cancel" onclick="window.history.back()">Anulați</button>
</form>

@include('admin/footer')