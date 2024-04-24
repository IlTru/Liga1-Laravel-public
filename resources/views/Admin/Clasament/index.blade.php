@include('admin/header')

<div class="clasament-view-content">

    @if(count($clasament))
    <div class="table">
        <div class="table-header"> 
            <div class="table-header-data" style="width: 100px"><h1> POZITIE </h1></div>
            <div class="table-header-data" style="width: 300px"><h1> ECHIPA </h1></div>
            <div class="table-header-data" style="width: 100px"><h1> MECIURI JUCATE </h1></div>
            <div class="table-header-data" style="width: 150px"><h1> VICTORII </h1></div>
            <div class="table-header-data" style="width: 150px"><h1> EGALURI </h1></div>
            <div class="table-header-data" style="width: 150px"><h1> INFRANGERI </h1></div>
            <div class="table-header-data" style="width: 150px"><h1> PUNCTE </h1></div>
            <div class="table-header-data" style="width: 150px"><h1><a href="admin-clasament-refresh/{{$clasament[0]->faza}}"> REFRESH </a></h1></div>
        </div>
        @foreach($clasament as $echipa)
        <div class="table-row">
            <div class="table-row-data" style="width: 100px"><h1>{{$echipa->pozitie}}</h1></div>
            <div class="table-row-data" style="width: 300px"><h1>{{$echipe[$echipa->echipaID]}}</h1></div>
            <div class="table-row-data" style="width: 100px"><h1> {{$echipa->meciuriJucate}} </h1></div>
            <div class="table-row-data" style="width: 150px"><h1><button class="minus" onclick="window.location.href='clasament-update/{{$clasament[0]->faza}}/{{$echipa->echipaID}}/victorii/minus';">-1</button> {{$echipa->victorii}} <button class="plus" onclick="window.location.href='clasament-update/{{$clasament[0]->faza}}/{{$echipa->echipaID}}/victorii/plus';">+1</button></h1></div>
            <div class="table-row-data" style="width: 150px"><h1><button class="minus" onclick="window.location.href='clasament-update/{{$clasament[0]->faza}}/{{$echipa->echipaID}}/egaluri/minus';">-1</button> {{$echipa->egaluri}} <button class="plus" onclick="window.location.href='clasament-update/{{$clasament[0]->faza}}/{{$echipa->echipaID}}/egaluri/plus';">+1</button></h1></div>
            <div class="table-row-data" style="width: 150px"><h1><button class="minus" onclick="window.location.href='clasament-update/{{$clasament[0]->faza}}/{{$echipa->echipaID}}/infrangeri/minus';">-1</button> {{$echipa->infrangeri}} <button class="plus" onclick="window.location.href='clasament-update/{{$clasament[0]->faza}}/{{$echipa->echipaID}}/infrangeri/plus';">+1</button></h1></div>
            <div class="table-row-data" style="width: 150px"><h1> {{$echipa->punctaj}} </h1></div>
        </div>
        @endforeach
    </div>
    @else
    <h2>Nu exista informatii.</h2>
    @endif

</div>

@include('admin/footer')