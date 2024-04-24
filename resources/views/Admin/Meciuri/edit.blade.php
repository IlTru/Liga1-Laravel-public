@include('admin/header')

<a href="admin-meciuri-index"><-back</a>
<h1>Editati meciul:</h1>
@if ($errors->any()) <h1 style="background-color:red; width: 20%;">Ceva nu a mers bine.</h1> @endif

<form method="post" action="{{url('admin-meciuri-update')}}">
    @csrf
    <div class="formular">
        <input type="hidden" name="id" value="{{ $meci->id }}"/>
        <div class="formular-row"><label> Faza: </label>
            <select name="faza" id="faza">
                @if ($meci->faza == 'sezon regulat') <option value="sezon regulat" selected> SEZON REGULAT </option>
                @else <option value = 'sezon regulat'> SEZON REGULAT </option> @endif
                @if ($meci->faza == 'play off') <option value="play off" selected> PLAY OFF </option>
                @else <option value= 'play off'> PLAY OFF </option> @endif
                @if ($meci->faza == 'play out') <option value="play out" selected> PLAY OUT </option>
                @else <option value= 'play out'> PLAY OUT </option> @endif
            </select>
        </div>
        <div class="formular-row"><label> Numar etapa: </label>
            <select name="nrEtapa" id="nrEtapa">
                @for ($i = 0; $i<=30; $i++)
                    @if ($meci->nrEtapa == $i) {<option value="{{$i}}" selected> {{$i}} </option>}
                    @else {<option value="{{$i}}"> {{$i}} </option>} @endif
                @endfor
            </select>
        </div>
        <div class="formular-row"><label> Disputat: </label>
            <select name="disputat" id="disputat">
                @if ($meci->disputat == 1) <option value="da" selected> DA </option>
                @else <option value="da"> DA </option> @endif
                @if ($meci->disputat == 0) <option value="nu" selected> NU </option>
                @else <option value="nu"> NU </option> @endif
            </select>
        </div>
        <div class="formular-row"><label> Data: </label> <input type="datetime-local" name="data" value="{{ $meci->data }}" min="2022-01-01" max="2023-12-31"> @if ($errors->has('data')) {{ $errors->first('data') }} @endif </div>
        <div class="formular-row"><label> Echipa gazda: </label>
            <select name="echipaGazdaID" id="echipaGazdaID">
                @foreach ($echipe as $echipa)
                @if ($meci->echipaGazdaID == $echipa->id) <option value="{{$echipa->id}}" selected>{{$echipa->numeEchipa}}</option>
                @else <option value="{{$echipa->id}}">{{$echipa->numeEchipa}}</option> @endif
                @endforeach
            </select>
        </div>
        <div class="formular-row"> <label> Goluri echipa gazda: </label>
            <select name="goluriEG" id="goluriEG">
                @for ($i = 0; $i <=16; $i++)
                @if ($meci->goluriEG == $i) <option value="{{$i}}" selected> {{$i}} </option>
                @else <option value="{{$i}}"> {{$i}} </option> @endif
                @endfor
            </select>
        </div>
        <div class="formular-row"><label> Echipa oaspete: </label>
            <select name="echipaOaspeteID" id="echipaOaspeteID">
                @foreach ($echipe as $echipa)
                @if ($meci->echipaOaspeteID == $echipa->id) <option value="{{ $echipa->id }}" selected>{{ $echipa->numeEchipa }}</option>
                @else <option value="{{ $echipa->id }}">{{ $echipa->numeEchipa }}</option> @endif
                @endforeach
            </select>
        </div>
        <div class="formular-row"> <label> Goluri echipa gazda: </label>
            <select name="goluriEO" id="goluriEO">
                @for ($i = 0; $i <=16; $i++)
                @if ($meci->goluriEO == $i) <option value="{{$i}}" selected> {{$i}} </option>
                @else <option value="{{$i}}"> {{$i}} </option> @endif
                @endfor
            </select>
        </div>
    </div>
    <button type="submit" class="submit">Actualizează</button>
    <button type="button" class="cancel" onclick="window.history.back()">Anulați</button>
</form>

@include('admin/footer')