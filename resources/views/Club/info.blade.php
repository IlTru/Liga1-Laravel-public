@include('club/header')
    <div class="lineup-container">
        @foreach($jucatori as $jucator)
            <a href="/Liga1/public/jucator-info/{{$club->numeEchipa}}/{{$jucator->numeJucator}}/statistici-generale"><button><img alt="{{$jucator->numeJucator}}" src="/Liga1/public/images/players/{{$jucator->numeJucator}}.png" onerror="this.onerror=null; this.src='/Liga1/public/images/players/face-icon.png'"><h3> {{$jucator->numeJucator}} </h3></button></a>
        @endforeach
    </div>
</div>
@include('footer')