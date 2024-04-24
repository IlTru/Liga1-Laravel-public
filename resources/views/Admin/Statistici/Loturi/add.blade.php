@include('admin/header')

<form method="post" action="{{url('admin-loturi-store')}}">
    @csrf
    <div class="formular">
        <input type="hidden" name="meciID" value="{{$meciID}}"/>
        <input type="hidden" name="echipaID" value="{{$echipaID}}"/>
        <fieldset>
            <legend> Titulari: </legend>
            @foreach ($jucatori as $jucator)
            <input type="checkbox" name="{{$jucator['id']}}" value="titular">{{$jucator['numar']}}. {{$jucator['numeJucator']}} <br>
            @endforeach
        </fieldset>
        <fieldset>
            <legend> Rezerve: </legend>
            @foreach ($jucatori as $jucator)
            <input type="checkbox" name="{{$jucator['id']}}" value="rezerva">{{$jucator['numar']}}. {{$jucator['numeJucator']}} <br>
            @endforeach
        </fieldset>
    </div>
    <button type="submit" class="submit"> Adauga </button>
    <button type="button" class="cancel" onclick="window.history.back()">Anulați</button>
</form>

@include('admin/footer')