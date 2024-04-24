@include('admin/header')

<div class="echipe-view-content">

    @if ($errors->any()) <h1 style="background-color:red;">{{$errors->first()}}</h1> @endif
    @if (isset($succes)) <h1 style="background-color:green;">{{$succes}}</h1> @endif

    <div class="table">
        <div class="table-header">
            <div class="table-header-data" style="width: 500px"><h1> NUME ECHIPA </h1></div>
            <div class="table-header-data" style="width: 160px"><h1> Action </h1></div>
        </div>
        @foreach ($echipe as $echipa)
        <div class="table-row">
            <div class="table-row-data" style="width: 500px"><h1>{{$echipa->numeEchipa}}</h1></div>
            <button type="button" class="edit-button" style="width: 80px;" onclick="window.location.href='{{url('admin-echipe-edit/'.$echipa->id)}}';"><h1 style="font-size: 13px">EDITARE</h1></button>
            <button type="button" class="delete-button" style="width: 80px" onclick="if(confirm('Sunteți sigur că doriți să ștergeți înregistrarea?')){ window.location.href = '{{url('admin-echipe-delete/'.$echipa->id)}}'; }"><h1 style="font-size: 13px">ȘTERGE</h1></button>
        </div>
        @endforeach
    </div>

</div>

@include('admin/footer')