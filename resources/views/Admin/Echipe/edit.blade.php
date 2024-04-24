@include('admin/header')

<a href="{{ url()->previous() }}">Înapoi</a>

<h1>Editati echipa:</h1>
@if ($errors->any()) <h1 style="background-color:red; width: 20%;">Ceva nu a mers bine.</h1> @endif

<form method="post" action="{{url('admin-echipe-update')}}">
    @csrf
    <div class="formular">
        <input type="hidden" name="id" value="{{$echipa->id}}"/>
        <div class="formular-row"><label> Nume Echipa: </label> <input type="text" name="numeEchipa" value="{{ $echipa->numeEchipa }}"> @if ($errors->has('numeEchipa')) {{ $errors->first('numeEchipa') }} @endif </div>
        </div>
    <button type="submit" class="submit">Editați</button>
    <button type="button" class="cancel" onclick="window.history.back()">Anulați</button>
</form>

@include('admin/footer')