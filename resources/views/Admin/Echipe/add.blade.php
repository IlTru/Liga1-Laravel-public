@include('admin/header')

<h1>Adaugati noua echipa:</h1>

@if ($errors->any()) <h1 style="background-color:red; width: 20%;">Ceva nu a mers bine.</h1> @endif

<form method="post" action="{{url('admin-echipe-store')}}">
    @csrf
    <div class="formular">
        <div class="formular-row"><label> Nume Echipa: </label> <input type="text" name="numeEchipa" value="{{ old('numeEchipa') }}"> @if ($errors->has('numeEchipa')) {{ $errors->first('numeEchipa') }} @endif </div>
    </div>
    <button type="submit" class="submit">Adauga</button>
    <button type="button" class="cancel" onclick="window.history.back()">Anulați</button>
</form>

@include('admin/footer')